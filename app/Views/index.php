<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="32ICtfA9W_GY36z5sfWlyLwYFrrcbK8qUDEbAFCDQMU" />
    <meta name="naver-site-verification" content="3364bf3d26f95db9c37f59a7acb7f4523cc8c823" />

    <title>풍코 - 남녀차별, 퐁퐁남 토론 커뮤니티</title>
    
    <!-- SEO 메타태그 -->
    <meta name="description" content="풍코 커뮤니티 - 퐁퐁남, 남녀차별, 최신 이슈와 토론을 위한 플랫폼. 다양한 게시판에서 이슈와 유머를 함께 나눠보세요.">
    <meta name="keywords" content="퐁퐁남, 남녀차별, 토론, 커뮤니티, 풍코, 유머, 이슈">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="풍코 - 남녀차별과 퐁퐁남 이슈 커뮤니티">
    <meta property="og:description" content="풍코 커뮤니티에서 퐁퐁남, 남녀차별 등 다양한 이슈를 자유롭게 토론하세요.">
    <meta property="og:image" content="https://pongpongkorea.com/path/to/thumbnail.jpg">
    <meta property="og:url" content="https://pongpongkorea.com">
    <meta property="og:type" content="website">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="풍코 - 남녀차별과 퐁퐁남 이슈 커뮤니티">
    <meta name="twitter:description" content="풍코 커뮤니티에서 남녀차별, 퐁퐁남 등 사회적 이슈와 유머를 함께 즐겨보세요.">
    <meta name="twitter:image" content="https://pongpongkorea.com/path/to/thumbnail.jpg">
    
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
          /* a 태그 기본 스타일 제거 */
    a {
        text-decoration: none;
        color: inherit;
    }

    /* 카테고리 링크 스타일 */
    .category-link {
        color: #00d8ff; /* 카테고리 링크 색상 */
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .category-link:hover {
        color: #00b0d4;
    }

    /* 게시글 링크 스타일 */
    .post-link {
        color: #ddd; /* 게시글 제목 링크 색상 */
        font-size: 1em;
        font-weight: normal;
        transition: color 0.3s ease;
    }

    .post-link:hover {
        color: #00d8ff;
    }

    /* 제목과 정보 배치 스타일 */
    .category h2, .post h3 {
        margin-bottom: 8px;
    }

    .post-info {
        color: #aaa;
        font-size: 0.85em;
    }
    </style>
</head>
<body>

<div id="hd_section">
    <a href="/">풍코</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/">메인</a></li>
            <li class="has-sub">
                <a href="/posts?category=99">공지사항</a> <!-- 공지사항 카테고리 링크 -->
            </li>
            <li class="has-sub">
                <a href="/posts?category=9">베스트 게시판</a> <!-- 베스트 카테고리 링크 -->
            </li>
            <li class="has-sub">
                <a href="#">전체 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=1">퐁코 토론</a> <!-- 퐁코 토론 카테고리 링크 -->
                    <a href="/posts?category=8">퐁코 이슈</a> <!-- 퐁코 이슈 카테고리 링크 -->
                    <a href="/posts?category=4">자유 게시판</a> <!-- 자유 게시판 카테고리 링크 -->
                    <a href="/posts?category=7">유머 게시판</a> <!-- 유머 게시판 카테고리 링크 -->
                </div>
            </li>
        </ul>
    </div>
</div>

<?php foreach ($postsByCategory as $categoryName => $posts): ?>
    <div class="category">
        <h2><a href="/posts?category=<?= urlencode($categoryName) ?>" class="category-link"><?= esc($categoryName) ?></a></h2>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><a href="/posts/<?= esc($post['id']) ?>" class="post-link"><?= esc($post['title']) ?></a></h3>
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
