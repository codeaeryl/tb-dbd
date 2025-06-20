<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
    unset($_POST['table']);

    $allowedTables = ['players', 'friendships', 'player_progress', 'game_sessions', 'inventory', 'items', 'levels', 'leaderboards', 'leaderboard_entries', 'transactions'];
    if (!in_array($table, $allowedTables)) exit("Invalid table.");

    $pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Get primary key column name
    $stmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    $primary = $stmt->fetch();
    if (!$primary) exit("Primary key not found.");
    $pk = $primary['Column_name'];

    // Ensure the primary key value is provided
    if (!isset($_POST[$pk])) exit("Primary key value is missing.");
    $pk_value = $_POST[$pk];

    // Prepare update statement
    $columns = array_keys($_POST);
    if (empty($columns)) exit("No fields to update.");

    $assignments = implode(', ', array_map(fn($col) => "`$col` = :$col", $columns));
    $sql = "UPDATE `$table` SET $assignments WHERE `$pk` = :pk";

    $stmt = $pdo->prepare($sql);

    foreach ($_POST as $col => $val) {
        $stmt->bindValue(":$col", $val);
    }

    $stmt->bindValue(":pk", $pk_value);

    try {
        $stmt->execute();
        echo "Row updated successfully.";
    } catch (PDOException $e) {
        // Handle specific SQL errors
        $code = $e->errorInfo[1];
        if ($code == 1452) {
            echo "Error: Foreign key constraint failed — referenced value doesn't exist.";
        } elseif ($code == 1062) {
            echo "Error: Duplicate entry — a record with that key already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}