<?php

namespace App\Controllers;

/**
 * 게시판 서비스 종료 – 모든 엔드포인트는 HTTP 410(Gone) 으로 응답하여
 * 검색엔진 색인에서 해당 URL 들이 제거되도록 한다.
 *
 * 라우트는 index / show / create / edit 만 유지한다(Routes.php 참조).
 */
class Posts extends BaseController
{
    public function index()
    {
        return $this->gone('posts/index', 'noindex, follow');
    }

    public function show($id = null)
    {
        return $this->gone('posts/show', 'noindex, follow');
    }

    public function create()
    {
        return $this->gone('posts/create', 'noindex, nofollow');
    }

    public function edit($id = null)
    {
        return $this->gone('posts/edit', 'noindex, nofollow');
    }

    private function gone(string $viewPath, string $robotsTag)
    {
        return $this->response
            ->setStatusCode(410, 'Gone')
            ->setHeader('X-Robots-Tag', $robotsTag)
            ->setBody(view($viewPath));
    }
}
