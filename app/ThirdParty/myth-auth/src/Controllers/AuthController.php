<?php

namespace Myth\Auth\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class AuthController extends Controller
{
	protected $auth;

	/**
	 * @var AuthConfig
	 */
	protected $config;

	/**
	 * @var Session
	 */
	protected $session;

	public function __construct()
	{
		// Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = service('session');
		helper(['form', 'html', 'auth', 'main']);
		$this->config = config('Auth');
		$this->auth = service('authentication');
	}

	//--------------------------------------------------------------------
	// Login/out
	//--------------------------------------------------------------------

	/**
	 * Displays the login form, or redirects
	 * the user to their destination/home if
	 * they are already logged in.
	 */
	public function login()
	{
		if ($this->auth->check()) {
			return redirect()->route('user.home.index');
		}

		return $this->_render($this->config->views['login'], ['config' => $this->config]);
	}

	/**
	 * Attempts to verify the user's credentials
	 * through a POST request.
	 */
	public function attemptLogin()
	{
		$rules = [
			'login'	=> 'required',
			'password' => 'required',
		];
		if ($this->config->validFields == ['email']) {
			$rules['login'] .= '|valid_email';
		}

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');
		$remember = (bool)$this->request->getPost('remember');

		// Try to log them in...
		if (!$this->auth->attempt(['email' => $login, 'password' => $password], $remember)) {
			return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
		}

		// Is the user being forced to reset their password?
		if ($this->auth->user()->force_pass_reset === true) {
			return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
		}

		return redirect()->route('user.auth.userProfile')->withCookies()->with('message', lang('Auth.loginSuccess'));
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		if ($this->auth->check()) {
			$this->auth->logout();
		}

		return redirect()->route('login');
	}

	//--------------------------------------------------------------------
	// Register
	//--------------------------------------------------------------------

	/**
	 * Displays the user registration page.
	 */
	public function register()
	{
		if ($this->auth->check()) {
			return redirect()->back();
		}

		return $this->_render($this->config->views['register'], ['config' => $this->config]);
	}

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		$users = model(UserModel::class);

		// Save the user
		$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
		$user = new User($this->request->getPost($allowedPostFields));

		$this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

		// Ensure default group gets assigned if set
		if (!empty($this->config->defaultUserGroup)) {
			$users = $users->withGroup($this->config->defaultUserGroup);
		}

		if (!$users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		if ($this->config->requireActivation !== null) {
			$activator = service('activator');
			$sent = $activator->send($user);

			if (!$sent) {
				return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
			}

			// Success!
			return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	//--------------------------------------------------------------------
	// Forgot Password
	//--------------------------------------------------------------------

	/**
	 * Displays the forgot password form.
	 */
	public function forgotPassword()
	{
		return $this->_render($this->config->views['forgot'], ['config' => $this->config]);
	}

	/**
	 * Attempts to find a user account with that password
	 * and send password reset instructions to them.
	 */
	public function attemptForgot()
	{
		$users = model(UserModel::class);

		$throttler = service('throttler');

		if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
			if (service('response')->setStatusCode(429)) {
				return redirect()->back()->withInput()->with('error', 'B???n kh??ng th??? g???i y??u c???u li??n t???c. Vui l??ng ch??? ' . $throttler->getTokentime() . ' gi??y');
			}
		}

		$user = $users->where('email', $this->request->getPost('email'))->first();

		if (is_null($user)) {
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Save the reset hash /
		$user->generateResetHash();
		$users->save($user);

		$resetter = service('resetter');
		$sent = $resetter->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $resetter->error() ?? lang('Auth.unknownError'));
		}

		return redirect()->route('reset-password')->with('message', lang('Auth.forgotEmailSent'));
	}

	/**
	 * Displays the Reset Password form.
	 */
	public function resetPassword()
	{
		$token = $this->request->getGet('token');

		return $this->_render($this->config->views['reset'], [
			'config' => $this->config,
			'token'  => $token,
		]);
	}

	/**
	 * Verifies the code with the email and saves the new password,
	 * if they all pass validation.
	 *
	 * @return mixed
	 */
	public function attemptReset()
	{
		$users = model(UserModel::class);

		$users->logResetAttempt(
			$this->request->getPost('email'),
			$this->request->getPost('token'),
			$this->request->getIPAddress(),
			(string)$this->request->getUserAgent()
		);

		$user = $users->where('email', $this->request->getPost('email'))
			->where('reset_hash', $this->request->getPost('token'))
			->first();

		if (is_null($user)) {
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Reset token still valid?
		if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
			return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
		}

		// Success! Save the new password, and cleanup the reset hash.
		$user->password 		= $this->request->getPost('password');
		$user->reset_hash 		= null;
		$user->reset_at 		= date('Y-m-d H:i:s');
		$user->reset_expires    = null;
		$user->force_pass_reset = false;
		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.resetSuccess'));
	}

	/**
	 * Activate account.
	 *
	 * @return mixed
	 */
	public function activateAccount()
	{
		$users = model(UserModel::class);

		// First things first - log the activation attempt.
		$users->logActivationAttempt(
			$this->request->getGet('token'),
			$this->request->getIPAddress(),
			(string) $this->request->getUserAgent()
		);

		$throttler = service('throttler');

		if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$user->activate();

		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	/**
	 * Resend activation account.
	 *
	 * @return mixed
	 */
	public function resendActivateAccount()
	{
		if ($this->config->requireActivation === null) {
			return redirect()->route('login');
		}

		$throttler = service('throttler');

		if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$login = urldecode($this->request->getGet('login'));
		$type = 'email';

		$users = model(UserModel::class);

		$user = $users->where($type, $login)
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$activator = service('activator');
		$sent = $activator->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
	}

	protected function _render(string $view, array $data = [])
	{
		return view($view, $data);
	}

	public function checkExistsEmail()
	{
		$users = model(UserModel::class);
		$email = $this->request->getPost('email');
		$result = $users->select('email')->where('email', $email)->countAllResults();
		$valid = $result > 0 ? false : true;
		return $this->response->setJSON([
			'valid' => $valid,
		]);
	}

	public function userProfile()
	{
		return view('frontend/user/userProfile');
	}

	public function updateProfile()
	{
		$users = model(UserModel::class);

		$input = $this->request->getPost([
			'fullname',
			'job',
			'phone',
			'address',
			'birthdate',
			'gender',
			'checkImg'
		]);

		$file = $this->request->getFile('avatar');
		if ($file) {
			$resize = [
				'resizeX' => '120',
				'resizeY' => '120',
			];
			$image = uploadOneFile($file, PATH_USER_IMAGE, $resize, true, $input['checkImg']);

			$input['avatar'] = !is_null($image) ? $image : $input['checkImg'];
		}
		$input['id'] = user_id();
		$users->save($input);
		return redirect()->route('user.auth.userProfile')->with("message", 'C???p nh???t th??ng tin th??nh c??ng!');
	}

	public function updatePassword()
	{
		$config = config('Auth');
		$users = model(UserModel::class);

		$hashOptions = [
			'cost' => $config->hashCost
		];

		if (!password_verify(base64_encode(hash('sha384', $this->request->getPost('password'), true)), user()->password_hash)) {
			return redirect()->route('user.auth.userProfile')->with('error', "M???t kh???u c?? nh???p kh??ng ch??nh x??c. Vui l??ng th??? l???i!");
		}

		$new_password = password_hash(
			base64_encode(
				hash('sha384', $this->request->getPost('new_password'), true)
			),
			$config->hashAlgorithm,
			$hashOptions
		);
		$user['id'] = user_id();
		$user['password_hash'] = $new_password;
		$users->save($user);
		return redirect()->route('user.auth.userProfile')->with("message", 'M???t kh???u ???? ???????c c???p nh???t th??nh c??ng!');
	}

	public function updateEmail()
	{
		$users = model(UserModel::class);
		$user = $users->where('id', user_id())->first();
		if (!password_verify(base64_encode(hash('sha384', $this->request->getPost('password_current'), true)), $user->password_hash)) {
			return redirect()->route('user.auth.edit')->with('error', "M???t kh???u c?? nh???p kh??ng ch??nh x??c. Vui l??ng th??? l???i!");
		}

		if (is_null($user)) {
			return redirect()->route('user.auth.userProfile')->with('error', lang('Auth.activationNoUser'));
		}


		$user->new_email = $this->request->getPost('email');
		$user->activate_hash = bin2hex(random_bytes(16));
		$users->save($user);

		if ($this->config->requireActivation !== false) {
			$activator = service('activator');
			$user->email = $user->new_email;
			$user->active_new_email = true;
			$sent = $activator->send($user);

			if (!$sent) {
				return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
			}

			// Success!
			return redirect()->route('user.auth.userProfile')->with('message', lang('Auth.activationSuccess'));
		}

		// Success!
		return redirect()->route('user.auth.userProfile')->with('message', lang('Auth.registerSuccess'));
	}

	public function deleteImageUser()
	{
		if ($this->request->isAJAX()) {
			$users = model(UserModel::class);

			$image = $this->request->getPost('url_img');
			$result['avatar'] = NULL;

			if (strpos($image, 'https') === false) {
				$convert = explode('/', $image);
				$getEndConvert = end($convert);
			}

			if ($users->update(user_id(), $result)) {
				$data['result'] = true;

				if (strpos($image, 'https') === false) {
					deleteImage(PATH_USER_IMAGE, $getEndConvert);
				}

				return json_encode($data);
			}

			$data['result'] = false;
			$data['message'] = '<span class="text-capitalize">C?? l???i x???y ra trong qu?? tr??nh x??a h??nh ???nh.</span>';
			return json_encode($data);
		}
	}
}
