<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Views/common/coupang.php 용: 네이버 모바일 유입이면서 아직 쿠키가 없을 때만
 * 스와이프형 배너(coupang_first_naver) 노출 후 쿠키로 재노출 제한.
 */
trait CoupangNaverBannerTrait
{
    private string $coupangNaverCookieName = 'ppk_coupang_nm';

    /**
     * @return array{coupang_first_naver: bool, coupang_swipe_distance: int}
     */
    protected function resolveCoupangNaverSwipeBanner(int $swipeDistancePx = 40): array
    {
        $swipeDistancePx = max(10, min(200, $swipeDistancePx));

        $referer = $this->request->getHeaderLine('Referer');
        $ua      = $this->request->getUserAgent()->getAgentString();

        $cookieVal = $this->request->getCookie($this->coupangNaverCookieName);
        $alreadySeen = $cookieVal !== null && $cookieVal !== '';

        $firstNaver = ! $alreadySeen
            && $this->isLikelyMobileUserAgent($ua)
            && $this->referrerLooksLikeNaver($referer);

        if ($firstNaver) {
            // 초단위 TTL (ResponseTrait: 양수면 현재 시각 + 초)
            $this->response->setCookie(
                $this->coupangNaverCookieName,
                '1',
                86400 * 180,
                '',
                '/',
                '',
                null,
                false,
                'Lax'
            );
        }

        return [
            'coupang_first_naver'    => $firstNaver,
            'coupang_swipe_distance' => $swipeDistancePx,
        ];
    }

    protected function isLikelyMobileUserAgent(?string $userAgent): bool
    {
        if ($userAgent === null || $userAgent === '') {
            return false;
        }

        return (bool) preg_match('/Mobile|Android|iPhone|webOS|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
    }

    protected function referrerLooksLikeNaver(string $referer): bool
    {
        if ($referer === '') {
            return false;
        }

        $host = parse_url($referer, PHP_URL_HOST);
        if (! is_string($host) || $host === '') {
            return false;
        }

        $host = strtolower($host);

        return str_ends_with($host, 'naver.com')
            || str_ends_with($host, 'naver.jp')
            || $host === 'naver.me'
            || str_ends_with($host, '.naver.me');
    }
}
