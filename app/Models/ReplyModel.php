<?php

namespace App\Models;
use CodeIgniter\Model;

class ReplyModel extends Model
{
    protected $table = 'replies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'nickname', 'content', 'parent_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // 대댓글을 포함한 댓글 목록 가져오기
    public function getRepliesByPostId($postId)
    {
        return $this->where('post_id', $postId)
                    ->orderBy('parent_id', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}
