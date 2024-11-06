<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>풍코 - 게시글 목록</title>
    <style>
        /* 기본 스타일 초기화 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: '돋움', Arial, sans-serif;
            background-color: #222;
            color: #ddd;
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
            color: #ddd;
            font-size: 1.5em;
            margin-bottom: 15px;
            text-align: center;
        }
        .category {
            margin-top: 20px;
            background-color: #333;
            padding: 15px;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .category h2 {
            color: #00d8ff;
            font-size: 1.1em;
            margin-bottom: 10px;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
        }
        .post {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #444;
            font-size: 0.9em;
            color: #ddd;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h3 {
            font-size: 1em;
            flex: 1;
        }
        .post h3 a {
            color: #00d8ff;
            text-decoration: none;
        }
        .post-info {
            text-align: right;
            color: #aaa;
            font-size: 0.8em;
            min-width: 120px;
        }

        /* 작은 화면 스타일 */
        @media (max-width: 480px) {
            .category {
                width: 100%;
                padding: 10px;
            }
            .post {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }
            .post-info {
                text-align: left;
                font-size: 0.75em;
                margin-top: 5px;
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



<?php foreach ($postsByCategory as $categoryName => $posts): ?>
    <div class="category">
        <h2><?= esc($categoryName) ?></h2>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><a href="/posts/<?= esc($post['id']) ?>"><?= esc($post['title']) ?></a></h3>
                    <div class="post-info">
                        <p>작성자: <?= esc($post['nickname']) ?></p>
                        <p>조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>게시글이 없습니다.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<script>
    // 메뉴 토글 함수
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }
</script>
</body>
</html>
