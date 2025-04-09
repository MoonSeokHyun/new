<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>퐁퐁코리아</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* 기본 스타일 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9e6e6; /* 부드러운 배경 색상 */
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            flex: 1;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header img {
            width: 120px; /* 로고 크기 */
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
            color: #5a8f9e;
            margin-bottom: 10px;
        }

        .search-bar {
            width: 80%;
            max-width: 600px;
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-bar:focus {
            border-color: #5a8f9e;
        }

        /* 그리드 레이아웃 */
        main {
            display: flex;
            justify-content: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 800px; /* 최대 너비 조정 */
        }

        /* 카드 스타일 */
        .icon-card {
            background-color: #ffcccb; /* 부드러운 배경 색상 */
            border-radius: 12px;
            text-align: center;
            padding: 40px 20px;
            font-size: 18px;
            color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            width: 100%; /* 카드 폭을 100%로 설정하여 화면 꽉 차게 */
        }

        .icon-card:hover {
            transform: scale(1.05);
            background-color: #ffb3b3;
        }

        .icon-card:nth-child(1) {
            background-color: #f8d3b2; /* 전화번호 */
        }

        .icon-card:nth-child(2) {
            background-color: #f3e7b3; /* 지역정보 */
        }

        .icon-card:nth-child(3) {
            background-color: #f4d2de; /* 공공기관 */
        }

        .icon-card:nth-child(4) {
            background-color: #a2c8e8; /* 음식점 */
        }

        .icon-card:nth-child(5) {
            background-color: #c9f0c2; /* 병원 */
        }

        .icon-card:nth-child(6) {
            background-color: #f7f0c5; /* 상가 */
        }

        .icon-card:nth-child(7) {
            background-color: #c2dbf4; /* 뉴스 */
        }

        .icon-card:nth-child(8) {
            background-color: #d5c1f5; /* 뉴스 */
        }

        .icon-card:nth-child(9) {
            background-color: #d8e1f5; /* 생활서비스 */
        }

        .icon-card i {
            font-size: 40px;
            margin-bottom: 15px;
            color: #5a8f9e;
        }

        /* 모바일 최적화 (3x3 배열 유지, 카드 크기 확장) */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(3, 1fr); /* 3x3 배열 유지 */
                gap: 20px;
            }

            .search-bar {
                width: 90%;
                font-size: 16px;
            }

            h1 {
                font-size: 28px;
            }

            header img {
                width: 100px;
            }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: repeat(3, 1fr); /* 모바일에서 3x3 배열 유지 */
                gap: 10px;
            }

            .icon-card {
                padding: 30px 15px;
                font-size: 16px; /* 폰트 크기 수정 */
            }

            h1 {
                font-size: 24px;
            }

            .search-bar {
                width: 95%;
                font-size: 14px;
            }
        }

        /* 푸터 스타일 */
        footer {
            background-color: #5a8f9e;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            font-size: 14px;
        }

        footer a {
            color: #f9e6e6;
            text-decoration: none;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <!-- 로고 이미지 추가 -->
            <h1>퐁퐁코리아</h1>
            <input type="text" class="search-bar" placeholder="검색해보세요...">
        </header>
        <main>
            <div class="grid">
                <div class="icon-card">
                    <i class="fas fa-phone-alt"></i>
                    전화번호
                </div>
                <div class="icon-card">
                    <i class="fas fa-map-marker-alt"></i>
                    지역정보
                </div>
                <div class="icon-card">
                    <i class="fas fa-building"></i>
                    공공기관
                </div>
                <div class="icon-card">
                    <i class="fas fa-utensils"></i>
                    음식점
                </div>
                <div class="icon-card">
                    <i class="fas fa-hospital-alt"></i>
                    병원
                </div>
                <div class="icon-card">
                    <i class="fas fa-home"></i>
                    상가
                </div>
                <div class="icon-card">
                    <i class="fas fa-newspaper"></i>
                    뉴스
                </div>
                <div class="icon-card">
                    <i class="fas fa-newspaper"></i>
                    뉴스
                </div>
                <div class="icon-card">
                    <i class="fas fa-cogs"></i>
                    생활서비스
                </div>
            </div>
        </main>
    </div>
    
    <footer>
        <p>이 데이터는 공공데이터 <a href="https://www.data.go.kr" target="_blank">www.data.go.kr</a>을 활용하여 만든 웹사이트 입니다. 사용 방법 혹은 정보 변경 요청은 <a href="mailto:gjqmaoslwj@naver.com">gjqmaoslwj@naver.com</a> 으로 연락 주시기 바랍니다.</p>
    </footer>
</body>
</html>
