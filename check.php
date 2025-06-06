<?php
session_start();

// SQL接続に必要な情報を変数に格納
$host = 'localhost';
$dbname = 'bbs';          
$user = 'root';          
$pass = 'root';   

try {
    // DSN（データソース名）を作成し、PDOオブジェクトで接続
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);

    // エラーモードを「例外」に設定（エラー時に例外が発生するようにする）
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $password = $_POST['password'];


     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $sql = $pdo->prepare("SELECT * FROM user WHERE password = ? AND username = ?");

            if($sql){
                $sql->bindParam(2, $username);
                $sql->bindParam(1, $hashedPassword);
                $test = $sql->execute();
            }
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user){
                //ログイン成功
                $_SESSION['username'] = $user->username;   
                $_SESSION['password'] = $user->password;  
                 header("Location: form.php");
                 exit;
            }else{
                //ログイン失敗 
                 header("Location: login.php");
                 exit;
            }

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo "接続失敗: " . $e->getMessage();
}

?>
