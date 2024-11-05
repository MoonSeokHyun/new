<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>퐁코 - 게시글 목록</title>
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
        }
        .post {
            margin: 8px 0;
            padding: 8px;
            border-bottom: 1px solid #ccc;
            font-size: 14px; /* 게시글 폰트 크기 조정 */
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h3 {
            margin-bottom: 5px;
            font-size: 16px; /* 제목 크기 조정 */
        }
        .post p {
            color: #666;
            margin: 5px 0;
            font-size: 12px; /* 기타 정보 폰트 크기 조정 */
        }

        /* 모바일 친화적 스타일 */
        @media (max-width: 768px) {
            #hd_section {
                flex-direction: column;
                align-items: flex-start;
            }
            #hd_section a {
                margin: 5px 0;
            }
            .category {
                padding: 10px;
            }
            .post {
                padding: 6px;
                font-size: 12px; /* 작은 화면에서 폰트 크기 조정 */
            }
            .post h3 {
                font-size: 14px; /* 제목 크기 조정 */
            }
            h1 {
                font-size: 20px; /* 제목 크기 조정 */
            }
        }
    </style>
</head>
<body>

<div id="hd_section">
    <a class="fl" href="//pongpongkorea.com/">퐁코</a>
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
                    <a href="/posts?category=7">퐁코 베스트</a>
                    <a href="/bob">Best Of Best</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">전체 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=1">퐁코 토론</a>
                    <a href="/posts?category=2">퐁코 이슈</a>
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

<!-- 각 카테고리별 게시글 출력 -->
<?php foreach ($postsByCategory as $categoryName => $posts): ?>
    <div class="category">
        <h2><?= esc($categoryName) ?></h2>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><a href="/posts/<?= esc($post['id']) ?>"><?= esc($post['title']) ?></a></h3>
                    <p>작성자: <?= esc($post['nickname']) ?></p>
                    <p>조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>게시글이 없습니다.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>
