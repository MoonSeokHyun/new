<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\ReplyModel;

class Home extends BaseController
{
    protected $postModel;
    protected $replyModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->replyModel = new ReplyModel();
    }

    public function index()
    {
        $categories = [
            99 => '공지사항',
            9 => '베스트',
            1 => '퐁코 토론',
            8 => '퐁코 이슈',
            4 => '자유 게시판',
            7 => '유머 게시판',
        ];

        $postsByCategory = [];

        // 공지사항 가져오기
        $posts = $this->postModel->where('category', 99)
                                 ->where('is_deleted', 'N')
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll(5);

        $posts = $this->attachReplyCountsAndDate($posts); // 댓글 수와 작성 날짜 추가
        $postsByCategory['공지사항'] = $posts;

        // 나머지 카테고리별로 반복
        foreach ($categories as $categoryId => $categoryName) {
            if ($categoryId == 99) continue;

            $posts = $this->postModel->where('category', $categoryId)
                                     ->where('is_deleted', 'N')
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll(5);

            $posts = $this->attachReplyCountsAndDate($posts); // 댓글 수와 작성 날짜 추가
            $postsByCategory[$categoryName] = $posts;
        }

        return view('index', [
            'categories' => $categories,
            'postsByCategory' => $postsByCategory,
        ]);
    }

    private function attachReplyCountsAndDate($posts)
    {
        foreach ($posts as &$post) {
            $post['reply_count'] = $this->replyModel->where('post_id', $post['id'])->countAllResults();
            $post['created_at'] = date('Y-m-d', strtotime($post['created_at'])); // 날짜 형식으로 변환
        }
        return $posts;
    }
}
