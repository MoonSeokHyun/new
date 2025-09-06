<?php
// 안전 초기화
$facilityName    = esc($room->FCLTY_NM      ?? '세미나룸');
$roadAddress     = esc($room->RDNMADR_NM   ?? '');
$landLotAddress  = esc($room->LNM_ADDR      ?? '');
$lat             = esc($room->LC_LA        ?? '0');
$lng             = esc($room->LC_LO        ?? '0');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $landLotAddress, $m);
$district        = $m[0] ?? '지역';

// SEO용 메타
$seoTitle        = esc("{$facilityName} – {$district} {$landLotAddress} 세미나룸 상세정보 | 위치・운영시간・편의시설");
$seoDescription  = esc("{$facilityName} 세미나룸의 위치({$district} {$landLotAddress}), 운영시간, 편의 시설 등 모든 정보를 확인하세요.");
$seoKeywords     = esc("세미나룸, {$facilityName}, {$district}, {$landLotAddress}, 운영시간, 시설");

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

  <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->

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
    <h1 class="content-title"><?= $facilityName ?></h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('seminar_rooms') ?>">세미나룸 목록</a> &gt;
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
        <div class="detail-item"><div class="label">시설명</div><div class="value"><?= $facilityName ?></div></div>
        <div class="detail-item"><div class="label">행정주소</div><div class="value"><?= $roadAddress ?></div></div>
        <div class="detail-item"><div class="label">지번주소</div><div class="value"><?= $landLotAddress ?></div></div>
        <div class="detail-item"><div class="label">최종 업데이트</div><div class="value"><?= esc($room->LAST_UPDT_DE) ?></div></div>
      </div>
    </div>

    <!-- 운영 시간 -->
    <div class="section">
      <h2>운영 시간</h2>
      <div class="detail-list">
        <?php
          $days   = ['월','화','수','목','금','토','일'];
          $fields = ['MON_OPER_TIME','TUES_OPER_TIME','WED_OPER_TIME','THUR_OPER_TIME','FRI_OPER_TIME','SAT_OPER_TIME','SUN_OPER_TIME'];
          foreach($days as $i => $day): ?>
            <div class="detail-item">
              <div class="label"><?= $day ?>요일</div>
              <div class="value"><?= esc($room->{$fields[$i]}) ?></div>
            </div>
        <?php endforeach; ?>
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

    <!-- 편의 시설 -->
    <div class="section">
      <h2>편의 시설</h2>
      <div class="detail-list">
        <?php
          $amenities = [
            '성인 시설'    => 'ADO_FCLTY_HOLD_AT',
            '추가 의자'    => 'ADIT_CHAIR_HOLD_AT',
            '프린터'       => 'PRINTER_HOLD_AT',
            'TV'           => 'TV_HOLD_AT',
            '주차 가능'    => 'PARKNG_POSBL_AT',
            'WiFi'         => 'WIFI_HOLD_AT',
          ];
          foreach($amenities as $label => $field): ?>
            <div class="detail-item">
              <div class="label"><?= $label ?></div>
              <div class="value"><?= esc($room->{$field}) ?></div>
            </div>
        <?php endforeach; ?>
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

    <!-- 지도 -->
    <div class="section">
      <h2>지도</h2>
      <div id="map"></div>
    </div>
  </div><!-- /.container -->

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
//         title: "<?= $facilityName ?>"
//       });
    })();
  </script>
</body>
</html>
