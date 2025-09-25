<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT appointments.*, masters.name AS master_name FROM appointments JOIN masters ON appointments.master_id = masters.id WHERE user_id = ?");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои Записи</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Мои Записи</h1>
    <a href="create_appointment.php">Создать новую запись</a>
    <table>
        <tr>
            <th>Мастер</th>
            <th>Дата и время</th>
            <th>Статус</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['master_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>