<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AdminGuard
 * -------------------------------------------------------------
 * 관리용 페이지(/analytics 등)를 외부로부터 보호합니다.
 *
 * - 기본: IP 화이트리스트로 접근 허용
 *   .env 에 `admin.allowedIps` 콤마 구분으로 지정 가능
 *   예) admin.allowedIps = 127.0.0.1,::1,211.123.45.6
 * - 허용되지 않은 요청은 404 로 위장(존재 사실 숨김)
 * - 검색엔진에 노출되지 않도록 X-Robots-Tag 헤더도 함께 설정
 */
class AdminGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ip  = $request->getIPAddress();

        $raw = getenv('admin.allowedIps') ?: '127.0.0.1,::1';
        $allowed = array_filter(array_map('trim', explode(',', $raw)));

        if (! in_array($ip, $allowed, true)) {
            return service('response')
                ->setStatusCode(404)
                ->setHeader('X-Robots-Tag', 'noindex, nofollow')
                ->setBody('Not Found');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
