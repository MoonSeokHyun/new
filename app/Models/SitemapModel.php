<?php

namespace App\Models;

use CodeIgniter\Model;

class SitemapModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'title', 'content', 'view_count', 'likes', 'dislikes', 'created_at', 'updated_at', 'is_deleted', 'category', 'nickname'
    ];

    // 사이트맵용 게시글 데이터를 가져오는 메서드
    public function getPostsForSitemap($limit, $offset)
    {
        return $this->select('id, created_at')
                    ->where('is_deleted', 'N') // 삭제된 게시글 제외
                    ->orderBy('id', 'ASC')
                    ->findAll($limit, $offset);
    }

    // 전체 게시글 수 가져오기
    public function countAllPosts()
    {
        return $this->where('is_deleted', 'N')->countAllResults();
    }
}
