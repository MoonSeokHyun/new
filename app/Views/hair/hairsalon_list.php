<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>퐁퐁코리아 - 미용실 목록</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9e6e6;
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
            margin-bottom: 30px;
        }

        h1 {
            font-size: 36px;
            color: #5a8f9e;
            margin-bottom: 20px;
        }

        .sub-heading {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
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
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 900px;
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
            padding: 40px 20px;
            font-size: 22px;
            color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            width: 100%;
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
            font-size: 18px;
            margin-top: 10px;
        }

        .icon-card .info {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }

        /* 검색 박스 */
        .search-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .search-box input {
            padding: 10px;
            font-size: 18px;
            width: 300px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-box button {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            background-color: #5a8f9e;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #4a7f89;
        }

        /* 페이징 스타일 */
        .pagination {
            margin-top: 30px;
            text-align: center;
        }

        .pagination a {
            padding: 10px 15px;
            background-color: #5a8f9e;
            color: white;
            border-radius: 5px;
            margin: 0 5px;
            text-decoration: none;
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
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>퐁퐁코리아</h1>
            <p class="sub-heading">미용실 목록을 확인하세요!</p>
        </header>

        <!-- 검색 박스 -->
        <div class="search-box">
            <form method="get">
                <input type="text" name="search" value="<?= esc($search) ?>" placeholder="미용실 이름 검색...">
                <button type="submit">검색</button>
            </form>
        </div>

        <main>
            <div class="grid">
                <?php foreach ($salons as $salon): ?>
                <div class="icon-card">
                    <!-- 미용실 상세 페이지로 이동 -->
                    <a href="/hairsalon/detail/<?= esc($salon['id']) ?>">
                        <i>💇‍♀️</i>
                        <p><?= esc($salon['open_service_name']) ?></p>
                    </a>
                    <!-- 추가 정보 표시 -->
                    <div class="info">
                        <p><strong>사업자명:</strong> <?= esc($salon['business_name']) ?></p>
                        <p><strong>전화번호:</strong> <?= esc($salon['contact_phone_number']) ?></p>
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
