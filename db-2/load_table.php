<?php
// Konfigurasi dan koneksi database
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
} catch (\PDOException $e) {
    http_response_code(500);
    die("Connection failed: " . $e->getMessage());
}

$table = $_POST['table'] ?? '';

// Daftar tabel yang diizinkan untuk keamanan
$allowed_tables = [
    'players', 'friendships', 'player_progress', 'game_sessions', 
    'inventory', 'items', 'levels', 'leaderboards', 
    'leaderboard_entries', 'transactions'
];

if (!$table || !in_array($table, $allowed_tables)) {
    die("Invalid table selected.");
}

try {
    // Dapatkan Primary Key untuk tabel ini
    $pk_stmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    $primaryKeyColumn = $pk_stmt->fetchColumn(4);

    // Ambil semua data dari tabel
    $stmt = $pdo->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll();

    // Judul tabel
    echo "<div id='container-header'>";
    echo "<h2>" . htmlspecialchars($table) . "</h2>";
    echo "</div>";

    if (empty($rows)) {
        echo "<p>No data found in table: <strong>$table</strong></p>";
        exit;
    }

    echo "<table id='table'>";
    
    echo "<tr id='table-header'>";
    foreach ($rows[0] as $key => $value) {
        echo "<th>" . htmlspecialchars($key) . "</th>";
    }
    if ($primaryKeyColumn) {
        echo "<th>Actions</th>";
    }
    echo "</tr>";
    
    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
        }
        if ($primaryKeyColumn) {
            $pkValue = htmlspecialchars($row[$primaryKeyColumn]);
            echo "<td>";
            echo "<button class='delete-btn' 
                    data-table='$table' 
                    data-pk-column='$primaryKeyColumn' 
                    data-pk-value='$pkValue'>
                    Delete
                  </button>";
            echo "</td>";
        }
        echo "</tr>";
    }
    
    echo "</table>";

} catch (\PDOException $e) {
    echo "DB Error: " . htmlspecialchars($e->getMessage());
}
?>
