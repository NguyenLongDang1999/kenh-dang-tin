<?php

namespace App\Models;

use CodeIgniter\Model;

class Comment extends Model
{
    protected $table                = 'comment';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;

    protected $allowedFields        = [
        'body', 'user_id', 'product_id', 'rating', 'status', 'deleted_at'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    public function getCommentByProduct($product_id, $page = 1)
    {
        return $this->select('
			comment.body, comment.id, comment.created_at,
			users.avatar, users.fullname')
            ->join('users', 'users.id = comment.user_id')
            ->where('users.active', STATUS_ACTIVE)
            ->where('comment.status', STATUS_ACTIVE)
            ->where('comment.product_id', $product_id)
            ->orderBy('comment.created_at', 'desc')
            ->paginate(5, 'group1', $page);
    }

    public function checkCommentProductExists($product_id)
    {
        return $this->select('comment.id')
            ->join('users', 'users.id = comment.user_id')
            ->where('users.active', STATUS_ACTIVE)
            ->where('comment.status', STATUS_ACTIVE)
            ->where('comment.product_id', $product_id)
            ->orderBy('comment.created_at', 'desc')
            ->countAllResults();
    }

    public function getSumRatingComment($product_id)
    {
        return $this->select('rating')
            ->where('product_id', $product_id)
            ->where('status', STATUS_ACTIVE)
            ->findAll();
    }
}
