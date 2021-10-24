<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table                = 'product';
    protected $primaryKey           = 'id';
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'name',
        'slug',
        'sku',
        'image',
        'image_list',
        'small_description',
        'large_description',
        'quantity',
        'cat_id',
        'brand_id',
        'number_buy',
        'sale',
        'price',
        'view',
        'featured',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getList($input = array())
    {
        $model = $this->select('
            product.id, product.name, product.view, product.image, product.status, product.created_at,
            product.price, product.sale, product.featured,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('product.name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('product.status', $input['search']['status']);
        }

        if (isset($input['search']['cat_id']) && $input['search']['cat_id'] != "") {
            $model->where('product.cat_id', $input['search']['cat_id']);
        }

        if (isset($input['search']['featured']) && $input['search']['featured'] != "") {
            $model->where('product.featured', $input['search']['featured']);
        }

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '7' => 'product.created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayLength'], $input['iDisplayStart']);

        return $result;
    }

    public function getListRecycle($input = array())
    {
        $model = $this->select('
            product.id, product.name, product.view, product.image, product.status, product.created_at,
            product.price, product.sale, product.featured,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->onlyDeleted();

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '6' => 'product.created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayLength'], $input['iDisplayStart']);

        return $result;
    }

    public function getMultiProduct($id)
    {
        return $this->select('image, image_list')->whereIn('id', $id)->withDeleted()->findAll();
    }

    public function getDetailProduct($id, $recycle = false)
    {
        $model = $this->select('
            id, name, cat_id, price, sale, brand_id, small_description, large_description, sku, quantity, featured,
            meta_title, meta_keyword, meta_description, image, status, image_list
        ');

        if ($recycle) $model->withDeleted();
        return $model->find($id);
    }

    public function checkExists($slug)
    {
        return $this->select('id')->where('slug', $slug)->countAllResults();
    }

    public function getProductHome($featured = false)
    {
        $model = $this->select('
            product.image, product.slug, product.name, product.price, product.featured, product.view, 
            product.id, product.created_at, product.sale, product.small_description, product.sku,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->where('product.status', STATUS_ACTIVE)
            ->where('category.status', STATUS_ACTIVE)
            ->orderBy('product.created_at', 'desc');

        if ($featured) {
            $model = $model->where('product.featured', FEATURED_ACTIVE);
        } else {
            $model = $model->where('product.featured', FEATURED_INACTIVE);
        }

        return $model->findAll(10);
    }

    public function getProductCategory($input = array(), $count = false, $is_vip = false)
    {
        $query = $this->select('
            product.image, product.slug, product.name, product.price, product.featured, product.view, 
            product.id, product.created_at, product.sale, product.small_description, product.sku,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->where('product.status', STATUS_ACTIVE)
            ->where('category.status', STATUS_ACTIVE);

        if ($is_vip) {
            $query = $query->where('product.featured', FEATURED_ACTIVE);
        }

        if (isset($input['price_range']) && $input['price_range'] != '') {
            if ($input['price_range'] == 1) {
                $query = $query->where('product.price <=', 1000000);
            }

            if ($input['price_range'] == 2) {
                $query = $query->where('product.price >=', 1000000);
                $query = $query->where('product.price <=', 100000000);
            }

            if ($input['price_range'] == 3) {
                $query = $query->where('product.price >=', 100000000);
                $query = $query->where('product.price <=', 1000000000);
            }

            if ($input['price_range'] == 4) {
                $query = $query->where('product.price >=', 1000000000);
            }
        }

        if (isset($input['sort_filter']) && $input['sort_filter'] != '') {
            if ($input['sort_filter'] == 0) {
                $query = $query->orderBy('product.created_at', 'desc');
            }

            if ($input['sort_filter'] == 1) {
                $query = $query->orderBy('product.created_at', 'asc');
            }

            if ($input['sort_filter'] == 2) {
                $query = $query->orderBy('product.view', 'asc');
            }

            if ($input['sort_filter'] == 3) {
                $query = $query->orderBy('product.view', 'desc');
            }

            if ($input['sort_filter'] == 4) {
                $query = $query->orderBy('product.price', 'asc');
            }

            if ($input['sort_filter'] == 5) {
                $query = $query->orderBy('product.price', 'desc');
            }

            if ($input['sort_filter'] == 6) {
                $query = $query->orderBy('product.name', 'asc');
            }

            if ($input['sort_filter'] == 7) {
                $query = $query->orderBy('product.name', 'desc');
            }
        } else {
            $query = $query->orderBy('product.created_at', 'desc');
        }

        if ($count) {
            $query = $query->countAllResults();
        } else {
            if (isset($input['paginate']) && $input['paginate'] != '') {
                $query = $query->paginate($input['paginate']);
            } else {
                $query = $query->paginate(18);
            }
        }

        return $query;
    }

    public function getSearchProduct($input = array(), $count = false)
    {
        $query = $this->select('
            product.image, product.slug, product.name, product.price, product.featured, product.view, 
            product.id, product.created_at, product.sale, product.small_description, product.sku,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->where('product.status', STATUS_ACTIVE)
            ->where('category.status', STATUS_ACTIVE)
            ->like('product.name', trim($input['s']))
            ->orLike('product.sku', trim($input['s']));

        if (isset($input['price_range']) && $input['price_range'] != '') {
            if ($input['price_range'] == 1) {
                $query = $query->where('product.price <=', 1000000);
            }

            if ($input['price_range'] == 2) {
                $query = $query->where('product.price >=', 1000000);
                $query = $query->where('product.price <=', 100000000);
            }

            if ($input['price_range'] == 3) {
                $query = $query->where('product.price >=', 100000000);
                $query = $query->where('product.price <=', 1000000000);
            }

            if ($input['price_range'] == 4) {
                $query = $query->where('product.price >=', 1000000000);
            }
        }

        if (isset($input['sort_filter']) && $input['sort_filter'] != '') {
            if ($input['sort_filter'] == 0) {
                $query = $query->orderBy('product.created_at', 'desc');
            }

            if ($input['sort_filter'] == 1) {
                $query = $query->orderBy('product.created_at', 'asc');
            }

            if ($input['sort_filter'] == 2) {
                $query = $query->orderBy('product.view', 'asc');
            }

            if ($input['sort_filter'] == 3) {
                $query = $query->orderBy('product.view', 'desc');
            }

            if ($input['sort_filter'] == 4) {
                $query = $query->orderBy('product.price', 'asc');
            }

            if ($input['sort_filter'] == 5) {
                $query = $query->orderBy('product.price', 'desc');
            }

            if ($input['sort_filter'] == 6) {
                $query = $query->orderBy('product.name', 'asc');
            }

            if ($input['sort_filter'] == 7) {
                $query = $query->orderBy('product.name', 'desc');
            }
        } else {
            $query = $query->orderBy('product.created_at', 'desc');
        }

        if ($count) {
            $query = $query->countAllResults();
        } else {
            if (isset($input['paginate']) && $input['paginate'] != '') {
                $query = $query->paginate($input['paginate']);
            } else {
                $query = $query->paginate(18);
            }
        }

        return $query;
    }

    public function getProductShowByCat($input = array(), $count = false, $listCatid)
    {
        $str = "";
        foreach ($listCatid as $item) {
            $str .= " cat_id = $item OR";
        }
        $str = rtrim($str, 'OR ');
        $query = $this->select('
            product.image, product.slug, product.name, product.price, product.featured, product.view, 
            product.id, product.created_at, product.sale, product.small_description, product.sku,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->where('category.status', STATUS_ACTIVE)
            ->where('product.status', STATUS_ACTIVE)
            ->orderBy('product.created_at', 'desc')
            ->groupStart()
            ->where($str)
            ->groupEnd();

        if (isset($input['price_range']) && $input['price_range'] != '') {
            if ($input['price_range'] == 1) {
                $query = $query->where('product.price <=', 1000000);
            }

            if ($input['price_range'] == 2) {
                $query = $query->where('product.price >=', 1000000);
                $query = $query->where('product.price <=', 100000000);
            }

            if ($input['price_range'] == 3) {
                $query = $query->where('product.price >=', 100000000);
                $query = $query->where('product.price <=', 1000000000);
            }

            if ($input['price_range'] == 4) {
                $query = $query->where('product.price >=', 1000000000);
            }
        }

        if (isset($input['sort_filter']) && $input['sort_filter'] != '') {
            if ($input['sort_filter'] == 0) {
                $query = $query->orderBy('product.created_at', 'desc');
            }

            if ($input['sort_filter'] == 1) {
                $query = $query->orderBy('product.created_at', 'asc');
            }

            if ($input['sort_filter'] == 2) {
                $query = $query->orderBy('product.view', 'asc');
            }

            if ($input['sort_filter'] == 3) {
                $query = $query->orderBy('product.view', 'desc');
            }

            if ($input['sort_filter'] == 4) {
                $query = $query->orderBy('product.price', 'asc');
            }

            if ($input['sort_filter'] == 5) {
                $query = $query->orderBy('product.price', 'desc');
            }

            if ($input['sort_filter'] == 6) {
                $query = $query->orderBy('product.name', 'asc');
            }

            if ($input['sort_filter'] == 7) {
                $query = $query->orderBy('product.name', 'desc');
            }
        } else {
            $query = $query->orderBy('product.created_at', 'desc');
        }

        if ($count) {
            $query = $query->countAllResults();
        } else {
            if (isset($input['paginate']) && $input['paginate'] != '') {
                $query = $query->paginate($input['paginate']);
            } else {
                $query = $query->paginate(18);
            }
        }

        return $query;
    }

    public function getProductDetail($productSlug, $id)
    {
        return $this->select('
            product.name, product.id, product.image_list, product.image, product.view, product.featured, product.price,
            product.sale, product.small_description, product.large_description, product.sku,
            category.id as categoryID')
            ->join('category', 'category.id = product.cat_id')
            ->where('category.status', STATUS_ACTIVE)
            ->where('product.status', STATUS_ACTIVE)
            ->where('product.slug', $productSlug)
            ->where('product.id', $id)
            ->orderBy('product.created_at', 'desc')
            ->first();
    }

    public function getProductRelated($cat_id, $id)
    {
        return $this->select('
            product.image, product.slug, product.name, product.price, product.featured, product.view, 
            product.id, product.created_at, product.sale, product.small_description, product.sku,
            category.name as catName')
            ->join('category', 'category.id = product.cat_id')
            ->where('product.status', STATUS_ACTIVE)
            ->where('category.status', STATUS_ACTIVE)
            ->where('product.cat_id', $cat_id)
            ->where('product.id !=', $id)
            ->orderBy('product.created_at', 'desc')
            ->findAll(5);
    }
}
