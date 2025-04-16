<?php
// 미용실의 도로명 주소 예시
$road_address = esc($salon['road_name_address'] ?? '');

// 구 이름이나 읍 이름을 추출하기 위한 정규 표현식
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $road_address, $matches);

// 구 또는 읍 이름을 추출
$district_name = isset($matches[0]) ? $matches[0] : '지역';

// 타이틀 생성 (사람들이 클릭하고 싶게끔 유도)
$seoTitle = esc("{$salon['business_name']} - {$district_name}에 위치한 최고의 미용실, 전화번호, 서비스, 영업시간 확인!");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<title><?= $seoTitle ?></title>
  <meta name="description" content="<?= esc($salon['road_name_address'] ?? '') ?> 위치의 미용실 <?= esc($salon['open_service_name'] ?? '') ?>의 상세 정보, 전화번호, 영업 상태 등을 확인해보세요.">
  <meta name="keywords" content="미용실, <?= esc($salon['business_name'] ?? '') ?>, 헤어, 네일, 뷰티, <?= esc($salon['road_name_address'] ?? '') ?>">
  <meta name="author" content="편잇 팀">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- 네이버 SEO 최적화를 위한 메타 태그 추가 -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($salon['business_name']) ?> - 미용실 상세 정보" />
  <meta property="og:description" content="<?= esc($salon['road_name_address'] ?? '') ?> 위치의 미용실 <?= esc($salon['open_service_name'] ?? '') ?>의 상세 정보, 전화번호, 영업 상태 등을 확인해보세요." />
  <meta property="og:image" content="<?= esc($salon['image_url'] ?? '기본이미지 URL') ?>" /> <!-- 이미지는 동적으로 변경 -->
  <meta property="og:url" content="<?= current_url() ?>" />
  <meta property="og:locale" content="ko_KR" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= esc($salon['business_name']) ?> - 미용실 상세 정보" />
  <meta name="twitter:description" content="<?= esc($salon['road_name_address'] ?? '') ?> 위치의 미용실 <?= esc($salon['open_service_name'] ?? '') ?>의 상세 정보, 전화번호, 영업 상태 등을 확인해보세요." />
  <meta name="twitter:image" content="<?= esc($salon['image_url'] ?? '기본이미지 URL') ?>" />
  
  
  <!-- 네이버 지도 API -->
  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  
  <!-- 광고 스크립트 (선택사항) -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <style>
    /* 기본 초기화 */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 0 15px;
    }

    a {
      color: inherit;
      text-decoration: none;
    }


    /* 미용실 상세 Section */
    .details {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .detail-section {
      margin-bottom: 20px;
    }

    .detail-header {
      text-align: center;
      margin-bottom: 1rem;
    }

    .facility-name {
      font-size: 22px;
      font-weight: bold;
      color: #333;
    }

    .facility-type {
      font-size: 16px;
      color: #555;
      margin: 5px 0;
    }

    .sub-info {
      font-size: 14px;
      color: #777;
    }

    .section-title {
      font-size: 20px;
      margin-top: 20px;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table th, .info-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .info-table th {
      background-color: #f5f5f5;
    }

    .main-button {
      display: inline-block;
      padding: 10px 15px;
      background-color: #62D491;
      color: white;
      text-align: center;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 20px;
    }

    .main-button:hover {
      background-color: #4db67d;
    }

    /* 지도 스타일 */
    #map {
      width: 100%;
      height: 400px;
      margin-top: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 1rem;
      margin-top: 3rem;
    }

    .details {
    width: 70%; /* 데스크탑에서 70% */
    margin: 0 auto; /* 가운데 정렬 */
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

/* 모바일에서 100%로 보이도록 */
@media (max-width: 768px) {
    .details {
        width: 100%; /* 모바일에서 100% */
        padding: 15px; /* 모바일에서는 약간의 패딩 조정 */
    }
}
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>
  
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6686738239613464"
     data-ad-slot="1204098626"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

  <!-- 미용실 상세 정보 -->
  <div class="details">
    <section class="detail-section">
      <div class="detail-header">
        <div class="facility-name"><?= esc($salon['business_name']) ?></div>
        <div class="facility-type"><?= esc($salon['business_type_name']) ?> 미용실</div>
        <div class="sub-info">📍 <?= esc($salon['road_name_address']); ?></div>
      </div>

      <h3 class="section-title">미용실 기본 정보</h3>
      <table class="info-table">
        <tr><th>전화번호</th><td><?= esc($salon['contact_phone_number']) ?></td></tr>
        <tr><th>주소</th><td><?= esc($salon['full_address']) ?></td></tr>
        <tr><th>도로명 주소</th><td><?= esc($salon['road_name_address']) ?></td></tr>
        <tr><th>사업장 면적</th><td><?= esc($salon['location_area']) ?> m²</td></tr>
        <tr><th>영업 상태</th><td><?= esc($salon['business_status_name']) ?></td></tr>
        <tr><th>상세 영업 상태</th><td><?= esc($salon['detailed_business_status_name']) ?></td></tr>
        <tr><th>폐업일자</th><td><?= esc($salon['closure_date']) ?></td></tr>
        <tr><th>영업 시작일자</th><td><?= esc($salon['permit_date']) ?></td></tr>
        <tr><th>재개업일자</th><td><?= esc($salon['reopening_date']) ?></td></tr>
        <tr><th>최종 수정 시점</th><td><?= esc($salon['last_modification_time']) ?></td></tr>
        <tr><th>업종명</th><td><?= esc($salon['business_type_name']) ?></td></tr>
        <tr><th>위생업태명</th><td><?= esc($salon['hygiene_business_type']) ?></td></tr>
        <tr><th>건물 지상층수</th><td><?= esc($salon['building_upper_floors']) ?>층</td></tr>
        <tr><th>건물 지하층수</th><td><?= esc($salon['building_lower_floors']) ?>층</td></tr>
        <tr><th>의자 수</th><td><?= esc($salon['chair_count']) ?></td></tr>
        <tr><th>침대 수</th><td><?= esc($salon['bed_count']) ?></td></tr>
        <tr><th>여성 종사자 수</th><td><?= esc($salon['female_staff_count']) ?></td></tr>
        <tr><th>남성 종사자 수</th><td><?= esc($salon['male_staff_count']) ?></td></tr>
        <tr><th>다중이용업소 여부</th><td><?= esc($salon['multi_use_business']) ?></td></tr>
      </table>
    </section>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6686738239613464"
     data-ad-slot="1204098626"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
    <!-- 지도 -->
    <div id="map"></div>
  </div>
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6686738239613464"
     data-ad-slot="1204098626"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
  <!-- 푸터 -->
  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    // 지도 초기화
    (function() {
      var lat = parseFloat("<?= esc($latitude); ?>");  // 변환된 위도 값
      var lng = parseFloat("<?= esc($longitude); ?>"); // 변환된 경도 값
      var name = "<?= esc($salon['open_service_name']); ?>";

      var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(lat, lng),
        zoom: 16
      });

      var mainMarker = new naver.maps.Marker({
        position: new naver.maps.LatLng(lat, lng),
        map: map,
        title: name
      });
    })();
  </script>

</body>
</html>
