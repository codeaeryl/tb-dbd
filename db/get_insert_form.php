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
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $stmt = $pdo->query("DESCRIBE `$table`");
        $columns = $stmt->fetchAll();

        echo "<h3>Insert into <strong>$table</strong></h3>";
        echo "<form id='insert-form'>";
        echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";

        foreach ($columns as $col) {
            $field = htmlspecialchars($col['Field']);
            $type = strtolower($col['Type']);
            $required = ($col['Null'] === 'NO' && $col['Extra'] !== 'auto_increment') ? 'required' : '';
            if ($col['Extra'] === 'auto_increment') continue;

            echo "<label>$field: ";
            if (str_contains($type, 'int')) {
                echo "<input type='number' name='$field' $required>";
            } elseif (str_contains($type, 'date')) {
                echo "<input type='date' name='$field' $required>";
            } elseif (str_contains($type, 'text') || str_contains($type, 'varchar')) {
                echo "<input type='text' name='$field' $required>";
            } else {
                echo "<input type='text' name='$field' $required>";
            }
            echo "</label><br>";
        }

        echo "<button type='submit'>Insert</button>";
        echo "</form>";

    } catch (PDOException $e) {
        echo "Error generating form.";
    }
}
?>