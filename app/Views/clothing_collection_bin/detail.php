<?php
// 폐의류 수거함의 도로명 주소 예시
$road_address = esc($bin['Street Address'] ?? '');

// 구 이름이나 읍 이름을 추출하기 위한 정규 표현식
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $road_address, $matches);

// 구 또는 읍 이름을 추출
$district_name = isset($matches[0]) ? $matches[0] : '지역';

// 'Detailed Location'도 추가하여 타이틀을 더욱 구체적으로 작성
$detailedLocation = esc($bin['Detailed Location'] ?? '');

// 타이틀 생성 (사람들이 클릭하고 싶게끔 유도)
$seoTitle = esc("{$detailedLocation}폐의류 수거함 - {$district_name}에 위치한 수거함 정보, 위치, 세부 위치, 전화번호, 관리기관 확인!");

// SEO 설명 추가
$seoDescription = esc("폐의류 수거함 상세 정보 - 위치, 세부 위치, 전화번호, 관리기관, 제공기관 정보 등 확인해보세요.");
$seoKeywords = esc("폐의류 수거함, {$district_name}, 수거함, 위치, 세부위치, 전화번호, 제공기관");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($seoTitle) ?></title> <!-- 동적으로 설정된 타이틀 -->
    
    <!-- SEO 최적화 메타 태그 -->
    <meta name="description" content="<?= esc($seoDescription) ?>">
    <meta name="keywords" content="<?= esc($seoKeywords) ?>">
    <meta name="author" content="편잇 팀">
    
    <!-- Open Graph Tags for Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= esc($seoTitle) ?>">
    <meta property="og:description" content="<?= esc($seoDescription) ?>">
    <meta property="og:image" content="이미지 URL 또는 경로">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:locale" content="ko_KR">
    
    <!-- Twitter Tags for Social Media -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($seoTitle) ?>">
    <meta name="twitter:description" content="<?= esc($seoDescription) ?>">
    <meta name="twitter:image" content="이미지 URL 또는 경로">
    
    <!-- 네이버 지도 API -->
    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>

  <!-- 광고 스크립트 (선택사항) -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }



        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .detail-card {
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .detail-card h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .detail-card p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .detail-card p strong {
            color: #333;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table th, .info-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .info-table th {
            background-color: #f5f5f5;
            color: #555;
        }

        .info-table td {
            color: #777;
        }

        .main-button {
            display: inline-block;
            padding: 10px 20px;
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

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 40px;
            border-radius: 8px;
        }

        #map {
            width: 100%;
            height: 400px;
            margin-top: 30px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            .detail-card h3 {
                font-size: 20px;
            }

            .detail-card p {
                font-size: 14px;
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
<div class="container">
    <header>
        <h1><?= esc($bin['Provider Institution Name']) ?>수거함 위치 정보</h1>
    </header>
  

    <!-- 수거함 상세 정보 카드 -->
    <div class="detail-card">
        <h3><?= esc($bin['Clothing Collection Bin Location Name']) ?> 🚪</h3>
        <p><strong>주소:</strong> <?= esc($bin['Street Address']) ?> 🏠</p>
        <p><strong>관리 기관:</strong> <?= esc($bin['Managing Institution Name']) ?></p>
        <p><strong>전화번호:</strong> <?= esc($bin['Managing Institution Phone Number']) ?> 📞</p>
        <p><strong>세부 위치:</strong> <?= esc($bin['Detailed Location']) ?></p>
        <p><strong>데이터 기준일자:</strong> <?= esc($bin['Data Reference Date']) ?></p>
        <p><strong>제공기관명:</strong> <?= esc($bin['Provider Institution Name']) ?></p>
        <p><strong>취급품목: </strong> 헌옷, 신발, 가방, 침대커버, 인형, 홑이불, 가정용 카펫, 커튼, 담요</p>
        <!-- 돌아가기 버튼 -->
        <a href="/clothingcollectionbin" class="main-button">목록으로 돌아가기</a>
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
<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
    // 지도 초기화
    (function() {
        var lat = parseFloat("<?= esc($bin['Latitude']); ?>");  // 변환된 위도 값
        var lng = parseFloat("<?= esc($bin['Longitude']); ?>"); // 변환된 경도 값
        var name = "<?= esc($bin['Clothing Collection Bin Location Name']); ?>";

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
