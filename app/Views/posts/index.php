<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 목록</title>
    <style>
        /* 전체 스타일 */
        body {
            font-family: '돋움', 'Arial', sans-serif;
            background-color: #222;
            color: #ddd;
            margin: 0;
            padding: 20px;
        }

        /* 네비게이션 바 스타일 */
        #hd_section {
            background-color: #333;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        #hd_section a {
            color: #00d8ff;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            padding: 8px;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }
        #hd_section a:hover {
            background-color: #444;
            border-radius: 3px;
        }

        /* 모바일 메뉴 버튼 스타일 */
        .menu-toggle {
            display: none;
            background-color: transparent;
            border: none;
            font-size: 20px;
            color: #00d8ff;
            cursor: pointer;
        }

        /* 드롭다운 메뉴 스타일 */
        .hd_dd_menu {
            position: relative;
        }
        .hd_dd_menu ul {
            display: flex;
            list-style: none;
            flex-wrap: wrap;
        }
        .hd_dd_menu .has-sub {
            position: relative;
        }
        .hd_dd_menu .has-sub .dd_toggle {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #444;
            border-radius: 3px;
            padding: 8px 0;
            min-width: 120px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .hd_dd_menu .has-sub:hover .dd_toggle {
            display: block;
        }
        .hd_dd_menu .has-sub .dd_toggle a {
            color: #ddd;
            display: block;
            padding: 6px 15px;
            text-decoration: none;
            font-size: 0.85em;
        }
        .hd_dd_menu .has-sub .dd_toggle a:hover {
            background-color: #333;
        }

        /* 모바일 스타일 */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .hd_dd_menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #333;
                padding: 10px 0;
                border-radius: 3px;
            }
            .hd_dd_menu.active {
                display: flex;
            }
        }

        /* 게시글 목록 스타일 */
        h1 {
            color: #eee;
            font-size: 1.5em;
            margin-bottom: 15px;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #00d8ff;
        }

        a:hover {
            color: #00b0d4;
        }

        .btn {
            background-color: #333;
            color: #00d8ff;
            padding: 8px 12px;
            border: 1px solid #555;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.9em;
            text-align: center;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn:hover {
            background-color: #444;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #444;
            background-color: #333;
            color: #ddd;
            width: calc(100% - 100px);
            margin-right: 5px;
            border-radius: 3px;
        }

        button[type="submit"] {
            padding: 8px 12px;
            border: 1px solid #555;
            background-color: #333;
            color: #00d8ff;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #444;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            background-color: #333;
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 5px;
            border: 1px solid #444;
        }

        li a {
            color: #00d8ff;
            font-weight: bold;
        }

        li p {
            margin: 4px 0;
            color: #aaa;
            font-size: 0.85em;
        }

        .pagination {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
            justify-content: center;
        }

        .pagination a, .pagination strong {
            padding: 6px 10px;
            border-radius: 3px;
            border: 1px solid #555;
            margin: 0 3px;
            color: #00d8ff;
            background-color: #333;
            font-size: 0.85em;
        }

        .pagination a:hover {
            background-color: #444;
            color: #00b0d4;
        }

        .pagination strong {
            background-color: #00d8ff;
            color: #222;
            border-color: #00d8ff;
        }

        h2 {
            font-size: 1em;
            color: #888;
            margin-bottom: 15px;
        }

        /* 모바일 친화적 스타일 조정 */
        @media (max-width: 480px) {
            h1 {
                font-size: 1.5em; /* 제목 크기 조정 */
            }
            h2 {
                font-size: 1em; /* 부제목 크기 조정 */
            }
            .btn {
                font-size: 0.8em; /* 버튼 크기 조정 */
            }
            input[type="text"], button[type="submit"] {
                font-size: 0.8em; /* 입력 폼 크기 조정 */
            }
            li {
                padding: 10px; /* 리스트 아이템 패딩 조정 */
            }
        }
    </style>
</head>
<body>

<div id="hd_section">
    <a href="//pongpongkorea.co.kr/">풍코</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/main">메인</a></li>
            <li class="has-sub">
                <a href="#">공지사항</a>
                <div class="dd_toggle">
                    <a href="/posts?category=99">공지사항</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">베스트 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=9">풍코 베스트</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">전체 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=1">풍코 토론</a>
                    <a href="/posts?category=8">풍코 이슈</a>
                    <a href="/posts?category=4">자유 게시판</a>
                    <a href="/posts?category=7">유머 게시판</a>
                </div>
            </li>
        </ul>
    </div>
</div>


<!-- 글쓰기 버튼 -->
<a class="btn" href="/posts/create?category=<?= esc($category) ?>">글쓰기</a>

<!-- 검색 폼 -->
<form action="/posts" method="get">
    <input type="hidden" name="category" value="<?= esc($category) ?>">
    <input type="text" name="search" placeholder="검색어를 입력하세요" value="<?= esc($search) ?>">
    <button type="submit">검색</button>
</form>

<h2>카테고리: <?= esc($categoryName) ?></h2>

<!-- 게시글 목록 -->
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="/posts/<?= $post['id'] ?>">
                <?= esc($post['title']) ?> <span style="font-weight:normal; color: #bbb;">(작성자: <?= esc($post['nickname']) ?>)</span>
            </a>
            <p>조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
        </li>
    <?php endforeach; ?>
</ul>

<!-- 페이징 링크 -->
<div class="pagination">
    <?= $pager->links() ?>
</div>

<script>
    // 메뉴 토글 함수
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }
</script>

</body>
</html>
