<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>ログイン</h1>
    <form action="check.php" method="post">
        <p>ユーザー名：<input type="text" name="username"></p>
        <p>パスワード：<input type="text" name="password" ></p>
        <p><button type="submit">ログイン</button></p>
    </form>

    <a href="signup.php">新規登録</a>　　
    <a href="form.php">投稿画面</a>
</body>
</html>