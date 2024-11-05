<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?= esc($categoryName) ?> 게시글 목록</title>
</head>
<body>
    <h1><?= esc($categoryName) ?> 게시글 목록</h1>

    <!-- 새 글 작성 버튼, 현재 카테고리를 URL에 포함하여 글 작성 페이지로 이동 -->
    <a href="/posts/create?category=<?= esc($category) ?>">새 글 작성</a>

    <!-- 게시글 목록 -->
    <ul>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <li>
                    <a href="/posts/<?= $post['id'] ?>"><?= esc($post['title']) ?></a>
                    <span>조회수: <?= $post['view_count'] ?></span>
                    <span>추천: <?= $post['likes'] ?></span>
                    <span>비추천: <?= $post['dislikes'] ?></span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>게시글이 없습니다.</li>
        <?php endif; ?>
    </ul>
</body>
</html>
