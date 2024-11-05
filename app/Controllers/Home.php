<?php

namespace App\Controllers;

use App\Models\PostModel; // PostModel을 사용하기 위해 추가합니다.

class Home extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index()
    {
        // 카테고리 목록을 가져옵니다.
        $categories = [
            99 => '공지사항',  // 공지사항을 맨 위에 위치시킴
            1 => '퐁코 토론',
            2 => '퐁코 이슈',
            3 => '탈코리아 게시판',
            4 => '자유 게시판',
            5 => '유머 게시판',
            6 => '죽창 게시판'
        ];
        
        // 각 카테고리별로 5개의 게시글을 가져옵니다.
        $postsByCategory = [];
        
        // 공지사항을 먼저 가져옵니다.
        $posts = $this->postModel->where('category', 99)
                                 ->where('is_deleted', 'N')
                                 ->orderBy('created_at', 'DESC') // 최신 순으로 정렬
                                 ->findAll(5); // 5개만 가져오기
        $postsByCategory['공지사항'] = $posts; // 공지사항 게시글 저장

        // 나머지 카테고리를 반복하여 게시글을 가져옵니다.
        foreach ($categories as $categoryId => $categoryName) {
            if ($categoryId == 99) continue; // 이미 공지사항을 처리했으므로 건너뜁니다.

            $posts = $this->postModel->where('category', $categoryId)
                                     ->where('is_deleted', 'N')
                                     ->orderBy('created_at', 'DESC') // 최신 순으로 정렬
                                     ->findAll(5); // 5개만 가져오기
            $postsByCategory[$categoryName] = $posts; // 카테고리별 게시글 저장
        }

        return view('index', [
            'categories' => $categories,
            'postsByCategory' => $postsByCategory // 뷰에 게시글 목록을 전달
        ]);
    }
}
