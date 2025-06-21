<?php
// UPDATE FRONT END
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

    // Find the primary key column
    $pk = null;
    foreach ($columns as $col) {
        if ($col['Key'] === 'PRI') {
            $pk = $col['Field'];
            break;
        }
    }

    if (!$pk) {
        echo "No primary key found.";
        exit;
    }

    // Fetch all available PK values for the dropdown
    $pkStmt = $pdo->query("SELECT `$pk` FROM `$table` ORDER BY `$pk` ASC");
    $pkValues = $pkStmt->fetchAll(PDO::FETCH_COLUMN);

    // Get selected PK value (default to first if not set)
    $pk_value = $_POST['pk_value'] ?? $pkValues[0];

    // Fetch the specific row by PK
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pk` = :pk_value LIMIT 1");
    $stmt->execute(['pk_value' => $pk_value]);
    $row = $stmt->fetch();

    if (!$row) {
        echo "No data found for selected $pk = $pk_value.";
        exit;
    }

    // Editing form
    echo "<form id='edit-form' method='POST'>";
    echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";

    foreach ($columns as $col) {
        $field = $col['Field'];
        $type = strtolower($col['Type']);
        $value = htmlspecialchars($row[$field]);

        if ($col['Key'] === 'PRI') {
            echo "<p><label>Select $pk to Edit: ";
            echo "<select id='primary-key' data-field='$field' name='$field' class='edit-field' value='$value' >";
            foreach ($pkValues as $val) {
                $selected = $val == $pk_value ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($val) . "' $selected>$val</option>";
            }
            echo "</select></label></p>";
        } else {
            echo "<p><label>$field: ";
            if (str_contains($type, 'int')) {
                echo "<input type='number' name='$field' class='edit-field' value='$value'>";
            } else {
                echo "<input type='text' name='$field' class='edit-field' value='$value'>";
            }
            echo "</label></p>";
        }

    }

    echo "<button type='submit'>Update</button>";
    echo "</form>";
}
?>
