<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;

class HomeController extends BaseController
{
    protected $category;
    protected $product;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
    }

    public function index()
    {
        $data['getListCategory'] = $this->category->getListCategory();
        $data['getProductFeatured'] = $this->product->getProductHome(true);
        $data['getProductNew'] = $this->product->getProductHome();
        return view('frontend/home/index', $data);
    }
}
