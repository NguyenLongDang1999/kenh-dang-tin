<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Product;

class CartController extends BaseController
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {
        return view('frontend/cart/index');
    }
}
