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
        $search = $this->request->getGet('search');

        $query = $this->postModel->where('is_deleted', 'N');

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->groupStart()
                ->like('title', $search)
                ->orLike('content', $search)
                ->orLike('nickname', $search)
                ->groupEnd();
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);
        $posts = $this->attachReplyCountsAndDate($posts); // 댓글 수와 날짜 추가

        $data = [
            'posts' => $posts,
            'category' => $category,
            'categoryName' => $categoryName,
            'search' => $search,
            'pager' => $this->postModel->pager,
        ];

        return view('posts/index', $data);
    }

    private function attachReplyCountsAndDate($posts)
    {
        foreach ($posts as &$post) {
            $post['reply_count'] = $this->replyModel->where('post_id', $post['id'])->countAllResults();
            $post['created_at'] = date('Y-m-d', strtotime($post['created_at']));
        }
        return $posts;
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
            $file = $files["image$i"];
            if ($file->isValid() && !$file->hasMoved()) {
                // 10MB 이하인지 확인
                if ($file->getSize() > 10 * 1024 * 1024) { // 10MB
                    echo "<script>alert('이미지 {$i}이(가) 10MB를 초과했습니다.'); history.back();</script>";
                    exit;
                }
    
                // 이미지 파일인지 확인 (GIF, PNG, JPEG 등만 허용)
                $mimeType = $file->getMimeType();
                if (!in_array($mimeType, ['image/gif', 'image/jpeg', 'image/png'])) {
                    echo "<script>alert('이미지 {$i}은(는) 허용되지 않는 형식입니다. GIF, PNG, JPEG 파일만 가능합니다.'); history.back();</script>";
                    exit;
                }
    
                $fileName = $file->getRandomName();
                $file->move($uploadPath, $fileName);
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
    public function ajaxLike($id)
    {
        if ($this->request->isAJAX()) {
            $userIp = $this->request->getIPAddress();
            
            // 사용자가 이미 비추천했는지 확인
            $disliked = $this->db->table('post_likes')
                                 ->where(['post_id' => $id, 'user_ip' => $userIp, 'is_like' => false])
                                 ->get()
                                 ->getRow();
            
            if ($disliked) {
                return $this->response->setJSON(['success' => false, 'message' => '이미 비추천한 게시글입니다. 비추천을 취소하고 다시 시도하세요.']);
            }
            
            // 사용자가 이미 추천했는지 확인
            $existing = $this->db->table('post_likes')
                                 ->where(['post_id' => $id, 'user_ip' => $userIp, 'is_like' => true])
                                 ->get()
                                 ->getRow();
    
            if ($existing) {
                return $this->response->setJSON(['success' => false, 'message' => '이미 추천한 게시글입니다.']);
            }
    
            $post = $this->postModel->find($id);
            $this->db->table('post_likes')->insert([
                'post_id' => $id,
                'user_ip' => $userIp,
                'is_like' => true,
            ]);
    
            $this->postModel->update($id, ['likes' => $post['likes'] + 1]);
            return $this->response->setJSON(['success' => true, 'likes' => $post['likes'] + 1]);
        }
        return $this->response->setJSON(['success' => false, 'message' => '추천 요청에 실패했습니다']);
    }
    
    public function ajaxDislike($id)
    {
        if ($this->request->isAJAX()) {
            $userIp = $this->request->getIPAddress();
            
            // 사용자가 이미 추천했는지 확인
            $liked = $this->db->table('post_likes')
                              ->where(['post_id' => $id, 'user_ip' => $userIp, 'is_like' => true])
                              ->get()
                              ->getRow();
    
            if ($liked) {
                return $this->response->setJSON(['success' => false, 'message' => '이미 추천한 게시글입니다. 추천을 취소하고 다시 시도하세요.']);
            }
    
            // 사용자가 이미 비추천했는지 확인
            $existing = $this->db->table('post_likes')
                                 ->where(['post_id' => $id, 'user_ip' => $userIp, 'is_like' => false])
                                 ->get()
                                 ->getRow();
    
            if ($existing) {
                return $this->response->setJSON(['success' => false, 'message' => '이미 비추천한 게시글입니다.']);
            }
    
            $post = $this->postModel->find($id);
            $this->db->table('post_likes')->insert([
                'post_id' => $id,
                'user_ip' => $userIp,
                'is_like' => false,
            ]);
    
            $this->postModel->update($id, ['dislikes' => $post['dislikes'] + 1]);
            return $this->response->setJSON(['success' => true, 'dislikes' => $post['dislikes'] + 1]);
        }
        return $this->response->setJSON(['success' => false, 'message' => '비추천 요청에 실패했습니다']);
    }
}    