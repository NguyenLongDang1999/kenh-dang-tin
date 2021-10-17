<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{
    protected $category;

	public function __construct()
	{
		$this->category = new Category();
	}

    public function index()
	{
		$data['getCategoryList'] = $this->category->getCategoryList();
		return view('frontend/category/index', $data);
	}
}
