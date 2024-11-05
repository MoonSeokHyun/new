<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>퐁코(퐁퐁코리아)</title>
    <style>
        /* 간단한 스타일링 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .category {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .category a {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        .category a:hover {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>퐁코(퐁퐁코리아)</h1>
    <div class="category">
        <a href="/posts?category=1">퐁퐁이들 소식</a>
        <a href="/posts?category=2">도태남</a>
        <a href="/posts?category=3">알파남</a>
    </div>

    <section>
        <h2>주간 베스트 게시글</h2>
        <!-- 주간 베스트 게시글 예시 -->
        <ul>
            <li><a href="/posts/1">주간 베스트 게시글 1</a></li>
            <li><a href="/posts/2">주간 베스트 게시글 2</a></li>
            <li><a href="/posts/3">주간 베스트 게시글 3</a></li>
        </ul>
    </section>
    
    <footer>
        <p>&copy; 2024 퐁퐁코리아 커뮤니티</p>
    </footer>
</body>
</html>
