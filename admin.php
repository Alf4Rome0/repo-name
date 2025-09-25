<?php
session_start();
include 'db.php';

// Проверка на администраторский доступ
if (!isset($_SESSION['admin'])) {
    // Форма для входа администратора
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['username'] == 'admin' && $_POST['password'] == 'password') {
            $_SESSION['admin'] = true;
        }
    } else {
        echo '<form method="POST">
                <input type="text" name="login" placeholder="Логин" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти как администратор</button>
              </form>';
        exit();
    }
}

// Получаем все заявки
$stmt = $pdo->query("SELECT requests.*, users.fio, users.login FROM requests JOIN users ON requests.user_id = users.id");
$requests = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $request_id]);
    header("Location: admin.php"); // Перезагрузка страницы
    exit();
}
// Получаем все заявки
$stmt = $pdo->query("SELECT requests.*, users.fio FROM requests JOIN users ON requests.user_id = users.id");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC); // Убедитесь, что вы получаете ассоциативный массив

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Панель администратора</h1>
    <table>
        <tr>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Дата и время</th>
            <th>Мастер</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?php echo htmlspecialchars($appointment['phone']); ?></td>
            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
            <td><?php echo htmlspecialchars($appointment['master_id']); ?></td>
            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
            <td>
                <form method="POST" action="update.php" style="display:inline;">
                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit">Одобрить</button>
                </form>
                <form method="POST" action="update.php" style="display:inline;">
                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit">Отклонить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</body>
</html>