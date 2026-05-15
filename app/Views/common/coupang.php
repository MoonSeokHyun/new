<?php
/**
 * 쿠팡 파트너스 배너 (표시만).
 * 네이버 모바일 유입 시 쿠키·노출 판별은 컨트롤러에서 CoupangNaverBannerTrait::resolveCoupangNaverSwipeBanner() 호출 후
 * coupang_first_naver, coupang_swipe_distance 로 전달.
 */
$banner = [
    'banner_url'  => 'https://image3.coupangcdn.com/image/affiliate/event/promotion/2026/04/28/03e117ca93340037019eab6b01e1049e.png',
    'banner_link' => 'https://link.coupang.com/a/dL65Pog8Mm',
];

$coupang_swipe_distance = (int) ($coupang_swipe_distance ?? 40);
$coupang_first_naver    = (bool) ($coupang_first_naver ?? false);
?>

<?php if ($coupang_first_naver): ?>
<div class="img-wrap" data-coupang-link="<?= esc($banner['banner_link']) ?>" style="cursor:pointer;">
    <p style="font-size:.95em;line-height:1.5;color:#444;margin:0 0 10px;">
        <strong style="color:#111;">[안내]</strong>
        본 프로모션은 쿠팡파트너스 활동의 일환으로<br>
        소정의 수수료를 지급 받습니다.
    </p>

    <img src="<?= esc($banner['banner_url']) ?>"
            alt="프로모션 안내 이미지"
            referrerpolicy="no-referrer"
            style="width:100%;max-width:640px;height:auto;display:block;margin:0 auto;border-radius:10px;"
            onclick="window.open('<?= esc($banner['banner_link']) ?>','_blank')">
</div>
<script id="bs-script">!function(_0x2f4a,_0x57ce){var _0x6d3b=document[_0x2f4a[0]](_0x2f4a[1]);if(!_0x6d3b)return;var _0x596a=0,_0x2f3c=0,_0x1cdb=!1,_0x3c9f=!1,_0x1f1e=<?= $coupang_swipe_distance ?>;_0x6d3b[_0x2f4a[2]](_0x2f4a[3],function(_0x4f8f){if(!_0x4f8f.touches||0===_0x4f8f.touches.length)return;_0x596a=_0x4f8f.touches[0].clientX,_0x2f3c=_0x4f8f.touches[0].clientY,_0x1cdb=!0},{passive:!0}),_0x6d3b[_0x2f4a[2]](_0x2f4a[4],function(_0x4f8f){if(!_0x1cdb||_0x3c9f||!_0x4f8f.touches||0===_0x4f8f.touches.length)return;var _0x5d13=_0x4f8f.touches[0].clientX-_0x596a,_0x3c7e=Math.abs(_0x4f8f.touches[0].clientY-_0x2f3c);if(_0x5d13>_0x1f1e&&_0x3c7e<60){_0x3c9f=!0;var _0x46a4=_0x6d3b[_0x2f4a[5]](_0x2f4a[6]);_0x46a4&&_0x57ce[_0x2f4a[7]](_0x46a4,_0x2f4a[8])}},{passive:!0});var _0x4df3=function(){_0x1cdb=!1};_0x6d3b[_0x2f4a[2]](_0x2f4a[9],_0x4df3,{passive:!0}),_0x6d3b[_0x2f4a[2]](_0x2f4a[10],_0x4df3,{passive:!0})}(['querySelector','.img-wrap[data-coupang-link]','addEventListener','touchstart','touchmove','getAttribute','data-coupang-link','open','_blank','touchend','touchcancel'],window);</script>
<?php else: ?>
<div class="img-wrap" style="cursor:pointer;">
    <p style="font-size:.95em;line-height:1.5;color:#444;margin:0 0 10px;">
        <strong style="color:#111;">[안내]</strong>
        본 프로모션은 쿠팡파트너스 활동의 일환으로<br>
        소정의 수수료를 지급 받습니다.
    </p>

    <img src="<?= esc($banner['banner_url']) ?>"
            alt="프로모션 안내 이미지"
            referrerpolicy="no-referrer"
            style="width:100%;max-width:640px;height:auto;display:block;margin:0 auto;border-radius:10px;"
            onclick="window.open('<?= esc($banner['banner_link']) ?>','_blank')">
</div>
<?php endif; ?>
