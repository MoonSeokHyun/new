<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 상세</title>
    <style>
        /* 전체적인 스타일 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        h2 {
            color: #555;
            margin-top: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        /* 모달 스타일 */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }

        .modal-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        .modal-content button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        /* 댓글 및 대댓글 스타일 */
        .comment {
            margin: 10px 0;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .reply {
            margin-left: 20px;
            border-left: 2px solid #007BFF;
            padding-left: 10px;
        }

        /* 입력 폼 스타일 */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* 댓글 작성 버튼 */
        .reply-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1><?= esc($post['title']) ?></h1>
    <p>작성자: <?= esc($post['nickname']) ?></p>
    <p>카테고리: <?= esc($post['category']) ?></p>

    <div>
        <?= $post['content'] ?> <!-- content 필드의 HTML 태그를 그대로 출력 -->
    </div>

    <p>조회수: <?= $post['view_count'] ?></p>
    <p>추천: <?= $post['likes'] ?> <a href="/posts/<?= $post['id'] ?>/like">추천하기</a></p>
    <p>비추천: <?= $post['dislikes'] ?> <a href="/posts/<?= $post['id'] ?>/dislike">비추천하기</a></p>

    <!-- 삭제 모달 -->
    <button onclick="openModal('delete')">삭제</button>
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <h3>비밀번호 입력</h3>
            <input type="password" id="modalPassword" placeholder="비밀번호를 입력하세요" required>
            <button onclick="submitForm()">확인</button>
            <button onclick="closeModal()">취소</button>
        </div>
    </div>

    <form id="deleteForm" action="/posts/<?= $post['id'] ?>/delete" method="post" style="display: none;">
        <input type="hidden" name="password" id="deletePassword">
    </form>

    <script>
        let actionType = ''; // 수정 또는 삭제 구분을 위한 변수

        // 모달 열기
        function openModal(action) {
            actionType = action;
            document.getElementById("passwordModal").style.display = "flex";
        }

        // 모달 닫기
        function closeModal() {
            document.getElementById("passwordModal").style.display = "none";
            document.getElementById("modalPassword").value = ""; // 비밀번호 입력 필드 초기화
        }

        // 폼 제출
        function submitForm() {
            const password = document.getElementById("modalPassword").value;
            if (actionType === 'delete') {
                document.getElementById("deletePassword").value = password;
                document.getElementById("deleteForm").submit();
            }
            closeModal();
        }
    </script>

    <!-- 댓글 입력 폼 -->
    <h2>댓글 작성</h2>
    <form action="/posts/<?= $post['id'] ?>/reply" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <label>닉네임:</label>
        <input type="text" name="nickname" required>
        <label>댓글 내용:</label>
        <textarea name="content" required></textarea>
        <button type="submit">댓글 작성</button>
    </form>

    <!-- 댓글 목록 -->
    <h2>댓글 목록</h2>
    <div>
        <?php foreach ($replies as $reply): ?>
            <?php if ($reply['parent_id'] === null): // 부모 댓글만 표시 ?>
                <div class="comment">
                    <strong><?= esc($reply['nickname']) ?></strong>
                    <p><?= esc($reply['content']) ?></p>
                    <button class="reply-button" onclick="openReplyForm(<?= $reply['id'] ?>)">답글</button>

                    <!-- 대댓글 입력 폼 -->
                    <div class="reply-form" id="replyForm-<?= $reply['id'] ?>" style="display:none;">
                        <form action="/posts/<?= $post['id'] ?>/reply" method="post">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="parent_id" value="<?= $reply['id'] ?>">
                            <label>닉네임:</label>
                            <input type="text" name="nickname" required>
                            <label>대댓글 내용:</label>
                            <textarea name="content" required></textarea>
                            <button type="submit">대댓글 작성</button>
                        </form>
                    </div>

                    <!-- 대댓글 표시 -->
                    <?php 
                    // 부모 댓글 ID가 같은 대댓글을 출력합니다.
                    $subReplies = array_filter($replies, function($r) use ($reply) {
                        return $r['parent_id'] === $reply['id'];
                    });
                    ?>
                    <div class="reply">
                        <?php foreach ($subReplies as $subReply): ?>
                            <div class="comment reply">
                                <strong><?= esc($subReply['nickname']) ?></strong>
                                <p><?= esc($subReply['content']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script>
    function openReplyForm(replyId) {
        var replyForm = document.getElementById('replyForm-' + replyId);
        replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none'; // 폼 보이기/숨기기
    }
    </script>

</body>
</html>
