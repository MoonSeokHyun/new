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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
    crossorigin="anonymous"></script>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    width: 100%;
    font-family: '돋움', Arial, sans-serif;
    background-color: #1e1e1e;
    color: #ddd;
    line-height: 1.6;
}

/* PC 화면에서만 최대 너비 적용 */
@media (min-width: 768px) {
    body {
        max-width: 1350px;
        margin: 0 auto;
    }
}

/* 본문 스타일 */
.post-container {
    background-color: #2c2c2c;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    margin-left: auto;
    margin-right: auto;
}

.content {
    text-align: center;
    margin: 0 auto;
    max-width: 700px;
}

.post-header {
    margin-top: 10px;
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
    padding: 0 15px 10px 15px;
    border-bottom: 1px solid #444;
}

.content img {
    display: block;
    margin: 2px auto;
    max-width: 100%;
    width: 100%;
    height: auto;
    border-radius: 5px;
    object-fit: cover;
}


.form-section {
    padding: 10px;
    margin: 15px;
    background-color: #2a2a2a;
    border-radius: 5px;
}

.form-section h2 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #00d8ff;
}

.form-section input[type="text"],
.form-section textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 8px;
    border: 1px solid #555;
    border-radius: 3px;
    background-color: #444;
    color: #ddd;
    font-size: 0.9em;
}

.form-section button {
    width: 100%;
    padding: 8px;
    background-color: #00d8ff;
    border: none;
    border-radius: 3px;
    font-weight: bold;
    cursor: pointer;
}

.form-section button:hover {
    background-color: #00b0d4;
}

/* 댓글 목록 스타일 */
.comment-section {
    padding: 10px;
    margin: 15px;
}

.comment-section h2 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #00b0d4;
}

.comment {
    background-color: #333;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
}

.comment strong {
    color: #00d8ff;
    display: block;
    margin-bottom: 5px;
    font-size: 0.9em;
}

.comment p {
    font-size: 0.9em;
    color: #ddd;
    margin-top: 5px;
}

.reply {
    margin-left: 15px;
    padding-left: 10px;
    border-left: 2px solid #00d8ff;
    background-color: #2a2a2a;
    margin-top: 10px;
}

.reply-btn {
    color: #00b0d4;
    font-size: 0.8em;
    cursor: pointer;
    display: inline-block;
    margin-top: 5px;
}

.reply-btn:hover {
    color: #00d8ff;
}

.reply-form {
    display: none;
    margin-top: 10px;
}

.reply-form input[type="text"],
.reply-form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 8px;
    border: 1px solid #555;
    border-radius: 3px;
    background-color: #444;
    color: #ddd;
    font-size: 0.9em;
}

.reply-form button {
    width: 100%;
    padding: 8px;
    background-color: #00d8ff;
    border: none;
    border-radius: 3px;
    font-weight: bold;
    cursor: pointer;
}

.reply-form button:hover {
    background-color: #00b0d4;
}

/* 모바일 스타일 */
@media (max-width: 768px) {
    .form-section,
    .comment-section {
        margin: 10px;
        padding: 10px;
    }
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

/* 네비게이션 버튼 스타일 */
.post-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    font-size: 0.9em;
    gap: 10px;
}

.post-navigation a {
    color: #00d8ff;
    text-decoration: none;
    padding: 8px 12px;
    background-color: #333;
    border-radius: 5px;
    border: 1px solid #444;
    max-width: 45%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
    transition: background-color 0.3s ease;
}

.post-navigation a:hover {
    background-color: #444;
    color: #00e0ff;
    border-color: #00e0ff;
}


/* 모바일 스타일 */
@media (max-width: 768px) {
    .post-meta {
        flex-direction: column;
        text-align: center;
    }

    .content {
        width: 100%;
        padding: 0 10px;
    }

    .content img {
        max-width: 100%;
        height: auto;
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

/* 헤더 스타일 */
#hd_section {
    background-color: #333;
    padding: 3px 3px;
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

.interactions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 20px 0;
}

.interactions a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 15px;
    color: #00d8ff;
    background-color: #2c2c2c;
    border: 1px solid #444;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1em;
    transition: all 0.3s ease;
}

.interactions a i {
    margin-right: 5px;
}

.interactions a:hover {
    background-color: #444;
    color: #00e0ff;
    border-color: #00e0ff;
}

.interactions a:active {
    transform: scale(0.95);
}

#like-btn {
    color: #00d8ff;
}

#dislike-btn {
    color: #ff5c5c;
}

.ad-iframe {
    width: 100%;
    max-width: 680px;
    height: auto;
    border: none;
    margin: 0 auto;
    display: block;
}

@media (min-width: 768px) {
    .ad-iframe {
        height: 140px;
    }
}

@media (max-width: 767px) {
    .ad-iframe {
        height: 100px; /* Reduced height for mobile */
    }
}
    </style>
</head>
<body>
<div id="hd_section">
    <a href="/">퐁퐁코리아 도태남 집합소</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/">메인</a></li>
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

<div class="post-container">
    <div class="post-header"><?= esc($post['title']) ?></div>
    <div class="post-meta">
        <p>작성자: <?= esc($post['nickname']) ?> | 조회수: <?= $post['view_count'] ?></p>
    </div>
    <div class="content"><?= $post['content'] ?></div>
</div>

    <iframe src="https://ads-partners.coupang.com/widgets.html?id=819616&template=carousel&trackingCode=AF8077807&subId=&width=100&height=1000&tsource="
            class="ad-iframe"
            frameborder="0"
            scrolling="no"
            referrerpolicy="unsafe-url"></iframe>

<!--추천 반대 -->
<div class="interactions">
    <a href="javascript:void(0);" onclick="handleLike(<?= $post['id'] ?>)" id="like-btn">
        <i class="fas fa-thumbs-up"></i> 추천: <span id="like-count"><?= $post['likes'] ?></span>
    </a>
    <a href="javascript:void(0);" onclick="handleDislike(<?= $post['id'] ?>)" id="dislike-btn">
        <i class="fas fa-thumbs-down"></i> 비추천: <span id="dislike-count"><?= $post['dislikes'] ?></span>
    </a>
</div>

<!-- 이전/다음 글 네비게이션 -->
<div class="post-navigation">
    <?php if ($previousPost): ?>
        <a href="/posts/<?= $previousPost['id'] ?>">&laquo; 이전 글: <?= esc($previousPost['title']) ?></a>
    <?php endif; ?>
    <?php if ($nextPost): ?>
        <a href="/posts/<?= $nextPost['id'] ?>">다음 글: <?= esc($nextPost['title']) ?> &raquo;</a>
    <?php endif; ?>
</div>


<div class="form-section">
    <h2>댓글 작성</h2>
    <form action="/posts/<?= $post['id'] ?>/reply" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <label>닉네임:</label>
        <input type="text" name="nickname" id="nickname" required>
        <label>댓글 내용:</label>
        <textarea name="content" required></textarea>
        <button type="submit">댓글 작성</button>
    </form>
</div>

<script>
    // 페이지 로드 시 닉네임 필드에 '퐁퐁이'와 1~999 사이의 랜덤 숫자 설정
    document.addEventListener("DOMContentLoaded", function() {
        const randomNumber = Math.floor(Math.random() * 999) + 1; // 1부터 999 사이의 숫자 생성
        const nicknameField = document.getElementById("nickname");
        nicknameField.value = `퐁퐁이${randomNumber}`;
    });
</script>


<div class="comment-section">
    <h2>댓글 목록</h2>
    <?php
    function displayReplies($replies, $parentId = null) {
        foreach ($replies as $reply) {
            if ($reply['parent_id'] == $parentId) {
                ?>
                <div class="comment <?= $reply['parent_id'] ? 'reply' : '' ?>" id="comment-<?= $reply['id'] ?>">
                    <strong><?= esc($reply['nickname']) ?></strong>
                    <p><?= esc($reply['content']) ?></p>

                    <?php if (!$reply['parent_id']): ?>
                        <span class="reply-btn" onclick="toggleReplyForm(<?= $reply['id'] ?>)">답글</span>
                    <?php endif; ?>

                    <div id="reply-form-<?= $reply['id'] ?>" class="reply-form">
                        <form action="/posts/<?= $reply['post_id'] ?>/reply" method="post">
                            <input type="hidden" name="post_id" value="<?= $reply['post_id'] ?>">
                            <input type="hidden" name="parent_id" value="<?= $reply['id'] ?>">
                            <label>닉네임:</label>
                            <input type="text" name="nickname" required>
                            <label>댓글 내용:</label>
                            <textarea name="content" required></textarea>
                            <button type="submit">답글 작성</button>
                        </form>
                    </div>

                    <?php displayReplies($replies, $reply['id']); ?>
                </div>
                <?php
            }
        }
    }

    displayReplies($replies);
    ?>
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
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "8bcce9183d61c0";
if(window.wcs) {
wcs_do();
}
</script>
</body>
<script>
let hasLiked = false;
let hasDisliked = false;

function handleLike(postId) {
    if (hasLiked) {
        alert('이미 추천하셨습니다.');
        return;
    }
    if (hasDisliked) {
        alert('이미 비추천을 하셨습니다. 비추천을 취소하고 다시 시도해 주세요.');
        return;
    }

    fetch(`/posts/${postId}/ajaxLike`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hasLiked = true;
            document.getElementById('like-count').innerText = data.likes;
            alert('추천하셨습니다.');
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function handleDislike(postId) {
    if (hasDisliked) {
        alert('이미 비추천하셨습니다.');
        return;
    }
    if (hasLiked) {
        alert('이미 추천을 하셨습니다. 추천을 취소하고 다시 시도해 주세요.');
        return;
    }

    fetch(`/posts/${postId}/ajaxDislike`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hasDisliked = true;
            document.getElementById('dislike-count').innerText = data.dislikes;
            alert('비추천하셨습니다.');
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>
</html>
