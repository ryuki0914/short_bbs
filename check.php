<?php
session_start();

// SQL接続に必要な情報を変数に格納
try {
                $pdo=new PDO('mysql:host=mysql320.phy.lolipop.lan;
    dbname=LAA1553908-bbs;charset=utf8mb4',
    'LAA1553908',
    'Pass0914');

    // エラーモードを「例外」に設定（エラー時に例外が発生するようにする）
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $password = $_POST['password'];


            $sql = $pdo->prepare("SELECT * FROM user WHERE username = ?");

            if($sql){
                $sql->bindParam(1, $username);
                $sql->execute();
                $user = $sql->fetch();

                if($user && password_verify($password, $user['password'])){
                    $_SESSION['username'] = $user['username'];   
                    $_SESSION['password'] = $user['password'];  
                    $_SESSION['id'] = $user['id'];
                    header("Location: form.php");
                    exit;
                }else{
                    //ログイン失敗 
                    echo "ログイン失敗<br>";
                    echo '<a href="./login.php">ログイン画面</a>';
                }
            }

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo "接続失敗: " . $e->getMessage();
}

?>
