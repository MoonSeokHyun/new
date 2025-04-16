<?php
// 안전한 변수 초기화
$installationName = esc($installation['Installation Location Name'] ?? '기본 설치장소');
$fullAddress = esc($installation['Street Address'] ?? '');

// District Name을 안전하게 처리하고 기본값 설정
$districtName = esc($installation['District Name'] ?? '');  // District Name을 안전하게 처리
$districtNameForTitle = $districtName ?: '인근';  // 타이틀에 사용할 값 설정 (빈 값이면 '인근'으로 대체)

// SEO 최적화용 타이틀과 설명 설정
$seoTitle = esc("{$installationName} {$districtNameForTitle} 폐의약품수거장소");
$seoDescription = esc("{$installationName}의 설치장소 상세 정보와 위치, 전화번호, 관리 기관 등을 확인해보세요. {$districtNameForTitle}에 위치한 설치장소입니다.");
$seoKeywords = esc("설치장소, {$installationName}, 폐의약품, {$districtNameForTitle}, {$fullAddress}");
?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($seoTitle) ?></title> <!-- 동적으로 설정된 타이틀 -->
  <meta name="description" content="<?= esc($seoDescription) ?>">
  <meta name="keywords" content="<?= esc($seoKeywords) ?>">
  <meta name="author" content="편잇 팀">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- 네이버 SEO 최적화를 위한 메타 태그 추가 -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:image" content="이미지 URL 또는 경로" />
  <meta property="og:url" content="<?= current_url() ?>" />
  <meta property="og:locale" content="ko_KR" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />
  <meta name="twitter:image" content="이미지 URL 또는 경로" />
  
  <!-- 네이버 지도 API -->
  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  
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

    /* 설치장소 상세 Section */
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

  <!-- 광고 스크립트 (선택사항) -->
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6686738239613464"
     data-ad-slot="1204098626"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
  <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
  </script>

  <!-- 설치장소 상세 정보 -->
  <div class="details">
    <section class="detail-section">
      <div class="detail-header">
        <div class="facility-name"><?= esc($installation['Installation Location Name']) ?></div>
        <div class="facility-type"><?= esc($installation['District Name']) ?> 설치장소</div>
        <div class="sub-info">📍 <?= esc($installation['Street Address']); ?></div>
      </div>

      <h3 class="section-title">설치장소 기본 정보</h3>
      <table class="info-table">
        <tr><th>전화번호</th><td><?= esc($installation['Managing Institution Phone Number']) ?></td></tr>
        <tr><th>주소</th><td><?= esc($installation['Land Lot Address']) ?></td></tr>
        <tr><th>도로명 주소</th><td><?= esc($installation['Street Address']) ?></td></tr>
        <tr><th>세부 위치</th><td><?= esc($installation['Detailed Location']) ?></td></tr>
        <tr><th>관리 기관명</th><td><?= esc($installation['Managing Institution Name']) ?></td></tr>
        <tr><th>데이터 기준일자</th><td><?= esc($installation['Data Reference Date']) ?></td></tr>
        <tr><th>제공기관명</th><td><?= esc($installation['Provider Institution Name']) ?></td></tr>
        <tr><th>제공기관 코드</th><td><?= esc($installation['Provider Institution Code']) ?></td></tr>
      </table>
    </section>

    <!-- 지도 -->
    <div id="map"></div>
  </div>

  <!-- 푸터 -->
  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    // 지도 초기화
    (function() {
      var lat = parseFloat("<?= esc($installation['Latitude']); ?>");  // 변환된 위도 값
      var lng = parseFloat("<?= esc($installation['Longitude']); ?>"); // 변환된 경도 값
      var name = "<?= esc($installation['Installation Location Name']); ?>";

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
