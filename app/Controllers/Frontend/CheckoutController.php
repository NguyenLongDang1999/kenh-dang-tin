<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Product;

class CheckoutController extends BaseController
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {
        $data['getListCart'] = $this->product->getListCart(user_id());
		$data['sum'] = 0;
        return view('frontend/checkout/index', $data);
    }
}
