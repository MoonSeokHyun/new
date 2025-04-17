<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- 네이버 지도 API (불필요 시 제거) -->
    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  
    <!-- 광고 스크립트 -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

    <title>체육시설 목록 - 퐁퐁코리아</title>

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

        /* 제목 스타일 */
        .page-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* 카드 그리드 */
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

        /* 모바일 최적화 */
        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
                margin-top: 10px;
            }
            .card-container {
                grid-template-columns: 1fr;
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include APPPATH . 'Views/includes/header.php'; ?>

<h1 class="page-title">공공 체육시설 목록</h1>
<div class="card-container">
    <?php foreach ($facilities as $f): ?>
    <div class="card" onclick="window.location='<?= site_url('sports_facilities/' . $f['id']) ?>'">
        <h3>🏟️ <?= esc($f['FCLTY_NM']) ?></h3>
        <p>📍 <?= esc($f['RDNMADR_NM'] ?? '주소 정보 없음') ?></p>
        <p>📞 <?= esc($f['RSPNSBLTY_TEL_NO'] ?? '연락처 없음') ?></p>
    </div>
    <?php endforeach; ?>
</div>


<?php include APPPATH . 'Views/includes/footer.php'; ?>

</body>
</html>
