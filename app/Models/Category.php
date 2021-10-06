<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table                = 'category';
    protected $primaryKey           = 'id';
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'sort',
        'status',
        'meta_keyword',
        'meta_description',
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
        $model = $this->select('id, name, image, status, created_at')
            ->where('parent_id', $input['parent_id'])
            ->orderBy('sort', 'asc');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('status', $input['search']['status']);
        }

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '3' => 'name',
                '6' => 'created_at',
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
        $model = $this->select('id, name, image, parent_id, created_at')
            ->onlyDeleted();

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '3' => 'name',
                '5' => 'created_at',
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

    public function getCountSubcategorites($parent_id)
    {
        return $this->select('id')
            ->where('parent_id', $parent_id)
            ->countAllResults();
    }

    public function getParentCategory($parent_id)
    {
        return $this->select('id, name, description, image')
            ->where('parent_id', $parent_id)
            ->where('status', STATUS_ACTIVE)
            ->orderBy('sort', 'asc')
            ->findAll();
    }

    public function getTreeCategory($parent_id = 0, $char = '', $option = '')
    {
        if (!is_array($option)) {
            $option = [
                '' => 'Vui Lòng Chọn',
                0  => '=== Danh Mục Gốc ==='
            ];
        }

        $model = $this->getParentCategory($parent_id);

        foreach ($model as $item) {
            $option[$item->id] = $char . esc($item->name);
            $option = $this->getTreeCategory($item->id, $char . '|--- ', $option);
        }

        return $option;
    }

    public function checkParentCategory($id, $recycle = false)
    {
        $model = $this->select('id')
            ->whereIn('parent_id', $id);
        if ($recycle) $model->withDeleted();
        $model = $model->countAllResults();
        return $model;
    }

    public function getDetailCategory($id, $recycle = false)
    {
        $model = $this->select('id, name, parent_id, description, meta_keyword, meta_description, image, status');
        if ($recycle) $model->withDeleted();
        return $model->find($id);
    }

    public function checkExists($slug)
    {
        $model = $this->select('id')
            ->where('slug', $slug)
            ->countAllResults();

        return $model;
    }

    public function getMultiImageCategory($id)
    {
        return $this->select('image')->whereIn('id', $id)->withDeleted()->findAll();
    }

    public function getListCategoryParent($parent_id = 0)
    {
        $model = $this->getParentCategory($parent_id);

        $option = [
            '' => 'Vui Lòng Chọn',
            0  => '=== Danh Mục Gốc ==='
        ];

        foreach ($model as $item) {
            $option[$item->id] = esc($item->name);
        }

        return $option;
    }
}
