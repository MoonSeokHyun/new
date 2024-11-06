<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($post['title']) ?> - 풍코 게시글</title>
    <meta name="description" content="풍코 - <?= esc($post['category']) ?> 게시글 상세 페이지입니다.">
    <meta name="keywords" content="풍코, 게시글, <?= esc($post['category']) ?>, 커뮤니티">
    <meta property="og:title" content="<?= esc($post['title']) ?> - 풍코 게시글">
    <meta property="og:description" content="풍코 - <?= esc($post['category']) ?> 게시글 상세 페이지입니다.">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://pongpongkorea.com/posts/<?= $post['id'] ?>">
    <meta property="og:image" content="https://pongpongkorea.com/path/to/thumbnail.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* 기본 스타일 */
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
            line-height: 1.6; /* 줄 간격 추가 */
        }

        /* 네비게이션 바 스타일 */
        #hd_section {
            background-color: #333;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px; /* 하단 여백 추가 */
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

        h1 {
            color: #00d8ff;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px; /* 하단 여백 추가 */
            font-size: 1.8em;
        }

        h2 {
            color: #00b0d4;
            margin-top: 20px;
            font-size: 1.2em;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
            margin-top: 30px; /* 상단 여백 추가 */
        }

        /* 본문 스타일 */
        .content {
            background-color: #333;
            padding: 20px; /* 내부 여백 증가 */
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* 이미지 스타일 */
        .content img {
            max-width: 100%; /* 이미지가 부모 요소의 100% 너비를 넘지 않도록 설정 */
            height: auto; /* 비율을 유지하도록 설정 */
            border-radius: 5px; /* 이미지 모서리 둥글게 */
            margin-bottom: 10px; /* 이미지 하단 여백 추가 */
        }

        /* 댓글 및 대댓글 스타일 */
        .comment {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background-color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px; /* 하단 여백 추가 */
        }

        .reply {
            margin-left: 20px;
            border-left: 2px solid #00d8ff;
            padding-left: 10px;
            margin-top: 5px;
        }

        /* 입력 폼 스타일 */
        input[type="text"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #444;
            border: 1px solid #555;
            border-radius: 5px;
            color: #ddd;
            font-size: 0.9em;
        }

        button {
            background-color: #00d8ff;
            color: #222;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9em;
            width: 100%;
            max-width: 200px;
            margin: 10px auto;
            display: block;
        }

        button:hover {
            background-color: #00b0d4;
        }

        /* 네비게이션 버튼 스타일 */
        .post-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .post-navigation a {
            color: #00d8ff;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #333;
            border-radius: 3px;
            border: 1px solid #444;
        }

        .post-navigation a:hover {
            background-color: #444;
        }

        /* 모바일 친화적 레이아웃 */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.5em;
            }
            h2 {
                font-size: 1.1em;
            }
            .post-navigation a {
                padding: 6px 8px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>

<!-- 네비게이션 헤더 -->
<div id="hd_section">
    <a href="//pongpongkorea.com/">풍코</a>
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

<h1><?= esc($post['title']) ?></h1>
<p>작성자: <?= esc($post['nickname']) ?></p>

<div class="content">
    <?= $post['content'] ?>
</div>

<p>조회수: <?= $post['view_count'] ?></p>
<p>
    추천: <?= $post['likes'] ?> 
    <a href="/posts/<?= $post['id'] ?>/like">
        <i class="fas fa-thumbs-up" aria-hidden="true"></i>
    </a>
</p>
<p>
    비추천: <?= $post['dislikes'] ?> 
    <a href="/posts/<?= $post['id'] ?>/dislike">
        <i class="fas fa-thumbs-down" aria-hidden="true"></i>
    </a>
</p>

<div class="post-navigation">
    <?php if ($previousPost): ?>
        <a href="/posts/<?= $previousPost['id'] ?>">&laquo; 이전 글: <?= esc($previousPost['title']) ?></a>
    <?php endif; ?>
    <?php if ($nextPost): ?>
        <a href="/posts/<?= $nextPost['id'] ?>">다음 글: <?= esc($nextPost['title']) ?> &raquo;</a>
    <?php endif; ?>
</div>

<h2>댓글 작성</h2>
<form action="/posts/<?= $post['id'] ?>/reply" method="post">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <label>닉네임:</label>
    <input type="text" name="nickname" required>
    <label>댓글 내용:</label>
    <textarea name="content" required></textarea>
    <button type="submit">댓글 작성</button>
</form>

<h2>댓글 목록</h2>
<div>
    <?php foreach ($replies as $reply): ?>
        <div class="comment">
            <strong><?= esc($reply['nickname']) ?></strong>
            <p><?= esc($reply['content']) ?></p>
            <button onclick="openReplyForm(<?= $reply['id'] ?>)">답글</button>
            <!-- 대댓글 입력 폼과 목록은 동일하게 유지 -->
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }
</script>

</body>
</html>
