<?php
$table = $_POST['table'] ?? '';
$pk = $_POST['pk'] ?? '';
$pk_value = $_POST['pk_value'] ?? '';

if (!$table || !$pk || !$pk_value) {
    echo json_encode([]);
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pk` = :pk_value LIMIT 1");
$stmt->execute(['pk_value' => $pk_value]);
$row = $stmt->fetch();

echo json_encode($row ?: []);
?>