<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: appointments.php");
        exit;
    } else {
        $error = "Неверный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Вход</h2>
    <form action="login.php" method="POST">
        <label for="login">Логин:</label>
        <input type="login" name="login" required>
        
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
        
        <button type="submit"><a href="appointments.php">Вход</a><br/></button>
    </form>
</body>
</html>