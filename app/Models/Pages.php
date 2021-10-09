<?php

namespace App\Models;

use CodeIgniter\Model;

class Pages extends Model
{
    protected $table                = 'pages';
    protected $primaryKey           = 'id';
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = [
        'name',
        'url',
        'description',
        'sort',
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
        $model = $this->select('id, name, url, status, created_at, updated_at')->orderBy('sort', 'asc');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('status', $input['search']['status']);
        }

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'name',
                '5' => 'created_at',
                '6' => 'updated_at',
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
        $model = $this->select('id, name, url, created_at, updated_at')->onlyDeleted();

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'name',
                '4' => 'created_at',
                '5' => 'updated_at',
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

    public function getDetailPages($id, $recycle = false)
    {
        $model = $this->select('id, name, description, meta_title, meta_keyword, meta_description, status');
        if ($recycle) $model->withDeleted();
        return $model->find($id);
    }

    public function getReorderPages()
    {
        return $this->select('id, name')
            ->where('status', STATUS_ACTIVE)
            ->orderBy('sort', 'asc')
            ->findAll();
    }

    public function checkExists($slug)
    {
        $model = $this->select('id')
            ->where('url', $slug)
            ->countAllResults();

        return $model;
    }
}
