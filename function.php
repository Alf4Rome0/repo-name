<?php
include 'db.php';

function registerUser($fullName, $phone, $email, $username, $password) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, phone, email, username, password) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$fullName, $phone, $email, $username, $hashedPassword]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getUserStatements($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM statements WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addStatement($userId, $carNumber, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO statements (user_id, car_number, description) VALUES (?, ?, ?)");
    return $stmt->execute([$userId, $carNumber, $description]);
}

function getAllStatements() {
    global $pdo;
    $stmt = $pdo->query("SELECT s.*, u.full_name FROM statements s JOIN users u ON s.user_id = u.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateStatementStatus($statementId, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE statements SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $statementId]);
}
?>