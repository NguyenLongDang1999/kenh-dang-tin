<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;

class ProductController extends BaseController
{
    protected $category;
    protected $product;
    protected $comment;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
        $this->comment = new Comment();
    }

    public function showDetail($productSlug, $id)
    {
        $row = $this->product->getProductDetail($productSlug, $id);

        $sessionKey = 'getProductView' . $id;
        $sessionView = session()->get($sessionKey);

        if (!$sessionView) {
            session()->set($sessionKey, 1);
            $input = [
                'view' => $row->view + 1
            ];
            $this->product->update($row->id, $input);
        }

        $sum = 0;
        $getSumRatingComment = $this->comment->getSumRatingComment($id);
        foreach ($getSumRatingComment as $item) {
            $sum += $item->rating;
        }

        $data['gallery'] = explode(',', $row->image_list);
        $data['breadcrumbs'] = $this->category->show_breadcumb($row->categoryID, true);
        $data['getProductRelated'] = $this->product->getProductRelated($row->categoryID, $id);
        $data['getSumRatingComment'] = $getSumRatingComment;
        $data['sum'] = $sum;
        $data['row'] = $row;
        $data['ecommerce'] = true;
        return view('frontend/product/threads', $data);
    }

    public function searchProduct()
    {
        $input = $this->request->getGet();
        if (isset($input['s']) && $input['s'] != "") {
            $data['getSearchProduct'] = $this->product->getSearchProduct($input, false);
            $data['countProduct'] = $this->product->getSearchProduct($input, true);
            $data['pager'] = $this->product->pager;
            $data['input'] = $input;
            $data['is_ecommerce_page'] = true;

            return view('frontend/product/search', $data);
        } else {
            return redirect()->route('user.category.newProduct');
        }
    }
}
