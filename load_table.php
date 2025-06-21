<?php
// LOAD TABLE FRONT END
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
$table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
$columns = '*';
$order = strtolower($_POST['order'] ?? 'asc');
$order = in_array($order, ['asc', 'desc']) ? $order : 'asc';


$useJoin = false;
$customQuery = "";
$svg = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm240-240H200v160h240v-160Zm80 0v160h240v-160H520Zm-80-80v-160H200v160h240Zm80 0h240v-160H520v160ZM200-680h560v-80H200v80Z"/></svg>';

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
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-80v-800l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v800l-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60Zm120-200h480v-80H240v80Zm0-160h480v-80H240v80Zm0-160h480v-80H240v80Zm-40 404h560v-568H200v568Zm0-568v568-568Z"/></svg>';
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

    if ($useJoin) {
        $query = $customQuery . " ORDER BY t.transaction_id $order";
    } else {
        $pkStmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
        $pkRow = $pkStmt->fetch();
        $pk = $pkRow['Column_name'] ?? null;

        $query = "SELECT $columns FROM `$table`";
        if ($pk) {
            $query .= " ORDER BY `$pk` $order";
        }
    }

    $stmt = $pdo->query($query);
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
    echo "<div id='container-header'>";
    echo "$svg";
    echo "<h3>" . htmlspecialchars($table) ."</h3>";
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