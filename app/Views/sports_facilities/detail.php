<?php
// 안전 초기화
$facilityName   = esc($facility['FCLTY_NM']           ?? '체육시설');
$roadAddress    = esc($facility['RDNMADR_NM']        ?? '');
$lat            = esc($facility['FCLTY_LA']          ?? '0');
$lng            = esc($facility['FCLTY_LO']          ?? '0');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $roadAddress, $m);
$district       = $m[0] ?? '지역';

// SEO용 메타
$seoTitle       = "{$facilityName} - {$district} {$roadAddress} 체육시설 상세정보";
$seoDescription = "{$facilityName} 체육시설의 위치: {$district} {$roadAddress}. 면적, 수용인원, 담당부서, 연락처 등 모든 정보를 확인하세요.";
$seoKeywords    = implode(',', [$district, $facilityName, '체육시설', '공공시설', '스포츠']);
$canonicalUrl   = current_url();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDescription) ?>" />
  <meta name="keywords" content="<?= esc($seoKeywords) ?>" />
  <meta name="robots" content="index,follow" />
  <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />

  <!-- Open Graph -->
  <meta property="og:type"        content="SportsActivityLocation" />
  <meta property="og:title"       content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:url"         content="<?= esc($canonicalUrl) ?>" />
  <meta property="og:locale"      content="ko_KR" />

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary" />
  <meta name="twitter:title"       content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />

  <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SportsActivityLocation",
    "@id": "<?= esc($canonicalUrl) ?>",
    "name": "<?= esc($facilityName) ?>",
    "address": "<?= esc($roadAddress) ?>",
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "<?= esc($lat) ?>",
      "longitude": "<?= esc($lng) ?>"
    },
    "telephone": "<?= esc($facility['RSPNSBLTY_TEL_NO'] ?? '') ?>",
    "url": "<?= esc($canonicalUrl) ?>"
  }
  </script>

  <style>
    body { background:#f5f5f5; font-family:'Noto Sans KR',sans-serif; margin:0; padding:0; color:#333 }
    a { color:#0078ff; text-decoration:none }
    .container { max-width:800px; margin:2rem auto; padding:0 1rem }
    .a { font-size:2rem; margin-bottom:.5rem; border-bottom:2px solid #0078ff; padding-bottom:.3rem }
    .breadcrumb { font-size:.9rem; color:#555; margin-bottom:1.5rem }
    .breadcrumb a:hover { text-decoration:underline }
    .ad-box { margin:1.5rem 0; text-align:center }
    .section { background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-bottom:1.5rem; padding:1.5rem }
    .section h2 { font-size:1.2rem; margin-bottom:1rem; color:#0078ff; border-left:4px solid #0078ff; padding-left:.5rem }
    .detail-list { list-style:none; padding:0; margin:0 }
    .detail-item { display:flex; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid #eee }
    .detail-item:last-child { border-bottom:none }
    .label { font-weight:600 }
    .value { color:#555; text-align:right }
    #map { width:100%; height:300px; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1) }
    a.back { display:inline-block; margin-top:1rem }
    a.back:hover { text-decoration:underline }
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="a"><?= esc($facilityName) ?></h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('sports_facilities') ?>">체육시설 목록</a> &gt;
      상세정보
    </div>

    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>

    <!-- 기본 정보 -->
    <div class="section">
      <h2>기본 정보</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">시설명</span><span class="value"><?= esc($facilityName) ?></span></li>
        <li class="detail-item"><span class="label">도로명주소</span><span class="value"><?= esc($roadAddress) ?></span></li>
        <li class="detail-item"><span class="label">지역</span><span class="value"><?= esc($district) ?></span></li>
      </ul>
    </div>

    <!-- 담당부서 & 연락처 -->
    <div class="section">
      <h2>책임부서 & 연락처</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">책임부서</span><span class="value"><?= esc($facility['RSPNSBLTY_DEPT_NM'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">전화번호</span><span class="value"><?= esc($facility['RSPNSBLTY_TEL_NO'] ?? '') ?></span></li>
      </ul>
    </div>
    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>

    <!-- 시설 정보 -->
    <div class="section">
      <h2>시설 정보</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">면적(㎡)</span><span class="value"><?= esc($facility['FCLTY_AR_CO'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">수용인원</span><span class="value"><?= esc($facility['ACMD_NMPR_CO'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">장애인편의수</span><span class="value"><?= esc($facility['ADTM_CO'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">소유주체</span><span class="value"><?= esc($facility['POSESN_MBY_NM'] ?? '') ?></span></li>
      </ul>
    </div>

    <!-- 기타 정보 -->
    <div class="section">
      <h2>기타 정보</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">업종명</span><span class="value"><?= esc($facility['INDUTY_NM'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">시설유형</span><span class="value"><?= esc($facility['FCLTY_TY_NM'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">홈페이지</span><span class="value"><?= esc($facility['FCLTY_HMPG_URL'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">보조시설 여부</span><span class="value"><?= esc($facility['NATION_ALSFC_AT'] ?? '') ?></span></li>
        <li class="detail-item"><span class="label">상태코드</span><span class="value"><?= esc($facility['FCLTY_STATE_CD'] ?? '') ?></span></li>
      </ul>
    </div>

    <!-- 지도 -->
    <div class="section">
      <h2>지도</h2>
      <div id="map"></div>
    </div>
    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>

    <a href="<?= site_url('sports_facilities') ?>" class="back">← 목록으로 돌아가기</a>
  </div>

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
//       var map = new naver.maps.Map('map', {
//         center: new naver.maps.LatLng(parseFloat("<?= $lat ?>"), parseFloat("<?= $lng ?>")),
//         zoom: 16
//       });
//       new naver.maps.Marker({
//         position: map.getCenter(),
//         map: map,
//         title: "<?= esc($facilityName) ?>"
//       });
    })();
  </script>
</body>
</html>
