<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Product;
use App\Models\Cart;

class CartController extends BaseController
{
    protected $product;
    protected $cart;

    public function __construct()
    {
        $this->product = new Product();
        $this->cart = new Cart();
    }

    public function index()
    {
        return view('frontend/cart/index');
    }

    public function addToCart()
    {
        if ($this->request->isAjax()) {
			$product_id = $this->request->getPost('product_id');

			$cartExists = $this->cart->cartExists($product_id, user_id());
			$data = [
				'product_id' => $product_id,
				'user_id' => user_id(),
			];

			if (isset($product_id) && $product_id !== null && count($cartExists) === 0) {
				if ($this->cart->insert($data)) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Thêm vào giỏ hàng thành công.</span>';
					return json_encode($data);
				}
			}

			$this->cart->update($cartExists[0]->id, ['quantity' => $cartExists[0]->quantity + 1]);
			$data['result'] = true;
			$data['message'] = '<span class="text-capitalize">Thêm vào giỏ hàng thành công.</span>';
			return json_encode($data);
		}
    }

	public function updateToCart()
    {
        if ($this->request->isAjax()) {
			$cart_id = $this->request->getPost('cart_id');
			$quantity = $this->request->getPost('quantity');

			if (isset($cart_id) && $cart_id !== null) {
				$input = [
					'quantity' => $quantity,
				];

				if ($this->cart->update($cart_id, $input)) {
					$data['result'] = true;
					$data['qty'] = $input['quantity'];
					$data['message'] = '<span class="text-capitalize">Cập nhật vào giỏ hàng thành công.</span>';
					return json_encode($data);
				}
			}

			$data['result'] = false;
			$data['message'] = '<span class="text-capitalize">Lỗi.</span>';
			return json_encode($data);
		}
    }

    public function showCart()
    {
        if ($this->request->isAjax()) {
			$data['getListCart'] = $this->product->getListCart(user_id());
			$data['getListCartCount'] = $this->product->getListCart(user_id(), true);
			return view('components/_show_cart', $data);
		}
    }

	public function showCartPage()
    {
        if ($this->request->isAjax()) {
			$data['getListCart'] = $this->product->getListCart(user_id());
			$data['sum'] = 0;
			return view('components/_cart_page', $data);
		}
    }

	public function deleteCart()
	{
		if ($this->request->isAjax()) {
			$product_id = $this->request->getPost('product_id');

			if (isset($product_id) && $product_id !== null) {
				if ($this->cart->delete($product_id, true)) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Xóa sản phẩm khỏi giỏ hàng thành công.</span>';
					return json_encode($data);
				}
			}

			$data['result'] = false;
			$data['message'] = '<span class="text-capitalize">Lỗi xóa sản phẩm.</span>';
			return json_encode($data);
		}
	}
}
