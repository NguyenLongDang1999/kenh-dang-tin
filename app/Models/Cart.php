<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $table                = 'cart';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = false;

    protected $allowedFields        = [
        'user_id', 'product_id', 'quantity'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    public function cartExists($product_id, $user_id)
    {
        return $this->select('id, quantity')
            ->where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->find();
    }
}
