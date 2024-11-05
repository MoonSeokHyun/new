<?php

namespace App\Controllers;
use App\Models\PostModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Posts extends BaseController
{
    protected $postModel;
    protected $db;
    protected $categories = [
        1 => '퐁퐁이들 소식',
        2 => '도태남',
        3 => '알파남'
    ];

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->db = \Config\Database::connect();
    }

    // 게시글 목록 (카테고리 필터링 추가)
    public function index()
    {
        $category = $this->request->getGet('category');
        $categoryName = $this->categories[$category] ?? '전체';

        $query = $this->postModel->where('is_deleted', 'N');
        if ($category) {
            $query->where('category', $category);
        }
        
        $data['posts'] = $query->findAll();
        $data['category'] = $category;
        $data['categoryName'] = $categoryName;
        
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
            'nickname' => $nickname, // 닉네임 추가
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'category' => $category,
        ];

        $this->postModel->insert($data);
        return redirect()->to("/posts?category={$category}");
    }
    
    // 게시글 상세 조회
    public function show($id)
    {
        $post = $this->postModel->find($id);
        if ($post['is_deleted'] === 'Y') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $this->postModel->update($id, ['view_count' => $post['view_count'] + 1]);
        return view('posts/show', ['post' => $post]);
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
            return redirect()->back()->with('error', '이미 해당 게시글에 투표하셨습니다.');
        }

        $builder->insert([
            'post_id' => $postId,
            'user_ip' => $userIp,
            'is_like' => $isLike,
        ]);

        $post = $this->postModel->find($postId);
        if ($isLike) {
            $this->postModel->update($postId, ['likes' => $post['likes'] + 1]);
        } else {
            $this->postModel->update($postId, ['dislikes' => $post['dislikes'] + 1]);
        }

        return redirect()->back();
    }
}
