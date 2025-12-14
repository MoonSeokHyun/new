<?php
$bizName      = esc($salon['business_name'] ?? '미용실');
$road_address = esc($salon['road_name_address'] ?? '');
$full_address = esc($salon['full_address'] ?? '');
$phone        = esc($salon['contact_phone_number'] ?? '');
$status       = esc($salon['business_status_name'] ?? '');
$dStatus      = esc($salon['detailed_business_status_name'] ?? '');
$typeName     = esc($salon['business_type_name'] ?? '');

$canonicalUrl = current_url();

// ✅ 행정 단위 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', html_entity_decode($road_address), $m);
$district_name = $m[0] ?? '지역';

preg_match('/([가-힣]+동|[가-힣]+리)/u', html_entity_decode($full_address ?: $road_address), $mDong);
$dong_name = $mDong[0] ?? '';

preg_match('/^(서울|부산|대구|인천|광주|대전|울산|세종|경기|강원|충북|충남|전북|전남|경북|경남|제주)[^\s]*/u', html_entity_decode($full_address ?: $road_address), $m2);
$region_guess = $m2[0] ?? '대한민국';

// 시/군/구(대충 2번째 토큰)
$addrTokens = preg_split('/\s+/', trim(html_entity_decode($full_address ?: $road_address)));
$sigungu_guess = $addrTokens[1] ?? '';
if ($sigungu_guess && !preg_match('/(시|군|구)$/u', $sigungu_guess)) {
  // 토큰이 애매하면 비워둠
  $sigungu_guess = '';
}

// ✅ SEO Title
$seoTitle = "{$bizName} | {$district_name} 미용실 위치·전화번호·영업정보";

// ✅ SEO Description: 중복 최소화(조건부로 1~2개 섞기)
$parts = [];
if ($road_address) $parts[] = "주소: " . html_entity_decode($road_address);
if ($status)       $parts[] = "영업상태: " . html_entity_decode($status);
if ($typeName)     $parts[] = "업종: " . html_entity_decode($typeName);

$baseDesc = "{$district_name}에 위치한 {$bizName} 미용실 정보입니다.";
$extra    = $parts ? (' ' . implode(' · ', array_slice($parts, 0, 2)) . '.') : '';
$seoDescription = $baseDesc . $extra . " 전화번호/위치 확인 및 네이버 지도 보기 링크를 제공합니다.";

// 길이 제한(너무 길면 잘림)
if (function_exists('mb_strlen') && mb_strlen($seoDescription, 'UTF-8') > 155) {
  $seoDescription = mb_substr($seoDescription, 0, 155, 'UTF-8');
}

$latitude  = $latitude ?? '';
$longitude = $longitude ?? '';

$naverMapKeyId = 'c3hsihbnx3';

$nearby_salons = $nearby_salons ?? [];

$salonsUrl = site_url('hairsalon');

// ✅ 허브 URL(컨트롤러 index가 지원)
$hubRegionUrl   = $region_guess ? site_url('hairsalon?region=' . urlencode($region_guess)) : '';
$hubSigunguUrl  = $sigungu_guess ? site_url('hairsalon?sigungu=' . urlencode($sigungu_guess)) : '';
$hubDistrictUrl = $district_name ? site_url('hairsalon?district=' . urlencode($district_name)) : '';
$hubDongUrl     = $dong_name ? site_url('hairsalon?dong=' . urlencode($dong_name)) : '';

// 전화 링크
$telDigits = preg_replace('/[^0-9]/', '', html_entity_decode($phone));
$telHref   = $telDigits ? "tel:{$telDigits}" : '';

// 네이버 지도 검색 링크(스키마/버튼 공용)
$naverMapSearchQ = urlencode(html_entity_decode($bizName . ' ' . ($road_address ?: $full_address)));
$naverMapUrl = "https://map.naver.com/v5/search/" . $naverMapSearchQ;

// ✅ geo 스키마용
$latOk = is_numeric($latitude);
$lngOk = is_numeric($longitude);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDescription) ?>" />
  <meta name="robots" content="index,follow,max-image-preview:large" />
  <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />
  <link rel="alternate" href="<?= esc($canonicalUrl) ?>" hreflang="ko" />

  <link rel="preconnect" href="https://oapi.map.naver.com" crossorigin>
  <link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
  <link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>

  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
  <meta property="og:locale" content="ko_KR" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />

  <script>
    window.navermap_authFailure = function () {
      console.error('네이버 지도 인증 실패: ncpKeyId 또는 Web 서비스 URL 등록을 확인하세요.');
    };
  </script>

  <script defer src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpKeyId=<?= esc($naverMapKeyId) ?>"></script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <!-- ✅ 구조화 데이터: geo + hasMap + areaServed -->
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@graph":[
      {
        "@type":"WebPage",
        "@id":"<?= esc($canonicalUrl) ?>#webpage",
        "url":"<?= esc($canonicalUrl) ?>",
        "name":"<?= esc($seoTitle) ?>",
        "description":"<?= esc($seoDescription) ?>",
        "inLanguage":"ko-KR"
      },
      {
        "@type":"BreadcrumbList",
        "@id":"<?= esc($canonicalUrl) ?>#breadcrumb",
        "itemListElement":[
          {"@type":"ListItem","position":1,"name":"홈","item":"<?= esc(site_url()) ?>"},
          {"@type":"ListItem","position":2,"name":"미용실 목록","item":"<?= esc($salonsUrl) ?>"},
          {"@type":"ListItem","position":3,"name":"<?= esc($district_name) ?>","item":"<?= esc($hubDistrictUrl ?: $salonsUrl) ?>"},
          {"@type":"ListItem","position":4,"name":"<?= esc($bizName) ?>","item":"<?= esc($canonicalUrl) ?>"}
        ]
      },
      {
        "@type":"HairSalon",
        "@id":"<?= esc($canonicalUrl) ?>#business",
        "name":"<?= esc($bizName) ?>",
        "url":"<?= esc($canonicalUrl) ?>",
        "telephone":"<?= esc($phone) ?>",
        "hasMap":"<?= esc($naverMapUrl) ?>",
        "areaServed":[
          <?= $region_guess ? '"' . esc($region_guess) . '"' : '"대한민국"' ?>
          <?= $sigungu_guess ? ',"' . esc($sigungu_guess) . '"' : '' ?>
          <?= $district_name ? ',"' . esc($district_name) . '"' : '' ?>
          <?= $dong_name ? ',"' . esc($dong_name) . '"' : '' ?>
        ],
        "address":{
          "@type":"PostalAddress",
          "streetAddress":"<?= esc($road_address) ?>",
          "addressLocality":"<?= esc($district_name) ?>",
          "addressRegion":"<?= esc($region_guess) ?>",
          "addressCountry":"KR"
        }
        <?= ($latOk && $lngOk) ? ',
        "geo":{"@type":"GeoCoordinates","latitude":' . esc((string)$latitude) . ',"longitude":' . esc((string)$longitude) . '}' : '' ?>
      }
    ]
  }
  </script>

  <style>
    :root{ --blue:#0078ff; --bg:#f5f5f5; --txt:#333; --sub:#666; --card:#fff; --bd:#eee; }
    body{ background:var(--bg); font-family:'Noto Sans KR',system-ui,-apple-system,sans-serif; margin:0; color:var(--txt); }
    a{ color:var(--blue); text-decoration:none; }
    a:hover{ text-decoration:underline; }
    .container{ max-width:900px; margin:1.5rem auto; padding:0 1rem; }
    .title{ font-size:2rem; margin:.5rem 0 0; }
    .subtitle{ color:var(--sub); margin:.25rem 0 1rem; line-height:1.5; }
    .breadcrumb{ font-size:.9rem; color:#555; margin-bottom:1rem; }
    .grid{ display:grid; grid-template-columns: 1fr; gap:1rem; }
    .card{ background:var(--card); border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:1.25rem; }
    .card h2{ font-size:1.15rem; margin:0 0 .75rem; color:var(--blue); border-left:4px solid var(--blue); padding-left:.5rem; }
    .kv{ display:flex; flex-wrap:wrap; gap:.5rem; }
    .pill{ background:#eef5ff; color:#0b3d91; border-radius:999px; padding:.35rem .7rem; font-size:.85rem; }
    .detail{ list-style:none; padding:0; margin:0; }
    .row{ display:flex; justify-content:space-between; gap:1rem; padding:.65rem 0; border-bottom:1px solid var(--bd); }
    .row:last-child{ border-bottom:none; }
    .label{ font-weight:900; }
    .value{ color:#555; text-align:right; word-break:break-word; }
    .actions{ display:flex; flex-wrap:wrap; gap:.5rem; margin-top:.75rem; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:.4rem; padding:.6rem .9rem; border-radius:10px; border:1px solid #dbe7ff; background:#fff; color:#0b3d91; font-weight:900; }
    .btn.primary{ background:var(--blue); border-color:var(--blue); color:#fff; }
    .btn.muted{ background:#f7f9ff; }
    #map{ width:100%; height:340px; border-radius:12px; overflow:hidden; background:#e9eef7; }
    .note{ margin-top:.5rem; color:var(--sub); font-size:.9rem; line-height:1.4; }
    .ad{ margin:1rem 0; text-align:center; }
    .list{ margin:0; padding-left:1.1rem; color:#444; line-height:1.7; }
    .small{ font-size:.92rem; color:#555; line-height:1.7; }
    .sep{ height:1px; background:var(--bd); margin:1rem 0; }
    .near-grid{ display:grid; grid-template-columns:1fr; gap:.6rem; }
    .near-item{ padding:.85rem 1rem; border:1px solid var(--bd); border-radius:12px; background:#fff; }
    .near-title{ font-weight:900; font-size:1rem; margin:0 0 .25rem; }
    .near-meta{ color:#666; font-size:.92rem; line-height:1.5; }
    @media (max-width:640px){
      .row{ flex-direction:column; align-items:flex-start; }
      .value{ text-align:left; }
    }
  </style>
</head>
<body>

<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">
  <div class="breadcrumb">
    <a href="<?= site_url() ?>">홈</a> &gt;
    <a href="<?= $salonsUrl ?>">미용실 목록</a> &gt;
    <a href="<?= esc($hubDistrictUrl ?: $salonsUrl) ?>"><?= esc($district_name) ?></a> &gt;
    상세정보
  </div>

  <h1 class="title"><?= esc($bizName) ?></h1>
  <p class="subtitle"><?= esc($seoDescription) ?></p>

  <!-- 광고(1) 상단 -->
  <div class="ad">
    <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>

  <div class="grid">

    <div class="card">
      <h2>핵심 요약</h2>
      <div class="kv">
        <?php if ($region_guess): ?><span class="pill"><?= esc($region_guess) ?></span><?php endif; ?>
        <?php if ($sigungu_guess): ?><span class="pill"><?= esc($sigungu_guess) ?></span><?php endif; ?>
        <?php if ($district_name): ?><span class="pill"><?= esc($district_name) ?></span><?php endif; ?>
        <?php if ($dong_name): ?><span class="pill"><?= esc($dong_name) ?></span><?php endif; ?>
        <?php if ($status): ?><span class="pill">영업: <?= esc($status) ?></span><?php endif; ?>
        <?php if ($typeName): ?><span class="pill"><?= esc($typeName) ?></span><?php endif; ?>
      </div>

      <div class="actions">
        <?php if ($telHref): ?><a class="btn primary" href="<?= esc($telHref) ?>" rel="nofollow">전화하기</a><?php endif; ?>
        <a class="btn muted" href="#mapSection">지도 보기</a>
        <a class="btn" href="<?= esc($naverMapUrl) ?>" target="_blank" rel="nofollow noopener">네이버 지도</a>
        <a class="btn" href="<?= $salonsUrl ?>">목록</a>
      </div>

      <div class="sep"></div>

      <div class="actions">
        <?php if ($hubRegionUrl): ?><a class="btn muted" href="<?= esc($hubRegionUrl) ?>">지역 허브</a><?php endif; ?>
        <?php if ($hubSigunguUrl): ?><a class="btn muted" href="<?= esc($hubSigunguUrl) ?>">시/군/구 허브</a><?php endif; ?>
        <?php if ($hubDistrictUrl): ?><a class="btn muted" href="<?= esc($hubDistrictUrl) ?>">구/읍/면 허브</a><?php endif; ?>
        <?php if ($hubDongUrl): ?><a class="btn muted" href="<?= esc($hubDongUrl) ?>">동네 허브</a><?php endif; ?>
      </div>
    </div>

    <!-- 광고(2) -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    </div>

    <div class="card">
      <h2>기본 정보</h2>
      <ul class="detail">
        <li class="row"><span class="label">주소</span><span class="value"><?= $road_address ?: $full_address ?></span></li>
        <li class="row"><span class="label">전화번호</span><span class="value"><?= $phone ?></span></li>
        <li class="row"><span class="label">영업 상태</span><span class="value"><?= $status ?></span></li>
        <li class="row"><span class="label">상세 상태</span><span class="value"><?= $dStatus ?></span></li>
        <li class="row"><span class="label">업종</span><span class="value"><?= $typeName ?></span></li>
      </ul>
      <p class="note">※ 공개 데이터/제공 데이터를 기반으로 하며 실제 영업 정보는 변동될 수 있습니다.</p>
    </div>

    <!-- 광고(3) -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    </div>

    <div class="card" id="mapSection">
      <h2>지도</h2>
      <div id="map"></div>
      <p class="note" id="mapNote">
        <?php if ($latOk && $lngOk): ?>
          표시 좌표: 위도 <?= esc((string)$latitude) ?> / 경도 <?= esc((string)$longitude) ?>
        <?php else: ?>
          좌표 정보가 없어 지도를 표시할 수 없습니다.
        <?php endif; ?>
      </p>
      <div class="actions" style="margin-top:.25rem;">
        <a class="btn" id="naverDirections" href="<?= esc($naverMapUrl) ?>" target="_blank" rel="nofollow noopener">네이버 지도에서 보기</a>
      </div>
    </div>

    <!-- 광고(4) -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    </div>

    <div class="card" id="nearbySection">
      <h2>근처 미용실 보기</h2>

      <?php if (!empty($nearby_salons)): ?>
        <div class="near-grid">
          <?php foreach ($nearby_salons as $s): ?>
            <?php
              $nName  = esc($s['business_name'] ?? '미용실');
              $nUrl   = esc($s['url'] ?? '#');
              $nRoad  = esc($s['road_name_address'] ?? '');
              $nFull  = esc($s['full_address'] ?? '');
              $nPhone = esc($s['contact_phone_number'] ?? '');
              $addr   = $nRoad ?: $nFull;
            ?>
            <div class="near-item">
              <div class="near-title"><a href="<?= $nUrl ?>"><?= $nName ?></a></div>
              <div class="near-meta">
                <?php if ($addr): ?>주소: <?= $addr ?><br><?php endif; ?>
                <?php if ($nPhone): ?>전화: <?= $nPhone ?><?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="note">
          가까운 미용실 데이터를 찾지 못했습니다.
          <?php if ($hubDistrictUrl): ?><br><a href="<?= esc($hubDistrictUrl) ?>"><?= esc($district_name) ?> 목록</a>에서 더 찾아보세요.<?php endif; ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- 광고(5) 하단 -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    </div>

    <a class="btn muted" href="<?= $salonsUrl ?>" style="justify-self:start;">← 목록으로</a>

  </div>
</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
(function(){
  // ✅ 광고: ins 개수만큼 push (줄이지 않음)
  try {
    var ins = document.querySelectorAll('ins.adsbygoogle');
    for (var i=0; i<ins.length; i++) (adsbygoogle = window.adsbygoogle || []).push({});
  } catch(e) {}

  function waitForNaver(cb, tries){
    tries = tries || 0;
    if (window.naver && naver.maps && naver.maps.Map) return cb();
    if (tries > 80) return;
    setTimeout(function(){ waitForNaver(cb, tries + 1); }, 100);
  }

  waitForNaver(function(){
    var lat = parseFloat("<?= esc((string)$latitude) ?>");
    var lng = parseFloat("<?= esc((string)$longitude) ?>");
    if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

    var center = new naver.maps.LatLng(lat, lng);
    var map = new naver.maps.Map('map', { center: center, zoom: 16 });

    var marker = new naver.maps.Marker({
      position: center,
      map: map,
      title: "<?= esc($bizName); ?>"
    });

    var info = new naver.maps.InfoWindow({
      content:
        '<div style="padding:10px 12px; font-size:13px; line-height:1.4;">' +
        '<strong><?= esc($bizName) ?></strong><br/>' +
        '<?= esc($road_address ?: $full_address) ?>' +
        '</div>'
    });

    naver.maps.Event.addListener(marker, "click", function(){
      if(info.getMap()) info.close();
      else info.open(map, marker);
    });
  });
})();
</script>

</body>
</html>
