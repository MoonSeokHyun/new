<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 상세</title>
    <style>
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
        }
    </style>
</head>
<body>
    <h1><?= esc($post['title']) ?></h1>
    <p>작성자: <?= esc($post['nickname']) ?></p>
    <p>카테고리: <?= esc($post['category']) ?></p>

    <!-- content 필드의 HTML 태그를 그대로 출력 -->
    <div>
        <?= $post['content'] ?> <!-- esc() 함수가 없어야 함 -->
    </div>

    <p>조회수: <?= $post['view_count'] ?></p>
    <p>추천: <?= $post['likes'] ?> <a href="/posts/<?= $post['id'] ?>/like">추천하기</a></p>
    <p>비추천: <?= $post['dislikes'] ?> <a href="/posts/<?= $post['id'] ?>/dislike">비추천하기</a></p>

    <!-- 수정 및 삭제 버튼 -->
    <button onclick="openModal('delete')">삭제</button>

    <!-- 모달 창 -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <h3>비밀번호 입력</h3>
            <input type="password" id="modalPassword" placeholder="비밀번호를 입력하세요" required>
            <button onclick="submitForm()">확인</button>
            <button onclick="closeModal()">취소</button>
        </div>
    </div>

    <!-- 폼 및 스크립트 -->
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
            if (actionType === 'edit') {
                document.getElementById("editForm").submit();
            } else if (actionType === 'delete') {
                document.getElementById("deletePassword").value = password;
                document.getElementById("deleteForm").submit();
            }
            closeModal();
        }
    </script>
</body>
</html>
