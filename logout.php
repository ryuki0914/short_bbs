<?php
session_start();

// セッション変数を全て解除
$_SESSION = [];

// セッション自体を破棄
session_destroy();

// form.php にリダイレクト
header("Location: ./form.php");
exit;
?>