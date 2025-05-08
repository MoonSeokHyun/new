<?php
// 안전 초기화
$hospitalName     = esc($hospital['b_name'] ?? '동물병원');
$roadAddress      = esc($hospital['new_address'] ?? '');
$landLotAddress   = esc($hospital['old_address'] ?? '');
$lat              = esc($hospital['latitude'] ?? '0');
$lng              = esc($hospital['longitude'] ?? '0');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $landLotAddress, $m);
$district         = $m[0] ?? '지역';

// SEO용 메타
$seoTitle         = esc("{$hospitalName} – {$district} {$landLotAddress} 동물병원 상세정보 | 위치・운영시간・편의시설");
$seoDescription   = esc("{$hospitalName} 동물병원의 위치({$district} {$landLotAddress}), 운영시간, 편의 시설 등 모든 정보를 확인하세요.");
$seoKeywords      = esc("동물병원, {$hospitalName}, {$district}, {$landLotAddress}, 운영시간, 시설");

//--------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title><?= $seoTitle ?></title>
  <meta name="description" content="<?= $seoDescription ?>" />
  <meta name="keywords" content="<?= $seoKeywords ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Open Graph -->
  <meta property="og:type"        content="website" />
  <meta property="og:title"       content="<?= $seoTitle ?>" />
  <meta property="og:description" content="<?= $seoDescription ?>" />
  <meta property="og:url"         content="<?= current_url() ?>" />
  <meta property="og:locale"      content="ko_KR" />

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary" />
  <meta name="twitter:title"       content="<?= $seoTitle ?>" />
  <meta name="twitter:description" content="<?= $seoDescription ?>" />

  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>

  <style>
    body { background: #f5f5f5; font-family: 'Noto Sans KR', sans-serif; color: #333; margin:0; padding:0; }
    a { color:#0078ff; text-decoration:none; }
    .container{ max-width:800px; margin:2rem auto; padding:0 1rem; }
    .content-title{ font-size:2rem; margin-bottom:.5rem; border-bottom:2px solid #0078ff; padding-bottom:.3rem; }
    .breadcrumb{ font-size:.9rem; color:#555; margin-bottom:1.5rem; }
    .ad-box{ margin:1.5rem 0; text-align:center; }
    .section{ background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-bottom:1.5rem; padding:1.5rem; }
    .section h2{ font-size:1.2rem; margin-bottom:1rem; color:#0078ff; border-left:4px solid #0078ff; padding-left:.5rem; }
    .detail-list{ margin:0; padding:0; }
    .detail-item{ display:flex; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid #eee; }
    .detail-item:last-child{ border-bottom:none; }
    .label{ font-weight:600; color:#333; }
    .value{ color:#555; text-align:right; }
    #map{ width:100%; height:300px; border-radius:8px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1); }
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="content-title"><?= $hospitalName ?></h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('animal_hospital') ?>">동물병원 목록</a> &gt;
      상세정보
    </div>

    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
    </div>

    <!-- 기본 정보 -->
    <div class="section">
      <h2>기본 정보</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">병원명</div><div class="value"><?= $hospitalName ?></div></div>
        <div class="detail-item"><div class="label">주소</div><div class="value"><?= $roadAddress ?></div></div>       
        <div class="detail-item"><div class="label">구주소</div><div class="value"><?= $landLotAddress ?></div></div>
        <div class="detail-item"><div class="label">진료과목</div><div class="value">일반적인 내과, 외과, 치과, 안과 </div></div>
      </div>
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

<!-- 동물병원 섹션 추가 -->
<div class="section">
  <h2>진료 시간</h2>
  <div class="detail-list">
    <div class="detail-item"><div class="label">월요일</div><div class="value">09:00 - 18:00</div></div>
    <div class="detail-item"><div class="label">화요일</div><div class="value">09:00 - 18:00</div></div>
    <div class="detail-item"><div class="label">수요일</div><div class="value">09:00 - 18:00</div></div>
    <div class="detail-item"><div class="label">목요일</div><div class="value">09:00 - 18:00</div></div>
    <div class="detail-item"><div class="label">금요일</div><div class="value">09:00 - 18:00</div></div>
    <div class="detail-item"><div class="label">토요일</div><div class="value">09:00 - 13:00</div></div>
    <div class="detail-item"><div class="label">일요일</div><div class="value">휴무</div></div>
  </div>
</div>

<div class="section">
  <h2>서비스</h2>
  <div class="detail-list">
    <div class="detail-item"><div class="label">응급 치료</div><div class="value">24시간 응급 진료 서비스 제공</div></div>
    <div class="detail-item"><div class="label">예방 접종</div><div class="value">반려동물의 예방 접종 서비스 제공</div></div>
    <div class="detail-item"><div class="label">치료</div><div class="value">내과, 외과, 치과, 피부과 전문 치료</div></div>
    <div class="detail-item"><div class="label">동물 행동 상담</div><div class="value">동물 행동 문제 상담 서비스</div></div>
  </div>
</div>

<div class="section">
  <h2>의료 장비</h2>
  <div class="detail-list">
    <div class="detail-item"><div class="label">X-ray 기기</div><div class="value">고급 X-ray 장비로 정확한 진단</div></div>
    <div class="detail-item"><div class="label">초음파 기기</div><div class="value">동물 건강 상태를 빠르게 확인</div></div>
    <div class="detail-item"><div class="label">혈액 검사</div><div class="value">정밀 혈액 검사 서비스</div></div>
  </div>
</div>

<div class="section">
  <h2>병원 시설</h2>
  <div class="detail-list">
    <div class="detail-item"><div class="label">대기실</div><div class="value">쾌적한 환경의 대기실</div></div>
    <div class="detail-item"><div class="label">수술실</div><div class="value">최신 수술 장비를 갖춘 수술실</div></div>
    <div class="detail-item"><div class="label">입원실</div><div class="value">편안하고 안전한 입원실</div></div>
  </div>
</div>

</div><!-- /.container -->
  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
  (function(){
    // 모델에서 전달된 데이터를 사용하여 좌표값 (위도, 경도)을 가져옵니다.
    var lat = <?= esc($hospital['y_value']); ?>;  // 위도 (y_value)
    var lng = <?= esc($hospital['x_value']); ?>;  // 경도 (x_value)
    var hospitalName = "<?= esc($hospital['b_name']); ?>";  // 병원 이름

    // 네이버 맵을 초기화하고 병원 위치를 표시합니다.
    var map = new naver.maps.Map('map', {
      center: new naver.maps.LatLng(lat, lng),  // 위도와 경도를 사용하여 맵 중심 설정
      zoom: 16
    });

    // 마커를 추가하여 병원 위치 표시
    new naver.maps.Marker({
      position: new naver.maps.LatLng(lat, lng),
      map: map,
      title: hospitalName
    });
  })();
</script>

</body>
</html>