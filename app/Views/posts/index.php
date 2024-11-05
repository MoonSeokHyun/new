<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 목록</title>
</head>
<body>
    <h1>게시글 목록</h1>

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
                    <?= esc($post['title']) ?> (작성자: <?= esc($post['nickname']) ?>)
                </a>
                <p>조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
