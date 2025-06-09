<?php
session_start();

// CSRFトークンチェック
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('不正なリクエストです。');
}

$id = $_SESSION['id'] ?? null;
$name = $_POST['name'] ?? '';
$comment = trim($_POST['comment'] ?? '');

if ($comment === '') {
    header("Location: form.php");
    exit;
}

if (mb_strlen($comment) > 200) {
    die('コメントは200文字以内で入力してください。');
}

try {
    $pdo = new PDO(
        'mysql:host=mysql320.phy.lolipop.lan;dbname=LAA1553908-bbs;charset=utf8mb4',
        'LAA1553908',
        'Pass0914',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if ($id !== null) {
        $sql = $pdo->prepare('INSERT INTO comment(user_id, content, created_at) VALUES (?, ?, NOW())');
        $sql->bindParam(1, $id);
        $sql->bindParam(2, $comment);
    } else {
        $sql = $pdo->prepare('INSERT INTO comment(content, created_at) VALUES (?, NOW())');
        $sql->bindParam(1, $comment);
    }

    if ($sql->execute()) {
        header('Location: view.php');
        exit;
    } else {
        echo '投稿失敗<br><a href="./form.php">フォーム画面</a>';
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "投稿処理中にエラーが発生しました。";
    exit;
}
?>
