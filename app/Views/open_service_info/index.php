<!-- app/Views/open_service_info/index.php -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전국 안경점 목록 퐁코</title>

    <!-- 네이버 지도 API (필요 없으시면 제거) -->
    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  
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
            margin: 5px 0;
        }
        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
                margin-top: 10px;
            }
            .card-container {
                grid-template-columns: 1fr;
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
    <h1 class="page-title">전국 안경점 목록을 확인하세요! 👓</h1>

    <?php if (! empty($shops) && is_array($shops)): ?>
    <div class="card-container">
        <?php foreach ($shops as $shop): ?>
            <div class="card" onclick="window.location='<?= site_url('shops/' . $shop['id']) ?>'">
                <h3><?= esc($shop['BusinessName']) ?> 👓</h3>
                <p>지역: <?= esc($shop['Area']) ?> 📍</p>
                <p>주소: <?= esc($shop['RoadAddress'] ?: $shop['FullAddress']) ?> 🏠</p>
                <p>업종: <?= esc($shop['BusinessTypeName']) ?> 🛠️</p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p style="text-align:center; margin-top:20px;">등록된 안경점이 없습니다.</p>
    <?php endif; ?>

    <?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>
