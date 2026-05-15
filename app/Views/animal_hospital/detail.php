<?php
helper('url');

/* =========================
 * 기본 데이터 정리
 * ========================= */
$hospitalName = esc($hospital['b_name'] ?? '동물병원');
$roadAddress  = esc($hospital['new_address'] ?? '');
$landAddress  = esc($hospital['old_address'] ?? '');
$status       = esc($hospital['b_status'] ?? '');

$addressForUse = trim(html_entity_decode($roadAddress)) ?: trim(html_entity_decode($landAddress));

/* =========================
 * 지역 추출
 * ========================= */
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $addressForUse, $m1);
$district = $m1[0] ?? '지역';

preg_match(
  '/^(서울|부산|대구|인천|광주|대전|울산|세종|경기|강원|충북|충남|전북|전남|경북|경남|제주)[^\s]*/u',
  $addressForUse,
  $m2
);
$region = $m2[0] ?? '대한민국';

/* =========================
 * 좌표 (컨트롤러에서 전달)
 * ========================= */
$lat = (isset($latitude) && is_numeric($latitude)) ? (float)$latitude : null;
$lng = (isset($longitude) && is_numeric($longitude)) ? (float)$longitude : null;

/* =========================
 * Canonical (쿼리 제거)
 * ========================= */
$canonicalUrl = site_url('animal-hospital/detail/' . ($hospital['id'] ?? 0));

/* =========================
 * SEO 메타 (중복 방지)
 * ========================= */
$mix = [];
if ($roadAddress) $mix[] = "도로명 {$roadAddress}";
if ($status)      $mix[] = "상태 {$status}";
if (!$roadAddress && $landAddress) $mix[] = "지번 {$landAddress}";
$mixText = implode(', ', array_slice($mix, 0, 2));

$addrSnippet = $addressForUse ? mb_substr(preg_replace('/\s+/u', ' ', trim($addressForUse)), 0, 40, 'UTF-8') : '';
$seoTitleBase = $addrSnippet !== ''
    ? "{$hospitalName} ({$addrSnippet}) | {$district} 동물병원"
    : "{$hospitalName} | {$district} 동물병원 정보";
$seoTitle = mb_substr($seoTitleBase, 0, 60, 'UTF-8');

$descParts = [];
$descParts[] = "{$district} {$hospitalName} 동물병원";
if ($addrSnippet) $descParts[] = "주소 {$addrSnippet}";
if ($status)      $descParts[] = "영업상태 {$status}";
$descParts[] = "지도 위치와 주변 동물병원도 함께 확인하세요.";
$seoDesc = mb_substr(implode(' · ', $descParts), 0, 155, 'UTF-8');

/* =========================
 * 네이버 지도 Key (JS SDK)
 * ========================= */
$naverMapKeyId = env('NAVER_MAPS_API_KEY_ID', '');
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title><?= esc($seoTitle) ?></title>
<meta name="description" content="<?= esc($seoDesc) ?>" />
<meta name="robots" content="index,follow,max-image-preview:large" />

<link rel="canonical" href="<?= esc($canonicalUrl) ?>" />
<link rel="alternate" href="<?= esc($canonicalUrl) ?>" hreflang="ko" />

<!-- OpenGraph -->
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= esc($seoTitle) ?>" />
<meta property="og:description" content="<?= esc($seoDesc) ?>" />
<meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
<meta property="og:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="퐁퐁코리아 - 전국 생활시설 정보 검색" />
<meta name="twitter:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
<meta property="og:locale" content="ko_KR" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
<meta name="twitter:description" content="<?= esc($seoDesc) ?>" />

<link rel="preconnect" href="https://oapi.map.naver.com" crossorigin>
<link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
<link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>

<?php if ($naverMapKeyId): ?>
<script defer src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpKeyId=<?= esc($naverMapKeyId) ?>"></script>
<?php endif; ?>

<!-- AdSense -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

<!-- =========================
     구조화 데이터 (SEO 핵심)
     ========================= -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VeterinaryCare",
  "@id": "<?= esc($canonicalUrl) ?>#vet",
  "name": <?= json_encode(html_entity_decode($hospitalName)) ?>,
  "url": <?= json_encode($canonicalUrl) ?>,
  "address": {
    "@type": "PostalAddress",
    "streetAddress": <?= json_encode(html_entity_decode($addressForUse)) ?>,
    "addressLocality": <?= json_encode($district) ?>,
    "addressRegion": <?= json_encode($region) ?>,
    "addressCountry": "KR"
  }
  <?php if ($lat !== null && $lng !== null): ?>,
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": <?= json_encode($lat) ?>,
    "longitude": <?= json_encode($lng) ?>
  }
  <?php endif; ?>
}
</script>

<?php include APPPATH . 'Views/includes/detail_theme.php'; ?>
</head>
<body class="detail-page">

<?php include APPPATH.'Views/includes/header.php'; ?>

<div class="container">

  <div class="breadcrumb">
    <a href="<?= site_url() ?>">홈</a> &gt;
    <a href="<?= site_url('animal-hospital') ?>">동물병원 목록</a> &gt; 상세정보
  </div>

  <div class="hero">
    <h1><?= $hospitalName ?></h1>
    <p><?= esc($seoDesc) ?></p>

    <div class="kv" style="margin-top:10px;">
      <?php if ($district): ?><span class="pill">📍 <?= esc($district) ?></span><?php endif; ?>
      <?php if ($status): ?><span class="pill">✅ 상태: <?= esc($status) ?></span><?php endif; ?>
      <?php if ($roadAddress): ?><span class="pill">🛣️ 도로명 있음</span><?php endif; ?>
    </div>

    <div class="actions">
      <a class="btn" href="<?= site_url('animal-hospital?search='.urlencode($district)) ?>">같은 지역 더보기</a>
      <?php if ($addressForUse): ?>
        <a class="btn primary" id="naverDirections" href="#" target="_blank" rel="nofollow noopener">네이버 지도에서 보기</a>
      <?php endif; ?>
      <a class="btn" href="<?= site_url('animal-hospital') ?>">목록</a>
    </div>
  </div>

  <!-- ✅ 광고(1) 최상단 -->
  <div id="ad">
    <ins class="adsbygoogle" style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>

  <div class="grid">

    <div class="card">
      <h2>기본 정보</h2>
      <div class="row"><div class="label">병원명</div><div class="value"><?= $hospitalName ?></div></div>
      <div class="row"><div class="label">주소</div><div class="value"><?= esc($addressForUse) ?></div></div>
      <div class="row"><div class="label">지역</div><div class="value"><?= esc($district) ?></div></div>
      <?php if ($status): ?>
      <div class="row"><div class="label">상태</div><div class="value"><?= esc($status) ?></div></div>
      <?php endif; ?>
      <p class="note">※ 공공 데이터 기반 정보로 실제 운영 정보와 다를 수 있습니다. 방문/진료 전 확인을 권장합니다.</p>
    </div>

    <!-- ✅ 광고(2) 인아티클 -->
    <div id="ad">
      <ins class="adsbygoogle"
        style="display:block; text-align:center;"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="fluid"
        data-ad-layout="in-article"></ins>
    </div>

    <div class="card">
      <h2>지도</h2>
      <div id="map"></div>
      <p class="note">
        <?php if ($lat !== null && $lng !== null): ?>
          표시 좌표(WGS84): 위도 <?= esc(number_format($lat,6)) ?> / 경도 <?= esc(number_format($lng,6)) ?>
        <?php else: ?>
          좌표 정보가 없어 지도 표시가 제한됩니다. 대신 “네이버 지도에서 보기”로 위치 확인이 가능합니다.
        <?php endif; ?>
      </p>
      <div class="sep"></div>
      <p class="note">
        주소 검색이 안 걸리는 케이스가 있어서 **네이버 지도 링크는 상호 없이 “주소만”** 검색합니다.
      </p>
    </div>
    <div id="ad">
    <ins class="adsbygoogle" style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>
    <div class="card">
  <h2>근처 동물병원 (<?= esc($district) ?>)</h2>

  <?php if (!empty($nearby_hospitals)): ?>
    <div class="near-grid">
      <?php foreach ($nearby_hospitals as $n): ?>
        <?php
          $nName = esc($n['b_name'] ?? '동물병원');
          $nAddr = esc(($n['new_address'] ?? '') ?: ($n['old_address'] ?? ''));
          $nUrl  = esc($n['url'] ?? '#');
        ?>
        <div class="near-item">
          <div class="near-title"><a href="<?= $nUrl ?>"><?= $nName ?></a></div>
          <div class="near-meta">📍 <?= $nAddr ?: '-' ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="note">
      근처 병원을 찾지 못했습니다.
      <a href="<?= site_url('animal-hospital?search=' . urlencode($district)) ?>">같은 지역 병원 더 보기</a>
    </p>
  <?php endif; ?>
</div>


    <!-- ✅ 광고(3) 중간 자동 -->
    <div id="ad">
      <ins class="adsbygoogle" style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    </div>

    <div class="card">
      <h2>방문 전 체크 (정보 밀도↑)</h2>
      <div class="row"><div class="label">진료 가능 여부</div><div class="value">방문 전 운영 여부 확인 권장</div></div>
      <div class="row"><div class="label">응급 진료</div><div class="value">야간/주말은 병원별 상이</div></div>
      <div class="row"><div class="label">주차</div><div class="value">건물/인근 주차 가능 여부 확인</div></div>
      <p class="note">이 섹션은 얇은 페이지 판정(Thin content) 방지에 도움이 됩니다.</p>
    </div>

    <!-- ✅ 광고(4) 추천형(autorelaxed) -->
    <div id="ad">
      <ins class="adsbygoogle" style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="autorelaxed"></ins>
    </div>

    <div class="card">
      <h2>이런 상황이면 도움이 될 수 있어요</h2>
      <div class="row"><div class="label">예방접종</div><div class="value">반려동물 예방접종 문의</div></div>
      <div class="row"><div class="label">기본 진료</div><div class="value">내과/외과/피부/치과 등 상담</div></div>
      <div class="row"><div class="label">검사</div><div class="value">혈액/영상검사 가능 여부 확인</div></div>
      <p class="note">※ 실제 제공 서비스는 병원별로 다릅니다. 전화/방문 전 확인을 권장합니다.</p>
    </div>

  </div>

  <!-- ✅ 광고(5) 최하단 -->
  <div id="ad">
    <ins class="adsbygoogle" style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>
  <?php if (!empty($blog_posts)): ?>
  <div class="card" id="blogSection">
    <h2>네이버 블로그 리뷰</h2>
    <ul class="blog-list">
      <?php foreach ($blog_posts as $post): ?>
        <?php
          $postTitle = strip_tags($post['title'] ?? '');
          $postDesc  = strip_tags($post['description'] ?? '');
          $postLink  = $post['link'] ?? '#';
          $postDate  = isset($post['postdate'])
            ? substr($post['postdate'], 0, 4) . '.' . substr($post['postdate'], 4, 2) . '.' . substr($post['postdate'], 6, 2)
            : '';
        ?>
        <li class="blog-item">
          <a class="blog-title" href="<?= esc($postLink) ?>" target="_blank" rel="noopener noreferrer"><?= esc($postTitle) ?></a>
          <?php if ($postDesc): ?><p class="blog-desc"><?= esc($postDesc) ?></p><?php endif; ?>
          <?php if ($postDate): ?><span class="blog-date"><?= esc($postDate) ?></span><?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

</div>

<?php include APPPATH.'Views/includes/footer.php'; ?>

<script>
(function(){
  // ✅ 네이버 지도 링크: 주소만 검색
  var addr = <?= json_encode($addressForUse) ?>;
  var link = document.getElementById('naverDirections');
  if (link && addr) link.href = "https://map.naver.com/v5/search/" + encodeURIComponent(addr);

  // ✅ 지도 렌더
  function waitForNaver(cb, tries){
    tries = tries || 0;
    if (window.naver && naver.maps && naver.maps.Map) return cb();
    if (tries > 120) return;
    setTimeout(function(){ waitForNaver(cb, tries + 1); }, 100);
  }

  waitForNaver(function(){
    var lat = <?= ($lat !== null) ? json_encode($lat) : 'null' ?>;
    var lng = <?= ($lng !== null) ? json_encode($lng) : 'null' ?>;
    if (typeof lat !== 'number' || typeof lng !== 'number' || !isFinite(lat) || !isFinite(lng)) return;

    var center = new naver.maps.LatLng(lat, lng);
    var map = new naver.maps.Map('map', { center: center, zoom: 16 });

    new naver.maps.Marker({
      position: center,
      map: map,
      title: <?= json_encode(html_entity_decode($hospitalName)) ?>
    });
  });

  // ✅ AdSense: 중복 push 방지
  function pushAdsSafe(){
    try{
      var ins = document.querySelectorAll('ins.adsbygoogle');
      for (var i=0;i<ins.length;i++){
        if (!ins[i].getAttribute('data-adsbygoogle-status')) {
          (adsbygoogle = window.adsbygoogle || []).push({});
        }
      }
    }catch(e){}
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', pushAdsSafe);
  else pushAdsSafe();
})();
</script>

</body>
</html>
