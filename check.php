<?php
session_start();

// POST以外でアクセスされた場合は拒否
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=mysql320.phy.lolipop.lan;dbname=LAA1553908-bbs;charset=utf8mb4',
        'LAA1553908',
        'Pass0914',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    // CSRFトークンチェック（※トークンはログインフォームで埋め込んでおく必要あり）
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('不正なリクエストです。');
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // バリデーション（最低限）
    if (empty($username) || empty($password)) {
        die('ユーザー名とパスワードは必須です。');
    }

    $sql = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $sql->bindParam(1, $username);
    $sql->execute();
    $user = $sql->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ログイン成功 → セッション保存（パスワードは保存しない）
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id'];

        // トークン再生成（セッション固定攻撃対策）
        session_regenerate_id(true);

        header("Location: form.php");
        exit;
    } else {
        echo "ログイン失敗<br>";
        echo '<a href="./login.php">ログイン画面に戻る</a>';
    }

} catch (PDOException $e) {
    echo "接続失敗: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
?>
