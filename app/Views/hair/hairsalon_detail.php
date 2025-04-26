<?php
// SEO 동적 메타 정보 생성
$road_address    = esc($salon['road_name_address'] ?? '');
$full_address    = esc($salon['full_address'] ?? '');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $road_address, $matches);
$district_name   = $matches[0] ?? '지역';

// SEO 메타
$seoTitle        = "{$salon['business_name']} - {$district_name} 고객만족도 1위 미용실! 리뷰 & 혜택 확인";
$seoDescription  = "{$salon['business_name']} 위치: {$district_name} {$road_address}. 전화, 서비스, 영업시간 등 모든 정보를 확인하세요.";
$canonicalUrl    = current_url();
$imageUrl        = esc($salon['image_url'] ?? '/default-image.jpg');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <!-- 기본 메타 -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDescription) ?>" />
  <meta name="robots" content="index,follow" />
  <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
  <meta property="og:image" content="<?= esc($imageUrl) ?>" />
  <meta property="og:locale" content="ko_KR" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />
  <meta name="twitter:image" content="<?= esc($imageUrl) ?>" />

  <!-- 구조화된 데이터 (JSON-LD) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "HairSalon",
    "name": "<?= esc($salon['business_name']) ?>",
    "image": "<?= esc($imageUrl) ?>",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?= esc($road_address) ?>",
      "addressLocality": "<?= esc($district_name) ?>",
      "addressRegion": "한국"
    },
    "telephone": "<?= esc($salon['contact_phone_number']) ?>",
    "url": "<?= esc($canonicalUrl) ?>"
  }
  </script>
  <!-- Naver Map & AdSense -->
  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

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
    @media (max-width: 768px) { .container { margin:1rem auto; padding:0 .5rem } }
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="a"><?= esc($salon['business_name']) ?></h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('salons') ?>">미용실 목록</a> &gt;
      상세정보
    </div>

    <!-- 상단 광고 -->
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
        <li class="detail-item"><span class="label">전체주소</span><span class="value"><?= $full_address ?></span></li>
        <li class="detail-item"><span class="label">도로명주소</span><span class="value"><?= $road_address ?></span></li>
        <li class="detail-item"><span class="label">지역</span><span class="value"><?= esc($district_name) ?></span></li>
        <li class="detail-item"><span class="label">전화번호</span><span class="value"><?= esc($salon['contact_phone_number']) ?></span></li>
        <li class="detail-item"><span class="label">영업 상태</span><span class="value"><?= esc($salon['business_status_name']) ?></span></li>
        <li class="detail-item"><span class="label">상세 영업 상태</span><span class="value"><?= esc($salon['detailed_business_status_name']) ?></span></li>
      </ul>
    </div>

    <!-- 중간 광고 -->
    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>

    <!-- 상세 정보 -->
    <div class="section">
      <h2>상세 정보</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">사업장 면적</span><span class="value"><?= esc($salon['location_area']) ?> m²</span></li>
        <li class="detail-item"><span class="label">영업 시작일</span><span class="value"><?= esc($salon['permit_date']) ?></span></li>
        <li class="detail-item"><span class="label">재개업일</span><span class="value"><?= esc($salon['reopening_date']) ?></span></li>
        <li class="detail-item"><span class="label">폐업일</span><span class="value"><?= esc($salon['closure_date']) ?></span></li>
        <li class="detail-item"><span class="label">최종 수정 시점</span><span class="value"><?= esc($salon['last_modification_time']) ?></span></li>
        <li class="detail-item"><span class="label">업종명</span><span class="value"><?= esc($salon['business_type_name']) ?></span></li>
      </ul>
    </div>

    <div class="section">
      <h2>추가 정보</h2>
      <ul class="detail-list">
        <li class="detail-item"><span class="label">위생업태명</span><span class="value"><?= esc($salon['hygiene_business_type']) ?></span></li>
        <li class="detail-item"><span class="label">건물 지상층수</span><span class="value"><?= esc($salon['building_upper_floors']) ?>층</span></li>
        <li class="detail-item"><span class="label">건물 지하층수</span><span class="value"><?= esc($salon['building_lower_floors']) ?>층</span></li>
        <li class="detail-item"><span class="label">의자 수</span><span class="value"><?= esc($salon['chair_count']) ?></span></li>
        <li class="detail-item"><span class="label">침대 수</span><span class="value"><?= esc($salon['bed_count']) ?></span></li>
        <li class="detail-item"><span class="label">여성 종사자 수</span><span class="value"><?= esc($salon['female_staff_count']) ?></span></li>
        <li class="detail-item"><span class="label">남성 종사자 수</span><span class="value"><?= esc($salon['male_staff_count']) ?></span></li>
        <li class="detail-item"><span class="label">다중이용업소 여부</span><span class="value"><?= esc($salon['multi_use_business']) ?></span></li>
      </ul>
    </div>

    <!-- 지도 섹션 -->
    <div class="section">
      <h2>지도</h2>
      <div id="map"></div>
    </div>

    <!-- 하단 광고 -->
    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>

    <a href="<?= site_url('salons') ?>" class="back">← 목록으로 돌아가기</a>
  </div>

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
      var lat = parseFloat("<?= esc($latitude); ?>");
      var lng = parseFloat("<?= esc($longitude); ?>");
      var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(lat, lng),
        zoom: 16
      });
      new naver.maps.Marker({
        position: map.getCenter(),
        map: map,
        title: "<?= esc($salon['business_name']); ?>"
      });
      (adsbygoogle = window.adsbygoogle || []).push({});
    })();
  </script>
</body>
</html>