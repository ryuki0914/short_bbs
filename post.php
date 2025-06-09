<?php
session_start();

$id = $_SESSION['id'];
$name = htmlspecialchars($_POST['name'] ?? '');
$comment = htmlspecialchars($_POST['comment'] ?? '');

if (trim($comment) === '') {
    header("Location: form.php");
    exit;
}
try {
    // DSN（データソース名）を作成し、PDOオブジェクトで接続
    $pdo=new PDO('mysql:host=mysql320.phy.lolipop.lan;
        dbname=LAA1553908-bbs;charset=utf8mb4',
        'LAA1553908',
        'Pass0914');

    // エラーモードを「例外」に設定（エラー時に例外が発生するようにする）
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_SESSION['id'])){
        $sql = $pdo->prepare('INSERT INTO comment(user_id, content, created_at) VALUES (?, ?, NOW())');
        $sql->bindParam(1, $id);
        $sql->bindParam(2, $comment);

        if($sql->execute()){
            header('Location: view.php');
            exit;
        }else{
            echo '投稿失敗<br>';
            echo '<a href="./form.php">フォーム画面</a>';
        }
        
    }else{
        $sql = $pdo->prepare('INSERT INTO comment(content, created_at) VALUES (?, NOW())');
        $sql->bindParam(1, $comment);

        if($sql->execute()){
            header('Location: view.php');
            exit;
        }else{
            echo '投稿失敗<br>';
            echo '<a href="./form.php">フォーム画面</a>';
        }
    }


    } catch (PDOException $e) {
        // エラーが発生した場合の処理
        echo "接続失敗: " . $e->getMessage();
    }
?>
