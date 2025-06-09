<?php
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    $name = $_SESSION['username'];
}else{
    $name = '';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一言掲示板 - 投稿</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>💬 一言掲示板</h1>
    <form action="post.php" method="post">
        <?php
        if(!empty($name)){
            echo '<p>ようこそ、', $name ,'さん</p>';
            echo '<p>名前：<input type="text" name="name" value="', $name ,'" readonly></p>';
        }else{
            echo '<p>名前：<input type="text" name="name" value="名無し" readonly></p>';
        }
        ?>
        
        <p>コメント：<br>
        <textarea name="comment" rows="4" cols="40" required></textarea></p>
        <p><button type="submit">投稿する</button></p>
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
        <?= $name ?>
    </div>
</body>
</html>
