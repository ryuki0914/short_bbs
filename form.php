<?php
session_start();

if(isset($_SESSION['username'])){
    $name = $_SESSION['username'];
}else{
    $name = '';
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一言掲示板 - 投稿</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #charCount {
            font-size: 0.9em;
            color: #555;
        }
        #errorMessage {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>💬 一言掲示板</h1>
    <form id="postForm" action="post.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <?php
        if(!empty($name)){
            echo '<p>ようこそ、', htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ,'さん</p>';
            echo '<p>名前：<input type="text" name="name" value="', htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ,'" readonly></p>';
        }else{
            echo '<p>名前：<input type="text" name="name" value="名無し" readonly></p>';
        }
        ?>
        
        <p>コメント：<br>
        <textarea id="comment" name="comment" rows="4" cols="40" maxlength="200" required></textarea></p>
        <div id="charCount">255文字まで入力可能です</div>
        <p id="errorMessage"></p>
        <p><button id="submitBtn" type="submit" disabled>投稿する</button></p>
    </form>
    <p><a href="view.php">▶ 投稿一覧を見る</a></p>
    <?php
    if(isset($_SESSION['username'])){
        echo '<a href="./logout.php">ログアウト</a>';
    }else{
        echo '<p><a href="./login.php">ログイン</a></p>';
    }
    ?>

    <div class="header">
        <?= !empty($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : "" ?>
    </div>

    <script>
        const comment = document.getElementById('comment');
        const submitBtn = document.getElementById('submitBtn');
        const charCount = document.getElementById('charCount');
        const errorMessage = document.getElementById('errorMessage');
        const maxLen = 255;

        comment.addEventListener('input', () => {
            const length = comment.value.trim().length;

            charCount.textContent = `${maxLen - length}文字まで入力可能です`;

            if (length > 0 && length <= maxLen) {
                submitBtn.disabled = false;
                errorMessage.textContent = '';
            } else {
                submitBtn.disabled = true;
                if (length > maxLen) {
                    errorMessage.textContent = 'コメントは255文字以内で入力してください。';
                } else {
                    errorMessage.textContent = '';
                }
            }
        });

        document.getElementById('postForm').addEventListener('submit', (e) => {
            if (!confirm('投稿してもよろしいですか？')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
