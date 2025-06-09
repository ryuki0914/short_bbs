<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>ログイン</h1>
    <form id="loginForm" action="check.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <p>ユーザー名：<input type="text" id="username" name="username"></p>
        <p>パスワード：<input type="password" id="password" name="password"></p>
        <p class="error" id="errorMessage"></p>
        <p><button type="submit">ログイン</button></p>
    </form>

    <a href="signup.php">新規登録</a>　　
    <a href="form.php">投稿画面</a>

    <script>
        const form = document.getElementById('loginForm');
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const errorMessage = document.getElementById('errorMessage');
        const togglePw = document.getElementById('togglePw');

        // 入力チェック
        form.addEventListener('submit', function(e) {
            errorMessage.textContent = '';

            if (username.value.trim() === '' || password.value.trim() === '') {
                e.preventDefault();
                errorMessage.textContent = 'ユーザー名とパスワードを入力してください。';
            }
        });
    </script>
</body>
</html>