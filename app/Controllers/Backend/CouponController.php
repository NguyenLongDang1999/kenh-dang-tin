<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Coupon;

class CouponController extends BaseController
{
    protected $coupon;

    public function __construct()
    {
        $this->coupon = new Coupon();
    }

    public function index()
    {
        return view('backend/coupon/index');
    }

    public function getList()
    {
        $input = $this->request->getGet();
        $data = array();

        $results = $this->coupon->getList($input);

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

        $data['aaData'] = array();
        if (count($results['model']) > 0) {
            foreach ($results['model'] as $row) {

                $data['aaData'][] = [
                    'checkbox'          => '',
                    'responsive_id'     => '',
                    'responsive_id'     => esc($row->id),
                    'infoCoupon'        => $this->infoCoupon($row->code, $row->price_discount, $row->code_limit, $row->expiration_date),
                    'user_used'         => esc($row->user_used),
                    'status'            => esc($row->status),
                    'created_at'        => esc(getDateTime($row->created_at)),
                    'updated_at'        => esc(getDateTime($row->updated_at)),
                    'title'             => esc($row->code),
                    'editPages'         => route_to('admin.coupon.edit', $row->id)
                ];
            }
        }

        return json_encode($data);
    }

    public function create()
    {
        return view('backend/coupon/create_edit');
    }

    public function store()
    {
        $input = $this->request->getPost([
            'code',
            'price_discount',
            'code_limit',
            'expiration_date',
            'price_payment_limit',
            'status',
            'code_description'
        ]);

        if (is_null($input['status'])) {
            $input['status'] = STATUS_INACTIVE;
        }

        $this->coupon->insert($input);
        return redirect()->route('admin.coupon.index')->with('success', "Coupon <strong class='text-capitalize'>" . esc($input['code']) . "</strong> đã được thêm.");
    }

    public function edit($id)
    {
        $data['row'] = $this->coupon->getDetailCoupon($id);
        return view('backend/coupon/create_edit', $data);
    }

    public function update($id)
    {
        $input = $this->request->getPost([
            'code',
            'price_discount',
            'code_limit',
            'expiration_date',
            'price_payment_limit',
            'status',
            'code_description'
        ]);

        if (is_null($input['status'])) {
            $input['status'] = STATUS_INACTIVE;
        }

        $this->coupon->update($id, $input);
        return redirect()->route('admin.coupon.index')->with('success', "Coupon <strong class='text-capitalize'>" . esc($input['code']) . "</strong> đã được thêm.");
    }

    public function multiStatus()
    {
        $input = $this->request->getPost('data');
        $status = $this->request->getPost('status');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
            if ($this->coupon->update($result['chk'], ['status' => $status])) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function multiPurgeDestroy()
    {
        $input = $this->request->getPost('data');
        parse_str($input, $result);

        if (isset($result['chk']) && is_array($result['chk'])) {
            if ($this->coupon->delete($result['chk'], true)) {
                $data['result'] = true;
                $data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
                return json_encode($data);
            }
        }

        $data['result'] = false;
        return json_encode($data);
    }

    public function checkExists()
    {
        $code = $this->request->getPost('code');
        $result = $this->coupon->checkExists($code);
        $valid = $result > 0 ? false : true;
        return $this->response->setJSON([
            'valid' => $valid,
        ]);
    }

    private function infoCoupon($code, $price_discount, $code_limit, $expiration_date)
    {
        $html = '';
        $html .= '<ul class="list-unstyled">';
        $html .= '<li class="pb-25">Code: <span class="text-bold-500">' . esc($code) . '</span></li>';
        $html .= '<li class="pb-25">Số tiền giảm giá: <span class="text-bold-500">' . esc($price_discount) . '</span></li>';
        $html .= '<li class="pb-25">Giới hạn nhập: <span class="text-bold-500">' . esc($code_limit) . '</span></li>';
        $html .= '<li class="pb-25">Ngày hết hạn: <span class="text-bold-500">' . esc(getDateTime($expiration_date)) . '</span></li>';
        $html .= '</ul>';
        return $html;
    }
}
