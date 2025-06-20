<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'], $_POST['pk'], $_POST['pk_value'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
    $pk = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['pk']);
    $pk_value = $_POST['pk_value'];

    $allowedTables = ['players', 'friendships', 'player_progress', 'game_sessions', 'inventory', 'items', 'levels', 'leaderboards', 'leaderboard_entries', 'transactions'];
    if (!in_array($table, $allowedTables)) exit;

    $pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pk` = :pk LIMIT 1");
    $stmt->execute([':pk' => $pk_value]);
    $row = $stmt->fetch();

    echo json_encode($row ?: []);
}
?>