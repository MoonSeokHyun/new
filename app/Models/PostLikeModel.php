<?php

namespace App\Models;

use CodeIgniter\Model;

class PostLikeModel extends Model
{
    protected $table = 'post_likes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'user_ip', 'is_like', 'created_at'];
}
