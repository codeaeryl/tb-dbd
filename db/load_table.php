<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
    $columns = '*';

    $useJoin = false;
    $customQuery = "";

    if ($table === 'Transactions') {
        $useJoin = true;
        $customQuery = "
            SELECT 
                t.transaction_id,
                p.username,
                i.item_name,
                t.amount,
                t.transaction_date
            FROM 
                transactions t
            JOIN 
                players p ON t.player_id = p.player_id
            JOIN 
                items i ON t.item_id = i.item_id
        ";
    }

    if (isset($_POST['columns']) && is_array($_POST['columns'])) {
        $sanitizedColumns = array_map(function($col) {
            return preg_replace('/[^a-zA-Z0-9_]/', '', $col);
        }, $_POST['columns']);

        $columns = implode(',', array_map(fn($col) => "`$col`", $sanitizedColumns));
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

        $stmt = $useJoin
            ? $pdo->query($customQuery)
            : $pdo->query("SELECT $columns FROM `$table`");

        $data = $stmt->fetchAll();

        if (empty($data)) {
            echo "No data found.";
            exit;
        }
        

        // Extract all unique keys
        $allKeys = [];
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                $allKeys[$key] = true;
            }
        }
        $headers = array_keys($allKeys);

        // Output table HTML
        echo "<div id='container-header'";
        echo "<h2>" . htmlspecialchars($table) ."</h2>";
        echo "</div>";
        echo "<table id='table'>";
        echo "<tr id='table-header'>";
        foreach ($headers as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr>";

        foreach ($data as $row) {
            echo "<tr>";
            foreach ($headers as $header) {
                echo "<td>" . (isset($row[$header]) ? htmlspecialchars($row[$header]) : '') . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        echo "DB Error: " . htmlspecialchars($e->getMessage());
    }} else {
        echo "Invalid request.";
    }
?>
