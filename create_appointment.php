<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_number = $_POST['car_number'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO statements (user_id, car_number, description) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $car_number, $description])) {
        echo "Заявление успешно подано.";
    } else {
        echo "Ошибка при подаче заявления.";
    }
}

$masters = $pdo->query("SELECT * FROM masters")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запись на ноготочки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Запись на "Ноготочки"</h2>
    <form action="appointments.php" method="POST">
        <label for="master">Выберите мастера:</label>
        <select name="master_id" required>
            <option value="">Выберите мастера</option>
            <option value="">Василева Лариса Александровна</option>
            <option value="">Колесова Милана Даниэльевна</option>
            <option value="">Гусева Дарья Максимовна</option>
            <option value="">Шарипова Эльвина Ильназовна</option>
            <option value="">Сабитова Сабина Денисовна</option>
            <?php foreach ($masters as $master): ?>
                <option value="<?= htmlspecialchars($master['id']); ?>">
                    <?= htmlspecialchars($master['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="appointment_date">Выберите дату и время:</label>
        <input type="datetime-local" name="appointment_date" required>
        
        <button type="submit">Записаться</button>
        <button type="submit"><a href="appointments.php">Назад</a><br/></button>
    </form>
</body>
</html>