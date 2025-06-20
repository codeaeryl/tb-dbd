<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);

    $allowedTables = ['players', 'friendships', 'player_progress', 'game_sessions', 'inventory', 'items', 'levels', 'leaderboards', 'leaderboard_entries', 'transactions'];
    if (!in_array($table, $allowedTables)) exit("Invalid table.");

    $pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Get column metadata
    $stmt = $pdo->query("DESCRIBE `$table`");
    $columns = $stmt->fetchAll();

    // Get one row (for example editing the first row)
    $stmt = $pdo->query("SELECT * FROM `$table` LIMIT 1");
    $row = $stmt->fetch();

    if (!$row) {
        echo "No data to edit.";
        exit;
    }
    echo "<h3>EDIT <strong>$table</strong></h3>";
    echo "<form id='edit-form'>";
    echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";

    foreach ($columns as $col) {
        $field = $col['Field'];
        $type = strtolower($col['Type']);
        $placeholder = htmlspecialchars($row[$field]);
        $readonly = ''; // allow editing of primary key
        $extraAttr = '';

        if ($col['Key'] === 'PRI') {
            $extraAttr = "id='primary-key' data-field='$field'";
        }

        echo "<p><label>$field: ";
        if (str_contains($type, 'int')) {
            echo "<input type='number' name='$field' placeholder='$placeholder' class='edit-field' $readonly $extraAttr>";
        } else {
            echo "<input type='text' name='$field' placeholder='$placeholder' class='edit-field' $readonly $extraAttr>";
        }
        echo "</label></p>";
    }

    echo "<button type='submit'>Update</button>";
    echo "</form>";
}
?>
