<?php           

    try {
            $pdo=new PDO('mysql:host=mysql320.phy.lolipop.lan;
    dbname=LAA1553908-bbs;charset=utf8mb4',
    'LAA1553908',
    'Pass0914');

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "接続成功<br>";
    } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage();
    }
    if(isset($_POST['post'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $check = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
        $check->execute([$username]);
        $count = $check->fetchColumn();

        if ($count > 0) {
            echo "<font color='red'>*このユーザー名は既に使われています。*</font>";
        }else{
            $sql = $pdo->prepare('INSERT INTO user (username, password, created_at) VALUES (?, ?, NOW())');

            if($sql){
                $sql->bindParam(1, $username);
                $sql->bindParam(2, $hashedPassword);
                if($sql->execute()){
                    echo '　　　--登録完了--<br>name:<strong>',$username,'</strong><br>password:',$password,"<br>登録日:", date('Y-m-d H:i:s');
                }else{
                    echo '登録失敗';
                }
            }else{
                echo 'SQLエラー';
            }
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h2>新規登録</h2>
    <form action="signup.php" method="POST">
        username:
        <input type="text" name="username"><br><br>
        password:
        <input type="password" name="password"><br><br>
        <button type="submit" name="post">登録</button>
    </form>
    <a href="./login.php">ログイン画面</a>　
    <a href="./form.php">掲示板作成画面</a>
</body>
</html>