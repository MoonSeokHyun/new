<?php
$bizName      = esc($salon['business_name'] ?? '미용실');
$road_address = esc($salon['road_name_address'] ?? '');
$full_address = esc($salon['full_address'] ?? '');
$phone        = esc($salon['contact_phone_number'] ?? '');
$status       = esc($salon['business_status_name'] ?? '');
$dStatus      = esc($salon['detailed_business_status_name'] ?? '');
$typeName     = esc($salon['business_type_name'] ?? '');

$canonicalUrl = current_url();

preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $road_address, $matches);
$district_name = $matches[0] ?? '지역';

preg_match('/^(서울|부산|대구|인천|광주|대전|울산|세종|경기|강원|충북|충남|전북|전남|경북|경남|제주)[^\s]*/u', $full_address ?: $road_address, $m2);
$region_guess = $m2[0] ?? '대한민국';

// ✅ 컨트롤러에서 넘어온 WGS84
$latitude  = (is_numeric($latitude)  ? (float)$latitude  : null);
$longitude = (is_numeric($longitude) ? (float)$longitude : null);

// ✅ 중복 메타 줄이기: 도로명/상태/업종명 섞기
$parts = [];
if ($road_address) $parts[] = "도로명 {$road_address}";
if ($status)       $parts[] = "영업상태 {$status}";
if ($typeName)     $parts[] = "업종 {$typeName}";
$mix = $parts ? implode(', ', array_slice($parts, 0, 2)) : "{$district_name} 지역";

$seoTitle = "{$bizName} | {$district_name} 미용실 위치·전화번호·영업정보";
$seoDescription = "{$district_name}에 위치한 {$bizName} 미용실 정보. {$mix}를 확인하고 네이버 지도로 위치도 바로 확인하세요.";

$naverMapKeyId = 'c3hsihbnx3';

$nearby_salons = $nearby_salons ?? [];

$districtUrl = site_url('hairsalon?district=' . urlencode($district_name));
$salonsUrl   = site_url('hairsalon');

// ✅ 네이버 지도 검색은 “주소만”
$mapQuery = trim(html_entity_decode($road_address ?: $full_address));

$telDigits = preg_replace('/[^0-9]/', '', html_entity_decode($phone));
$telHref   = $telDigits ? "tel:{$telDigits}" : '';
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

  <!-- ✅ 구조화 데이터: geo 포함 -->
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
          {"@type":"ListItem","position":3,"name":"<?= esc($district_name) ?>","item":"<?= esc($districtUrl) ?>"},
          {"@type":"ListItem","position":4,"name":"<?= esc($bizName) ?>","item":"<?= esc($canonicalUrl) ?>"}
        ]
      },
      {
        "@type":"HairSalon",
        "@id":"<?= esc($canonicalUrl) ?>#business",
        "name":"<?= esc($bizName) ?>",
        "url":"<?= esc($canonicalUrl) ?>",
        "telephone":"<?= esc($phone) ?>",
        "address":{
          "@type":"PostalAddress",
          "streetAddress":"<?= esc($road_address ?: $full_address) ?>",
          "addressLocality":"<?= esc($district_name) ?>",
          "addressRegion":"<?= esc($region_guess) ?>",
          "addressCountry":"KR"
        }
        <?php if ($latitude !== null && $longitude !== null): ?>,
        "geo": {
          "@type":"GeoCoordinates",
          "latitude": <?= json_encode($latitude) ?>,
          "longitude": <?= json_encode($longitude) ?>
        }
        <?php endif; ?>
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
    .label{ font-weight:700; }
    .value{ color:#555; text-align:right; word-break:break-word; }
    .actions{ display:flex; flex-wrap:wrap; gap:.5rem; margin-top:.75rem; }
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:.4rem; padding:.6rem .9rem; border-radius:10px; border:1px solid #dbe7ff; background:#fff; color:#0b3d91; font-weight:700; }
    .btn.primary{ background:var(--blue); border-color:var(--blue); color:#fff; }
    .btn.muted{ background:#f7f9ff; }
    #map{ width:100%; height:340px; border-radius:12px; overflow:hidden; background:#e9eef7; }
    .note{ margin-top:.5rem; color:var(--sub); font-size:.9rem; line-height:1.5; }
    .ad{ margin:1rem 0; text-align:center; }
    .small{ font-size:.92rem; color:#555; line-height:1.7; }
    .sep{ height:1px; background:var(--bd); margin:1rem 0; }
    .near-grid{ display:grid; grid-template-columns:1fr; gap:.6rem; }
    .near-item{ padding:.85rem 1rem; border:1px solid var(--bd); border-radius:12px; background:#fff; }
    .near-title{ font-weight:800; font-size:1rem; margin:0 0 .25rem; }
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
    <a href="<?= $districtUrl ?>"><?= esc($district_name) ?></a> &gt;
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
        <?php if ($district_name): ?><span class="pill"><?= esc($district_name) ?></span><?php endif; ?>
        <?php if ($status): ?><span class="pill">영업: <?= esc($status) ?></span><?php endif; ?>
        <?php if ($typeName): ?><span class="pill"><?= esc($typeName) ?></span><?php endif; ?>
        <?php if ($phone): ?><span class="pill">전화 가능</span><?php endif; ?>
      </div>

      <div class="actions">
        <?php if ($telHref): ?><a class="btn primary" href="<?= esc($telHref) ?>" rel="nofollow">전화하기</a><?php endif; ?>
        <a class="btn muted" href="#mapSection">지도 보기</a>
        <a class="btn" href="<?= $districtUrl ?>">같은 지역 미용실</a>
        <a class="btn" href="<?= $salonsUrl ?>">미용실 목록</a>
      </div>

      <div class="sep"></div>
      <div class="small">
        방문 전에는 <strong>영업상태</strong>와 <strong>전화번호</strong>를 확인하고, 예약/서비스는 전화로 확인하는 것이 가장 정확합니다.
      </div>
    </div>

    <!-- 광고(2) 인아티클 -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block; text-align:center;"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="fluid"
        data-ad-layout="in-article"></ins>
    </div>

    <div class="card">
      <h2>기본 정보</h2>
      <ul class="detail">
        <li class="row"><span class="label">전체주소</span><span class="value"><?= $full_address ?></span></li>
        <li class="row"><span class="label">도로명주소</span><span class="value"><?= $road_address ?></span></li>
        <li class="row"><span class="label">전화번호</span><span class="value"><?= $phone ?></span></li>
        <li class="row"><span class="label">영업 상태</span><span class="value"><?= $status ?></span></li>
        <li class="row"><span class="label">상세 영업 상태</span><span class="value"><?= $dStatus ?></span></li>
        <li class="row"><span class="label">업종명</span><span class="value"><?= $typeName ?></span></li>
      </ul>
      <p class="note">※ 공개 데이터 기반 정보로 실제 운영 정보는 변동될 수 있습니다.</p>
    </div>

    <!-- 광고(3) 중간 -->
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

      <?php if ($latitude !== null && $longitude !== null): ?>
        <div id="map"></div>
        <p class="note" id="mapNote">
          표시 좌표(WGS84): 위도 <?= esc(number_format($latitude, 6)) ?> / 경도 <?= esc(number_format($longitude, 6)) ?>
        </p>
      <?php else: ?>
        <div style="padding:14px; border:1px dashed #cfd8ea; border-radius:12px; background:#fff;">
          <strong>좌표 정보가 없습니다.</strong><br>
          서버 지오코딩(API Key) 설정이 안 됐거나, 주소가 지오코딩 결과가 없는 형태일 수 있습니다.<br>
          <span class="note">현재 주소: <?= esc($mapQuery ?: '없음') ?></span>
        </div>
      <?php endif; ?>

      <div class="actions" style="margin-top:.5rem;">
        <a class="btn" id="naverDirections" href="#" target="_blank" rel="nofollow noopener">네이버 지도에서 보기</a>
        <a class="btn muted" href="<?= $districtUrl ?>">같은 지역 더 보기</a>
      </div>
    </div>

    <!-- 광고(4) 추천형 -->
    <div class="ad">
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6686738239613464"
        data-ad-slot="1204098626"
        data-ad-format="autorelaxed"></ins>
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
          가까운 미용실을 찾지 못했습니다. <a href="<?= $districtUrl ?>"><?= esc($district_name) ?> 미용실 목록</a>에서 더 찾아보세요.
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

  </div>
</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
(function(){
  // ✅ AdSense: 안전 push
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
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', pushAdsSafe);
  } else {
    pushAdsSafe();
  }

  // ✅ 네이버 지도 링크는 "주소만" 검색
  var qAddr = <?= json_encode($mapQuery) ?>;
  var el = document.getElementById("naverDirections");
  if (el) {
    el.href = "https://map.naver.com/v5/search/" + encodeURIComponent(qAddr || "");
  }

  // 좌표 있으면 지도 렌더
  var lat = <?= $latitude !== null ? json_encode($latitude) : 'null' ?>;
  var lng = <?= $longitude !== null ? json_encode($longitude) : 'null' ?>;

  function waitForNaver(cb, tries){
    tries = tries || 0;
    if (window.naver && naver.maps && naver.maps.Map) return cb();
    if (tries > 120) return;
    setTimeout(function(){ waitForNaver(cb, tries + 1); }, 100);
  }

  if (typeof lat === 'number' && typeof lng === 'number' && isFinite(lat) && isFinite(lng)) {
    waitForNaver(function(){
      var center = new naver.maps.LatLng(lat, lng);
      var map = new naver.maps.Map('map', { center: center, zoom: 16 });

      var marker = new naver.maps.Marker({
        position: center,
        map: map,
        title: <?= json_encode(html_entity_decode($bizName)) ?>
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
  }
})();
</script>

</body>
</html>
