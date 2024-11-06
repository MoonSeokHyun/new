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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: '돋움', Arial, sans-serif;
            background-color: #1e1e1e;
            color: #ddd;
            padding: 20px;
            line-height: 1.6;
        }

        /* 헤더 스타일 */
        #hd_section {
            background-color: #333;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        #hd_section a {
            color: #00d8ff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            margin-right: 15px;
        }
        #hd_section a:hover {
            background-color: #444;
            padding: 6px 8px;
            border-radius: 3px;
        }

        .menu-toggle {
            display: none;
            background-color: transparent;
            border: none;
            font-size: 20px;
            color: #00d8ff;
            cursor: pointer;
        }

        /* 드롭다운 메뉴 */
        .hd_dd_menu {
            display: flex;
            flex-wrap: wrap;
        }
        .hd_dd_menu ul {
            display: flex;
            list-style: none;
            gap: 10px;
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
            border-radius: 5px;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .hd_dd_menu .has-sub:hover .dd_toggle {
            display: block;
        }
        .hd_dd_menu .dd_toggle a {
            color: #ddd;
            display: block;
            padding: 8px 12px;
            text-decoration: none;
        }
        .hd_dd_menu .dd_toggle a:hover {
            background-color: #333;
        }

        /* 본문 스타일 */
        .post-container {
            background-color: #2c2c2c;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }
        .post-header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 1.8em;
            color: #00d8ff;
        }
        .post-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
            color: #aaa;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #444;
        }
        .content {
            font-size: 1em;
            color: #eee;
            padding: 15px;
            line-height: 1.8;
            text-align: left;
        }
        .interactions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }
        .interactions a {
            color: #00d8ff;
            text-decoration: none;
            font-weight: bold;
        }

        /* 댓글 스타일 */
        h2 {
            font-size: 1.4em;
            margin-top: 30px;
            color: #00b0d4;
        }
        .comment-section {
            margin-top: 20px;
        }
        .comment {
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .comment strong {
            color: #00d8ff;
        }
        .reply {
            margin-left: 30px;
            border-left: 2px solid #00d8ff;
            padding-left: 10px;
            background-color: #2a2a2a;
            border-radius: 5px;
        }
        .reply-btn {
            color: #00b0d4;
            font-size: 0.9em;
            cursor: pointer;
            margin-top: 5px;
        }
        .reply-btn:hover {
            color: #00d8ff;
        }
        .reply-form {
            display: none;
            margin-top: 10px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #ddd;
        }
        button {
            display: block;
            width: 100%;
            max-width: 200px;
            padding: 10px;
            background-color: #00d8ff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px auto;
            cursor: pointer;
        }
        button:hover {
            background-color: #00b0d4;
        }

        /* 반응형 스타일 */
        @media (max-width: 768px) {
            .post-meta {
                flex-direction: column;
                text-align: center;
            }
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
    </style>
</head>
<body>

<!-- Header Section -->
<div id="hd_section">
    <a href="/">풍코</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="#">공지사항</a>
                <div class="dd_toggle">
                    <a href="/posts?category=99">공지사항</a>
                </div>
            </li>
            <li class="has-sub"><a href="#">베스트 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=9">풍코 베스트</a>
                </div>
            </li>
            <li class="has-sub"><a href="#">전체 게시판</a>
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

<!-- Post Container -->
<div class="post-container">
    <div class="post-header"><?= esc($post['title']) ?></div>
    <div class="post-meta">
        <p>작성자: <?= esc($post['nickname']) ?></p>
        <p>조회수: <?= $post['view_count'] ?></p>
    </div>
    <div class="content"><?= $post['content'] ?></div>
</div>

<!-- Like and Dislike -->
<div class="interactions">
    <a href="/posts/<?= $post['id'] ?>/like">
        <i class="fas fa-thumbs-up"></i> 추천: <?= $post['likes'] ?>
    </a>
    <a href="/posts/<?= $post['id'] ?>/dislike">
        <i class="fas fa-thumbs-down"></i> 비추천: <?= $post['dislikes'] ?>
    </a>
</div>

<!-- Comment Form -->
<div class="form-section">
    <h2>댓글 작성</h2>
    <form action="/posts/<?= $post['id'] ?>/reply" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <label>닉네임:</label>
        <input type="text" name="nickname" required>
        <label>댓글 내용:</label>
        <textarea name="content" required></textarea>
        <button type="submit">댓글 작성</button>
    </form>
</div>

<!-- Comments List -->
<div class="comment-section">
    <h2>댓글 목록</h2>
    <?php foreach ($replies as $reply): ?>
        <div class="comment <?= $reply['parent_id'] ? 'reply' : '' ?>" id="comment-<?= $reply['id'] ?>">
            <strong><?= esc($reply['nickname']) ?></strong>
            <p><?= esc($reply['content']) ?></p>

            <!-- 답글 버튼 및 폼 -->
            <?php if (!$reply['parent_id']): ?>
                <span class="reply-btn" onclick="toggleReplyForm(<?= $reply['id'] ?>)">답글</span>
            <?php endif; ?>

            <!-- 대댓글 입력 폼 -->
            <div id="reply-form-<?= $reply['id'] ?>" class="reply-form">
                <form action="/posts/<?= $post['id'] ?>/reply" method="post">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <input type="hidden" name="parent_id" value="<?= $reply['id'] ?>">
                    <label>닉네임:</label>
                    <input type="text" name="nickname" required>
                    <label>댓글 내용:</label>
                    <textarea name="content" required></textarea>
                    <button type="submit">답글 작성</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }

    function toggleReplyForm(replyId) {
        const replyForm = document.getElementById(`reply-form-${replyId}`);
        replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
    }
</script>

</body>
</html>
