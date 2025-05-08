<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>동물병원 목록</title>

    <!-- 광고 스크립트 -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

    <!-- 스타일 -->
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

        /* 페이징 */
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

        /* 모바일 최적화 */
        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
                margin-top: 10px;
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

<h1 class="page-title">동물병원 목록</h1>

<div class="card-container">
    <?php foreach ($hospitals as $hospital): ?>
    <div class="card" onclick="window.location='<?= site_url('animal_hospital/detail/' . $hospital['id']) ?>'">
        <h3><?= esc($hospital['b_name']) ?> 🏥</h3>
        <p><?= esc($hospital['new_address']) ?> 🏠</p>
        <p>상태: <?= esc($hospital['b_status']) ?></p>
    </div>
    <?php endforeach; ?>
</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

</body>
</html>
