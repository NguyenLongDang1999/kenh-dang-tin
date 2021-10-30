<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends BaseController
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
		$data['getCategoryList'] = $this->category->getCategoryList();
		return view('frontend/category/index', $data);
	}

	public function newProduct()
	{
		$input = $this->request->getGet();
		$data['getProductNews'] = $this->product->getProductCategory($input, false);
		$data['countProduct'] = $this->product->getProductCategory($input, true);
		$data['pager'] = $this->product->pager;
		$data['input'] = $input;
		$data['is_ecommerce_page'] = true;
		return view('frontend/category/newProduct', $data);
	}

	public function vipProduct()
	{
		$input = $this->request->getGet();
		$data['getProductFeatured'] = $this->product->getProductCategory($input, false, true);
		$data['countProduct'] = $this->product->getProductCategory($input, true, true);
		$data['pager'] = $this->product->pager;
		$data['input'] = $input;
		$data['is_ecommerce_page'] = true;
		return view('frontend/category/vipProduct', $data);
	}

	public function category($slug, $id)
	{
		$row = $this->category->getShowCategory($slug, $id);
		$listCatId = $this->category->getCategoryRecursive($row->id);
		$getCategoryList = $this->category->getCategoryList($row->id);

		$data['getCategoryList'] = count($getCategoryList) ? $getCategoryList :
			$this->category->getCategoryList($row->parent_id);

		// Filter
		$input = $this->request->getGet();
		$data['getProductShowByCat'] = $this->product->getProductShowByCat($input, false, $listCatId);
		$data['countProduct'] = $this->product->getProductShowByCat($input, true, $listCatId);
		$data['pager'] = $this->product->pager;
		$data['row'] = $row;
		$data['breadcrumbs'] = $this->category->show_breadcumb($row->id);
		$data['input'] = $input;
		$data['is_ecommerce_page'] = true;
		return view('frontend/category/category', $data);
	}
}
