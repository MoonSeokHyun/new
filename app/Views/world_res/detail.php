<?php
// 안전 초기화 및 구·읍·면 추출
$name       = esc($restaurant['FCLTY_NM']             ?? '세계 음식점');
$roadAddr   = esc($restaurant['RDNMADR_NM']           ?? '');
$lotAddr    = esc($restaurant['LNM_ADDR']             ?? '');
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $roadAddr . ' ' . $lotAddr, $m);
$district   = $m[0] ?? '지역';
$lat        = esc($restaurant['LC_LA']                ?? '0');
$lng        = esc($restaurant['LC_LO']                ?? '0');

// SEO 메타
$title      = "{$district} {$name} – 세계 음식점 상세 | 위치·영업시간·편의시설";
$description= "{$district}에 위치한 {$name}의 주소({$roadAddr} {$lotAddr}), 전화번호, 영업시간, 주차·편의시설 정보를 모두 확인하세요.";
$url        = current_url();
$keywords   = implode(',', [$district, $name, '세계음식','맛집','세계음식점']);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($title) ?></title>
  <meta name="description" content="<?= esc($description) ?>" />
  <meta name="keywords" content="<?= esc($keywords) ?>" />
  <meta name="robots" content="index,follow" />
  <link rel="canonical" href="<?= esc($url) ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Open Graph -->
  <meta property="og:type"        content="restaurant" />
  <meta property="og:title"       content="<?= esc($title) ?>" />
  <meta property="og:description" content="<?= esc($description) ?>" />
  <meta property="og:url"         content="<?= esc($url) ?>" />
  <meta property="og:locale"      content="ko_KR" />

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary" />
  <meta name="twitter:title"       content="<?= esc($title) ?>" />
  <meta name="twitter:description" content="<?= esc($description) ?>" />

  <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->
  <style>
    body { background:#f1f1f1; font-family:Arial,sans-serif; color:#333; margin:0; padding:0; }
    /* 헤더 내부 h1 스타일과 충돌 방지 */
    header h1 { color: inherit; }  
    /* 이 페이지 전용 제목 스타일 */
    .detail-title { 
      font-size:2rem; 
      margin-bottom:0.5rem; 
      border-bottom:2px solid #62D491; 
      padding-bottom:0.3rem; 
      color:#62D491;
    }
    .container{ max-width:800px; margin:2rem auto; padding:1rem; }
    .breadcrumb{ font-size:0.9rem; color:#555; margin-bottom:1rem; }
    .breadcrumb a { color:#0078ff; text-decoration:none; }
    .breadcrumb a:hover { text-decoration:underline; }
    .section{ background:#fff; border-radius:8px; padding:1.5rem; margin-bottom:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.1); }
    .section h2{ font-size:1.2rem; margin-bottom:1rem; color:#0078ff; border-left:4px solid #0078ff; padding-left:0.5rem; }
    .detail-list{ list-style:none; padding:0; margin:0; }
    .detail-item{ display:flex; justify-content:space-between; padding:0.75rem 0; border-bottom:1px solid #eee; }
    .detail-item:last-child{ border-bottom:none; }
    .label{ font-weight:600; }
    .value{ color:#555; text-align:right; }
    a.back{ display:inline-block; margin-top:1rem; color:#0078ff; text-decoration:none; }
    a.back:hover{ text-decoration:underline; }
    #map{ width:100%; height:300px; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-top:1rem; }
  </style>
</head>
<body>

<?php include APPPATH . 'Views/includes/header.php'; ?>
<div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
    </div>

<main class="container">
  <h1 class="detail-title"><?= esc($district) ?> <?= esc($name) ?></h1>
  <div class="breadcrumb">
    <a href="<?= site_url() ?>">홈</a> › 
    <a href="<?= site_url('world_res') ?>">세계 음식점 목록</a> › 
    상세정보
  </div>

  <div class="section" aria-labelledby="basic-info">
    <h2 id="basic-info">기본 정보</h2>
    <ul class="detail-list">
      <li class="detail-item"><span class="label">시설명</span><span class="value"><?= esc($name) ?></span></li>
      <li class="detail-item"><span class="label">카테고리</span><span class="value"><?= esc("{$restaurant['CTGRY_ONE_NM']} / {$restaurant['CTGRY_TWO_NM']} / {$restaurant['CTGRY_THREE_NM']}") ?></span></li>
      <li class="detail-item"><span class="label">주소</span><span class="value"><?= esc($roadAddr) ?> <?= esc($lotAddr) ?></span></li>
      <li class="detail-item"><span class="label">전화번호</span><span class="value"><?= esc($restaurant['TEL_NO']) ?></span></li>
      <li class="detail-item"><span class="label">최종 수정일</span><span class="value"><?= esc($restaurant['LAST_UPDT_DE']) ?></span></li>
    </ul>
  </div>

  <div class="section" aria-labelledby="hours-info">
    <h2 id="hours-info">영업시간</h2>
    <ul class="detail-list">
      <li class="detail-item"><span class="label">주중</span><span class="value"><?= esc($restaurant['WORKDAY_OPER_TIME_DC']) ?></span></li>
      <li class="detail-item"><span class="label">주말</span><span class="value"><?= esc($restaurant['WKEND_OPER_TIME_DC']) ?></span></li>
    </ul>
  </div>

  <div class="section" aria-labelledby="parking-info">
    <h2 id="parking-info">주차 & 편의시설</h2>
    <ul class="detail-list">
      <li class="detail-item"><span class="label">무료주차</span><span class="value"><?= esc($restaurant['FRE_PARKNG_AT']) ?></span></li>
      <li class="detail-item"><span class="label">발렛주차</span><span class="value"><?= esc($restaurant['VALET_PARKNG_POSBL_AT']) ?></span></li>
      <li class="detail-item"><span class="label">의자 대여</span><span class="value"><?= esc($restaurant['INFN_CHAIR_LEND_POSBL_AT']) ?></span></li>
      <li class="detail-item"><span class="label">휠체어 보유</span><span class="value"><?= esc($restaurant['WCHAIR_HOLD_AT']) ?></span></li>
      <li class="detail-item"><span class="label">반려동물</span><span class="value"><?= esc($restaurant['PET_POSBL_AT']) ?></span></li>
      <li class="detail-item"><span class="label">채식 메뉴</span><span class="value"><?= esc($restaurant['VGTR_MENU_HOLD_AT']) ?></span></li>
      <li class="detail-item"><span class="label">할랄</span><span class="value"><?= esc($restaurant['HALAL_FOOD_HOLD_AT']) ?></span></li>
      <li class="detail-item"><span class="label">글루텐프리</span><span class="value"><?= esc($restaurant['GFRE_FOOD_HOLD_AT']) ?></span></li>
    </ul>
  </div>

  <div id="map"></div>

  <a href="<?= site_url('world_res') ?>" class="back">← 목록으로 돌아가기</a>
</main>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
//   const map = new naver.maps.Map('map', {
//     center: new naver.maps.LatLng(parseFloat("<?= $lat ?>"), parseFloat("<?= $lng ?>")),
//     zoom: 16
//   });
//   new naver.maps.Marker({
//     position: map.getCenter(),
//     map: map
//   });
</script>
</body>
</html>
