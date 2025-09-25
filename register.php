
    <?php
    session_start();
    include 'db.php'; // Подключение к базе данных

    $fio = $_POST['fio'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$login = $_POST['login']; // Измените на $_POST['login'] вместо $_POST['department']

try {
    $stmt = $pdo->prepare("INSERT INTO users (fio, phone, email, password, username) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$fio, $phone, $email, $password, $login]);
    echo "Регистрация успешна!";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
    } else {
        echo "Ошибка регистрации: Этот email уже используется." . $e->getMessage();
    }
}
?>

    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Регистрация</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>Регистрация</h1>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Регистрация</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <form method="POST" action="register.php">
            <label for="fio">ФИО:</label>
            <input type="text" name="fio" required>

            <label for="phone">Телефон:</label>
            <input type="phone" name="phone" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="login">Логин:</label>
            <input type="login" name="login" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required>
            <button type="submit">Зарегистрироваться</button>
            <button type="submit"><a href="login.php">Вход</a><br/></button>
        </form>
    </body>
    </html>

    </body>
    </html> 