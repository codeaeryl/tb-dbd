<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);

    $allowedTables = ['players', 'friendships', 'player_progress', 'game_sessions', 'inventory', 'items', 'levels', 'leaderboards', 'leaderboard_entries', 'transactions'];

    if (!in_array($table, $allowedTables)) {
        exit("Invalid table.");
    }

    $host = 'localhost';
    $db   = 'candy_crush_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $stmt = $pdo->query("DESCRIBE `$table`");
        $columns = $stmt->fetchAll();
        echo "<h3>SELECT FROM <strong>$table</strong></h3>";
        echo "<form id='select-form'>";
        echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";
        echo "<p><label><input type='checkbox' id='select-all-columns' checked> <strong>Select All</strong></label></p>";

        foreach ($columns as $col) {
            $colName = htmlspecialchars($col['Field']);
            echo "<p><label><input type='checkbox' class='column-checkbox' value='$colName' checked> $colName</label><p>";
        }

        echo "<button type='submit'>Select</button>";
        echo "</form>";

    } catch (PDOException $e) {
        echo "Error loading columns.";
    }
}
?>
