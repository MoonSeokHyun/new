<?php
helper('url');
$canonical = site_url('camping');
$seoTitle = '캠핑장 목록 | 지역별 캠핑장 정보';
$seoDesc = '전국 캠핑장 주소와 최신 업데이트 정보를 확인하고 상세 페이지에서 위치와 주변 정보를 확인하세요.';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($seoTitle) ?></title>
    <meta name="description" content="<?= esc($seoDesc) ?>" />
    <meta name="robots" content="index,follow,max-image-preview:large" />
    <link rel="canonical" href="<?= esc($canonical) ?>" />
    <link rel="alternate" href="<?= esc($canonical) ?>" hreflang="ko" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= esc($seoTitle) ?>" />
    <meta property="og:description" content="<?= esc($seoDesc) ?>" />
    <meta property="og:url" content="<?= esc($canonical) ?>" />
    <meta property="og:locale" content="ko_KR" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
    <meta name="twitter:description" content="<?= esc($seoDesc) ?>" />

    <!-- 네이버 지도 API (필요 없으시면 제거) -->
    <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->
  
    <!-- 광고 스크립트 -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .main-nav {
            background-color: #e6f7ef;
            padding: 0.7rem;
            text-align: center;
        }

        .page-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .search-bar {
            padding: 10px;
            margin: 20px auto;
            text-align: center;
        }

        .search-bar input {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-bar button {
            padding: 10px;
            font-size: 16px;
            background-color: #62D491;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #55b379;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            width: 80%;
            margin: 0 auto;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h3 {
            margin: 10px 0;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #62D491;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .pagination a:hover {
            background-color: #55b379;
        }

        .pagination .active {
            background-color: #4e9e68;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
                margin-top: 10px;
            }

            .search-bar input {
                width: 90%;
            }

            .card-container {
                grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
            }

            .pagination a {
                padding: 6px 12px;
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

<h1 class="page-title">캠핑장 목록</h1>

<div class="card-container">
    <?php 
      $count = 0;
      foreach ($campings as $camping): 
        $count++;
    ?>
    <div class="card" onclick="window.location='<?= site_url('camping/' . $camping['id']) ?>'">
        <h3><?= esc($camping['FCLTY_NM']) ?> ⛺</h3>
        <p><?= esc($camping['RDNMADR_NM']) ?> 📍</p>
        <p>Last updated: <?= esc($camping['LAST_UPDT_DE']) ?> ⏰</p>
    </div>
    
    <!-- 광고 중간 삽입 (6개 카드 후) -->
    <?php if ($count === 6): ?>
      <div style="grid-column:1/-1; margin:1rem 0; text-align:center;">
        <ins class="adsbygoogle"
          style="display:block"
          data-ad-client="ca-pub-6686738239613464"
          data-ad-slot="1204098626"
          data-ad-format="auto"
          data-full-width-responsive="true"></ins>
      </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<!-- 광고(하단) -->
<div style="text-align:center; margin:2rem 0;">
  <ins class="adsbygoogle"
    style="display:block"
    data-ad-client="ca-pub-6686738239613464"
    data-ad-slot="1204098626"
    data-ad-format="auto"
    data-full-width-responsive="true"></ins>
</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

</body>
</html>
