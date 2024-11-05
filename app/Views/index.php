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
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        /* 네비게이션 바 스타일 */
        #hd_section {
            background-color: #4CAF50;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        #hd_section a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
        #hd_section a:hover {
            background-color: #388E3C;
            border-radius: 5px;
        }

        /* 모바일 메뉴 버튼 스타일 */
        .menu-toggle {
            display: none;
            background-color: transparent;
            border: none;
            font-size: 24px;
            color: white;
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
            background-color: #388E3C;
            border-radius: 5px;
            padding: 10px 0;
            min-width: 150px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .hd_dd_menu .has-sub:hover .dd_toggle {
            display: block;
        }
        .hd_dd_menu .has-sub .dd_toggle a {
            color: white;
            display: block;
            padding: 8px 20px;
            text-decoration: none;
        }
        .hd_dd_menu .has-sub .dd_toggle a:hover {
            background-color: #2E7D32;
        }

        /* 모바일 충적 스타일 */
        @media (max-width: 768px) {
            #hd_section {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                width: 100%;
            }
            .menu-toggle {
                display: block;
            }
            .hd_dd_menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #4CAF50;
                padding: 10px 0;
                margin-top: 10px;
                border-radius: 5px;
            }
            .hd_dd_menu.active {
                display: flex;
            }
            #hd_section a {
                order: -1;
                margin: 0;
            }
        }

        /* 게시글 목록 스타일 */
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .category {
            margin-top: 20px;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }
        .post {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 8px 0;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            font-size: 14px;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h3 {
            margin-bottom: 5px;
            font-size: 16px;
            flex: 1;
        }
        .post-info {
            text-align: right;
            color: #666;
            font-size: 12px;
            min-width: 120px;
        }
        .post-info p {
            margin: 5px 0;
        }

        /* 작은 화면에서 더 나은 UI/UX 제공 */
        @media (max-width: 480px) {
            .category {
                width: 100%;
                padding: 10px;
            }
            .category h2 {
                font-size: 18px;
            }
            .post {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
            }
            .post h3 {
                font-size: 14px;
            }
            .post-info {
                text-align: left;
                font-size: 12px;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>

<div id="hd_section">
    <a class="fl" href="//pongpongkorea.com/">풍코</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/main">메인</a></li>
            <li class="has-sub">
                <a href="#">공지사항</a>
                <div class="dd_toggle">
                    <a href="/posts?category=99">공지사항</a>
                    <a href="/proposal">신고 건의</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">베스트 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=7">풍코 베스트</a>
                    <a href="/bob">Best Of Best</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">전체 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=1">풍코 토론</a>
                    <a href="/posts?category=2">풍코 이슈</a>
                    <a href="/posts?category=3">탈코리아 게시판</a>
                    <a href="/posts?category=4">자유 게시판</a>
                    <a href="/posts?category=5">유머 게시판</a>
                    <a href="/posts?category=6">죽창 게시판</a>
                </div>
            </li>
            <li class="has-sub"><a href="https://pongpongkorea.com/rd">랜덤 글</a></li>
        </ul>
    </div>
</div>

<!-- 게시글 목록 출력 -->
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
    // 메뉴 토그램 함수
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }
</script>
</body>
</html>
