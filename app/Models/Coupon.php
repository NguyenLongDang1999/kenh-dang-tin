<?php

namespace App\Models;

use CodeIgniter\Model;

class Coupon extends Model
{
    protected $table                = 'coupon';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = false;

    protected $allowedFields        = [
        'code', 'price_discount', 'code_limit', 'user_used', 'expiration_date', 'price_payment_limit', 'code_description', 'status',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    public function getList($input = array())
    {
        $model = $this->select('id, code, price_discount, code_limit, expiration_date, price_payment_limit, user_used, status, created_at, updated_at');

        if (isset($input['search']['code']) && $input['search']['code'] != "") {
            $model->like('code', trim($input['search']['code']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('status', $input['search']['status']);
        }

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
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

    public function getDetailCoupon($id, $recycle = false)
    {
        $model = $this->select('id, code, price_discount, code_limit, expiration_date, price_payment_limit, code_description, status');
        if ($recycle) $model->withDeleted();
        return $model->find($id);
    }

    public function checkExists($code)
    {
        $model = $this->select('id')
            ->where('code', $code)
            ->countAllResults();

        return $model;
    }
}
