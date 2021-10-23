<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;

class ProductController extends BaseController
{
    protected $category;
    protected $product;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
    }

    public function showDetail($productSlug, $id)
    {
        $row = $this->product->getProductDetail($productSlug, $id);
        $data['breadcrumbs'] = $this->category->show_breadcumb($row->categoryID, true);
        $data['row'] = $row;
        $data['ecommerce'] = true;
        return view('frontend/product/threads', $data);
    }
}
