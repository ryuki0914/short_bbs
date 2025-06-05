<?php
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

    echo "接続成功<br>";

    // -----------------------------
    // データ挿入（INSERT）
    // -----------------------------
    $sql = "INSERT INTO posts (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => '山田太郎',      // 名前のデータを設定
        ':comment' => 'こんにちは！'  // コメントのデータを設定
    ]);
    echo "データ挿入成功<br>";

    // -----------------------------
    // データ取得（SELECT）
    // -----------------------------
    $sql = "SELECT * FROM posts";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // 結果を連想配列で取得

    echo "データ取得成功:<br>";
    foreach ($results as $row) {
        echo "ID: {$row['id']}, 名前: {$row['name']}, コメント: {$row['comment']}<br>";
    }

    // -----------------------------
    // データ更新（UPDATE）
    // -----------------------------
    $sql = "UPDATE posts SET comment = :comment WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':comment' => '更新されたコメントです', // 更新後のコメントを設定
        ':id' => 1                                // 更新するレコードのIDを定める
    ]);
    echo "データ更新成功<br>";

    // -----------------------------
    // データ削除（DELETE）
    // -----------------------------
    $sql = "DELETE FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => 2 // 削除したいレコードのIDを定める
    ]);
    echo "データ削除成功<br>";

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    echo "接続失敗: " . $e->getMessage();
}
?>
