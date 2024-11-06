<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\ReplyModel; // 댓글 모델 추가
use CodeIgniter\Database\Exceptions\DatabaseException;

class Posts extends BaseController
{
    protected $postModel;
    protected $replyModel;
    protected $db;
    protected $categories = [
        99 => '공지사항',  // 공지사항을 맨 위에 위치시킴
        9 => '베스트',
        1 => '퐁코 토론',
        8 => '퐁코 이슈',
        4 => '자유 게시판',
        7 => '유머 게시판'
    ];

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->replyModel = new ReplyModel(); // 댓글 모델 초기화
        $this->db = \Config\Database::connect();
    }

    // 게시글 목록 (카테고리 필터링 추가)
    public function index()
    {
        $category = $this->request->getGet('category');
        $categoryName = $this->categories[$category] ?? '전체';

        // 검색어 처리
        $search = $this->request->getGet('search');

        $query = $this->postModel->where('is_deleted', 'N');

        if ($category) {
            $query->where('category', $category);
        }

        // 제목, 내용, 닉네임으로 검색
        if ($search) {
            $query->groupStart()
                ->like('title', $search)
                ->orLike('content', $search)
                ->orLike('nickname', $search)
                ->groupEnd();
        }

        $data['posts'] = $query->orderBy('id', 'ASC')->paginate(10); // 페이지당 10개씩
        $data['category'] = $category;
        $data['categoryName'] = $categoryName;
        $data['search'] = $search; // 검색어를 뷰에 전달
        $data['pager'] = $this->postModel->pager; // 페이징 객체 추가

        return view('posts/index', $data);
    }

    // 게시글 작성 페이지 (카테고리 자동 설정)
    public function create()
    {
        $category = $this->request->getGet('category');
        $data['category'] = $category;
        return view('posts/create', $data);
    }

    public function store()
    {
        $category = $this->request->getPost('category');
        $content = $this->request->getPost('content');
        $nickname = $this->request->getPost('nickname'); // 닉네임 필드 추가

        $dateFolder = date('Y-m-d');
        $uploadPath = FCPATH . 'uploads/' . $dateFolder;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $files = $this->request->getFiles();
        for ($i = 1; $i <= 5; $i++) {
            if ($files["image$i"]->isValid() && !$files["image$i"]->hasMoved()) {
                $fileName = $files["image$i"]->getRandomName();
                $files["image$i"]->move($uploadPath, $fileName);
                $imagePath = '/uploads/' . $dateFolder . '/' . $fileName;
                $content .= "<p><img src='{$imagePath}' alt='Uploaded Image'></p>";
            }
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $content,
            'nickname' => $nickname,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'category' => $category,
        ];

        $this->postModel->insert($data);
        return redirect()->to("/posts?category={$category}")
                         ->with('alert', '게시글이 성공적으로 등록되었습니다.');
    }

    // 게시글 상세 조회
    public function show($id)
    {
        $post = $this->postModel->find($id);
        if ($post['is_deleted'] === 'Y') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // 현재 글의 조회수 증가
        $this->postModel->update($id, ['view_count' => $post['view_count'] + 1]);

        // 댓글과 대댓글 가져오기
        $replies = $this->replyModel->getRepliesByPostId($id);

        // 카테고리 ID 가져오기
        $categoryId = $post['category'];

        // 동일 카테고리 내에서 이전 글 찾기
        $previousPost = $this->postModel->where('id <', $id)
                                         ->where('category', $categoryId)
                                         ->where('is_deleted', 'N')
                                         ->orderBy('id', 'DESC')
                                         ->first();

        // 동일 카테고리 내에서 다음 글 찾기
        $nextPost = $this->postModel->where('id >', $id)
                                     ->where('category', $categoryId)
                                     ->where('is_deleted', 'N')
                                     ->orderBy('id', 'ASC')
                                     ->first();

        return view('posts/show', [
            'post' => $post,
            'replies' => $replies,
            'previousPost' => $previousPost,
            'nextPost' => $nextPost
        ]);
    }

    // 댓글 추가
    public function addReply()
    {
        $postId = $this->request->getPost('post_id');
        $nickname = $this->request->getPost('nickname');
        $content = $this->request->getPost('content');
        $parentId = $this->request->getPost('parent_id') ?: null; // 부모 댓글 ID

        $data = [
            'post_id' => $postId,
            'nickname' => $nickname,
            'content' => $content,
            'parent_id' => $parentId // 부모 댓글 ID 저장
        ];

        $this->replyModel->insert($data); // 댓글 또는 대댓글 저장
        return redirect()->to("/posts/{$postId}");
    }

    // 게시글 수정
    public function edit($id)
    {
        $data['post'] = $this->postModel->find($id);
        return view('posts/edit', $data);
    }

    public function update($id)
    {
        $password = $this->request->getPost('password');
        $post = $this->postModel->find($id);

        if (password_verify($password, $post['password'])) {
            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'nickname' => $this->request->getPost('nickname'), // 닉네임 업데이트
                'category' => $this->request->getPost('category')
            ];
            $this->postModel->update($id, $data);
            return redirect()->to("/posts/$id");
        } else {
            return redirect()->back()->with('error', '비밀번호가 일치하지 않습니다.');
        }
    }

    // 게시글 삭제
    public function delete($id)
    {
        $password = $this->request->getPost('password');
        $post = $this->postModel->find($id);

        if (password_verify($password, $post['password'])) {
            $this->postModel->update($id, ['is_deleted' => 'Y']);
            return redirect()->to('/posts');
        } else {
            return redirect()->back()->with('error', '비밀번호가 일치하지 않습니다.');
        }
    }

    // 추천 기능
    public function like($id)
    {
        return $this->updateLikeDislike($id, true);
    }

    // 비추천 기능
    public function dislike($id)
    {
        return $this->updateLikeDislike($id, false);
    }

    // 추천/비추천 업데이트 메서드 (중복 확인)
    private function updateLikeDislike($postId, $isLike)
    {
        $userIp = $this->request->getIPAddress();
        $builder = $this->db->table('post_likes');

        $existing = $builder->where([
            'post_id' => $postId,
            'user_ip' => $userIp,
            'is_like' => $isLike
        ])->get()->getRow();

        if ($existing) {
            return redirect()->back()->with('error', '이미 추천하셨습니다.');
        }

        $builder->insert([
            'post_id' => $postId,
            'user_ip' => $userIp,
            'is_like' => $isLike,
        ]);

        $post = $this->postModel->find($postId);
        if ($isLike) {
            $this->postModel->update($postId, ['likes' => $post['likes'] + 1]);
            // 추천 수가 10개 이상이면 카테고리를 베스트로 변경
            if ($post['likes'] + 1 >= 10 && $post['category'] !== 9) {
                $this->postModel->update($postId, ['category' => 9]); // 카테고리 변경
            }
        } else {
            $this->postModel->update($postId, ['dislikes' => $post['dislikes'] + 1]);
        }

        return redirect()->back();
    }
}
