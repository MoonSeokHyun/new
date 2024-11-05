<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 수정</title>
</head>
<body>
    <h1>게시글 수정</h1>
    <form action="/posts/<?= $post['id'] ?>" method="post" enctype="multipart/form-data">
        <label>제목:</label>
        <input type="text" name="title" value="<?= esc($post['title']) ?>" required><br>

        <label>닉네임:</label>
        <input type="text" name="nickname" value="<?= esc($post['nickname']) ?>" required><br>

        <label>내용:</label>
        <textarea name="content" required><?= esc($post['content']) ?></textarea><br>

        <label>카테고리:</label>
        <input type="text" name="category" value="<?= esc($post['category']) ?>"><br>

        <label>이미지:</label><br>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php if (!empty($post["image$i"])): ?>
                <p>현재 이미지 <?= $i ?>: <img src="<?= esc($post["image$i"]) ?>" alt="이미지 <?= $i ?>" style="max-width:100px;"></p>
            <?php endif; ?>
            <input type="file" name="image<?= $i ?>"><br>
        <?php endfor; ?>

        <label>비밀번호:</label>
        <input type="password" name="password" required><br>

        <button type="submit">수정 완료</button>
    </form>
</body>
</html>
