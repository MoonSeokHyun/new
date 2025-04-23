<?php
// 안전 초기화
$facilityName    = esc($library['Library Name'] ?? '도서관');
$roadAddress     = esc($library['Address (Road Name)'] ?? '');
$landLotAddress  = esc($library['Address (Land Lot)'] ?? '');
$lat             = esc($library['Latitude'] ?? '0');
$lng             = esc($library['Longitude'] ?? '0');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $landLotAddress, $m);
$district        = $m[0] ?? '지역';

// SEO용 메타
$seoTitle = esc("{$facilityName} {$library['City/County/District']} 도서관 상세정보 | 위치・운영시간・편의시설");
$seoDescription  = esc("{$facilityName} 도서관의 위치 ({$district} {$landLotAddress}), 운영시간, 편의시설 등 모든 정보를 확인하세요.");
$seoKeywords     = esc("도서관, {$facilityName}, {$district}, {$landLotAddress}, 운영시간, 시설");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $seoTitle ?></title>

    <!-- SEO 메타 태그 -->
    <meta name="description" content="<?= $seoDescription ?>" />
    <meta name="keywords" content="<?= $seoKeywords ?>" />
    <meta name="author" content="도서관 정보 제공" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $seoTitle ?>" />
    <meta property="og:description" content="<?= $seoDescription ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:locale" content="ko_KR" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?= $seoTitle ?>" />
    <meta name="twitter:description" content="<?= $seoDescription ?>" />

    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>

    <style>
        body { background: #f5f5f5; font-family: 'Noto Sans KR', sans-serif; color: #333; margin: 0; padding: 0; }
        a { color: #0078ff; text-decoration: none; }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .content-title { font-size: 2rem; margin-bottom: .5rem; border-bottom: 2px solid #0078ff; padding-bottom: .3rem; }
        .breadcrumb { font-size: .9rem; color: #555; margin-bottom: 1.5rem; }
        .ad-box { margin: 1.5rem 0; text-align: center; }
        .section { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem; padding: 1.5rem; }
        .section h2 { font-size: 1.2rem; margin-bottom: 1rem; color: #0078ff; border-left: 4px solid #0078ff; padding-left: .5rem; }
        .detail-list { margin: 0; padding: 0; }
        .detail-item { display: flex; justify-content: space-between; padding: .75rem 0; border-bottom: 1px solid #eee; }
        .detail-item:last-child { border-bottom: none; }
        .label { font-weight: 600; color: #333; }
        .value { color: #555; text-align: right; }
        #map { width: 100%; height: 300px; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="content-title"><?= esc($library['Library Name']) ?> 📚</h1>

    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('LibraryInfo') ?>">도서관 목록</a> &gt;
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
        <div class="detail-item"><div class="label">도서관 이름</div><div class="value"><?= esc($library['Library Name']); ?></div></div>
        <div class="detail-item"><div class="label">도시/도</div><div class="value"><?= esc($library['Province/City']); ?></div></div>
        <div class="detail-item"><div class="label">구/군/구역</div><div class="value"><?= esc($library['City/County/District']); ?></div></div>
        <div class="detail-item"><div class="label">도서관 유형</div><div class="value"><?= esc($library['Library Type']); ?></div></div>
        <div class="detail-item"><div class="label">웹사이트 URL</div><div class="value"><?= esc($library['Website URL']); ?></div></div>
        <div class="detail-item"><div class="label">휴관일</div><div class="value"><?= esc($library['Closed Days']); ?></div></div>
      </div>
    </div>

    <!-- 운영 시간 -->
    <div class="section">
      <h2>운영 시간</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">평일 개방 시간</div><div class="value"><?= esc($library['Weekday Opening Time']); ?></div></div>
        <div class="detail-item"><div class="label">평일 폐장 시간</div><div class="value"><?= esc($library['Weekday Closing Time']); ?></div></div>
        <div class="detail-item"><div class="label">토요일 개방 시간</div><div class="value"><?= esc($library['Saturday Opening Time']); ?></div></div>
        <div class="detail-item"><div class="label">토요일 폐장 시간</div><div class="value"><?= esc($library['Saturday Closing Time']); ?></div></div>
        <div class="detail-item"><div class="label">공휴일 개방 시간</div><div class="value"><?= esc($library['Holiday Opening Time']); ?></div></div>
        <div class="detail-item"><div class="label">공휴일 폐장 시간</div><div class="value"><?= esc($library['Holiday Closing Time']); ?></div></div>
      </div>
    </div>

    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
    </div>
    <div class="section">
         <h2>도서관 정보</h2>
         <div class="detail-item"><div class="label">열람 좌석 수</div><div class="value"><?= esc($library['Number of Reading Seats']); ?></div></div>
        <div class="detail-item"><div class="label">도서 수</div><div class="value"><?= esc($library['Number of Materials (Books)']); ?></div></div>
        <div class="detail-item"><div class="label">정기 간행물 수</div><div class="value"><?= esc($library['Number of Materials (Serials)']); ?></div></div>
        <div class="detail-item"><div class="label">비도서 자료 수</div><div class="value"><?= esc($library['Number of Materials (Non-Book)']); ?></div></div>
        <div class="detail-item"><div class="label">대출 가능한 항목 수</div><div class="value"><?= esc($library['Number of Lending Items Allowed']); ?></div></div>
        <div class="detail-item"><div class="label">대출 기간 (일)</div><div class="value"><?= esc($library['Lending Period (Days)']); ?></div></div>
        <div class="detail-item"><div class="label">주소 (도로명)</div><div class="value"><?= esc($library['Address (Road Name)']); ?></div></div>
        <div class="detail-item"><div class="label">운영 기관</div><div class="value"><?= esc($library['Operating Organization']); ?></div></div>
        <div class="detail-item"><div class="label">도서관 전화번호</div><div class="value"><?= esc($library['Library Phone Number']); ?></div></div>
    </div>

    <!-- 추가 정보 -->
    <div class="section">
      <h2>추가 정보</h2>
      <div class="detail-list">
  
        <div class="detail-item"><div class="label">토지 면적</div><div class="value"><?= esc($library['Land Area']); ?></div></div>
        <div class="detail-item"><div class="label">건물 면적</div><div class="value"><?= esc($library['Building Area']); ?></div></div>
        <div class="detail-item"><div class="label">데이터 참조 날짜</div><div class="value"><?= esc($library['Data Reference Date']); ?></div></div>
        <div class="detail-item"><div class="label">제공 조직 코드</div><div class="value"><?= esc($library['Providing Organization Code']); ?></div></div>
        <div class="detail-item"><div class="label">제공 조직 이름</div><div class="value"><?= esc($library['Providing Organization Name']); ?></div></div>
      </div>
    </div>

    <!-- 지도 -->
    <div class="section">
      <h2>지도</h2>
      <div id="map"></div>
    </div>
  </div><!-- /.container -->

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
      var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(parseFloat("<?= $library['Latitude'] ?>"), parseFloat("<?= $library['Longitude'] ?>")),
        zoom: 16
      });
      new naver.maps.Marker({
        position: map.getCenter(),
        map: map,
        title: "<?= esc($library['Library Name']) ?>"
      });
    })();
  </script>

</body>
</html>
