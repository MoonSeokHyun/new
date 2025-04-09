<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>퐁퐁코리아</title>
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
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            margin-bottom: 20px;
        }

        h1 {
            font-size: 40px;
            color: #5a8f9e;
            margin-bottom: 10px;
        }

        .sub-heading {
            font-size: 24px;
            color: #555;
            margin-bottom: 30px;
        }

        /* 상단 "메인으로 돌아가기" 버튼과 검색박스 레이아웃 설정 */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* "메인으로 돌아가기" 버튼 */
        .main-button {
            padding: 8px 15px;
            font-size: 16px;
            background-color: #ff6f61;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .main-button:hover {
            background-color: #e05a49;
        }

        /* 검색 박스 */
        .search-box {
            display: flex;
            align-items: center;
        }

        .search-box input {
            padding: 10px;
            font-size: 16px;
            width: 250px;
            margin-right: 10px;
            border-radius: 30px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-box input:focus {
            border-color: #5a8f9e;
        }

        .search-box button {
            padding: 10px 25px;
            font-size: 16px;
            border: none;
            background-color: #5a8f9e;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-box button:hover {
            background-color: #4a7f89;
        }

        /* 그리드 레이아웃 */
        main {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3개씩 그리드로 변경 */
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* 카드 스타일 */
        .icon-card {
            background-color: #ffcccb;
            border-radius: 12px;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            width: 100%;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .icon-card:hover {
            transform: scale(1.05);
            background-color: #ffb3b3;
        }

        /* 아이콘 스타일 */
        .icon-card i {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .icon-card p {
            font-size: 16px;
            margin-top: 10px;
        }

        /* 페이징 스타일 */
        .pagination {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        .pagination a {
            padding: 10px 15px;
            background-color: #5a8f9e;
            color: white;
            border-radius: 5px;
            margin: 0 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .pagination a:hover {
            background-color: #4a7f89;
        }

        .pagination .active {
            background-color: #ffb3b3;
        }

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

        /* 모바일 최적화 */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr); /* 2개씩 그리드로 변경 */
            }

            .pagination a {
                font-size: 14px;
                padding: 8px 12px;
            }

            .icon-card {
                height: 150px;
                padding: 15px;
                font-size: 14px;
            }

            .search-box input {
                width: 100%; /* 모바일에서는 입력창을 가득 채우도록 */
            }

            .main-button {
                width: 100%; /* 모바일에서는 버튼이 가득 차도록 */
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr; /* 1개씩 그리드로 변경 */
            }

            .pagination a {
                font-size: 12px;
                padding: 6px 10px;
            }

            .icon-card {
                height: 250px; /* 모바일에서는 카드 높이를 조금 늘림 */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>퐁퐁코리아</h1>
            <p class="sub-heading">생활정보를 한눈에, 퐁퐁코리아!</p>
        </header>

        <!-- 상단 버튼 및 검색박스를 왼쪽과 오른쪽 끝으로 배치 -->
        <div class="top-bar">
            <a href="/" class="main-button">메인으로 돌아가기</a>

            <div class="search-box">
                <form method="get">
                    <input type="text" name="search" value="<?= esc($search) ?>" placeholder="검색...">
                    <button type="submit">검색</button>
                </form>
            </div>
        </div>

        <main>
            <div class="grid">
                <?php foreach ($salons as $salon): ?>
                <div class="icon-card">
                    <a href="/hairsalon/detail/<?= esc($salon['id']) ?>" style="display: block; height: 100%;">
                        <i>💇‍♀️</i>
                    </a>
                    <div class="card-info">
                        <p><strong>비즈니스명:</strong> <?= esc($salon['business_name']) ?></p>
                        <p><strong>주소:</strong> <?= esc($salon['full_address']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- 페이징 -->
            <div class="pagination">
                <?= $pager->links('salons', 'default_full') ?>
            </div>
        </main>
    </div>

    <footer>
        <p>이 데이터는 공공데이터 <a href="https://www.data.go.kr" target="_blank">www.data.go.kr</a>을 활용하여 만든 웹사이트입니다. 사용 방법 혹은 정보 변경 요청은 <a href="mailto:gjqmaoslwj@naver.com">gjqmaoslwj@naver.com</a>으로 연락 주시기 바랍니다.</p>
    </footer>
</body>
</html>
