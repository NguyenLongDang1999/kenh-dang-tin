<?php

namespace App\Models;

use CodeIgniter\Model;

class Wishlist extends Model
{
    protected $table                = 'wishlist';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;

    protected $allowedFields        = [
        'user_id', 'product_id'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';
}
