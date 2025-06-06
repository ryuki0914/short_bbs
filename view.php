<?php
    session_start();

    try {
    // DSN（データソース名）を作成し、PDOオブジェクトで接続
    $pdo=new PDO('mysql:host=mysql305.phy.lolipop.lan;
    dbname=LAA1553908-php2024;charset=utf8mb4',
    'LAA1553908',
    'Pass0914');

    // エラーモードを「例外」に設定（エラー時に例外が発生するようにする）
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $pdo->prepare('SELECT * FROM comment INNER JOIN user ON comment.user_id = user.id');
    $sql->execute();
    $comment = $sql->fetchAll();
    } catch (PDOException $e) {
        // エラーが発生した場合の処理
        echo "接続失敗: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一言掲示板 - 投稿一覧</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>📜 投稿一覧</h1>
    <p><a href="form.php">← 投稿フォームへ戻る</a></p>
    <hr>
    <?php
    $filename = 'comments.txt';
    if (isset($comment)) {
        foreach (array_reverse($comment) as $line) {
            echo "<div class='post'>";
            echo "<p><strong>", $line['username'] ,"</strong> さん (", $line['created_at'] ,")</p>";
            echo "<p>" . nl2br($line['content']) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>まだ投稿がありません。</p>";
    }
    ?>
</body>
</html>
