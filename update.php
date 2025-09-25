<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $appointment_date])) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Ошибка обновления статуса.";
    }
}
?>