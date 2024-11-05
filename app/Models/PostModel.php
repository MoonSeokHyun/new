<?php

namespace App\Models;
use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'content', 'image1', 'image2', 'image3', 'image4', 'image5',
        'view_count', 'likes', 'dislikes', 'created_at', 'password', 'is_deleted', 'category', 'nickname'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
