<?php
// INSERT BACK END
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
    unset($_POST['table']);

    $allowedTables = ['players', 'friendships', 'player_progress', 'game_sessions', 'inventory', 'items', 'levels', 'leaderboards', 'leaderboard_entries', 'transactions'];
    if (!in_array($table, $allowedTables)) {
        http_response_code(400);
        exit("Invalid table.");
    }

    $host = 'localhost';
    $db   = 'candy_crush_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $columns = array_keys($_POST);
        $placeholders = array_map(fn($c) => ":$c", $columns);

        $sql = "INSERT INTO `$table` (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $pdo->prepare($sql);

        foreach ($columns as $col) {
            $stmt->bindValue(":$col", $_POST[$col]);
        }

        $stmt->execute();
        echo "Insert successful.";

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Insert failed: " . $e->getMessage();
    }
}
?>