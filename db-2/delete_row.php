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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['table'] ?? null;
    $pkColumn = $_POST['pk_column'] ?? null;
    $pkValue = $_POST['pk_value'] ?? null;

    // Validasi input dasar
    if (!$table || !$pkColumn || $pkValue === null) {
        http_response_code(400);
        die("Error: Missing required data for deletion.");
    }
    
    // Daftar tabel yang diizinkan untuk keamanan
    $allowed_tables = [
        'players', 'friendships', 'player_progress', 'game_sessions', 
        'inventory', 'items', 'levels', 'leaderboards', 
        'leaderboard_entries', 'transactions'
    ];
    if (!in_array($table, $allowed_tables)) {
        http_response_code(403);
        die('Error: Invalid table name specified.');
    }

    try {
        // Persiapkan statement SQL untuk menghapus data
        $sql = "DELETE FROM `$table` WHERE `$pkColumn` = :pk_value";
        $stmt = $pdo->prepare($sql);
        
        // Bind parameter dan eksekusi
        $stmt->execute(['pk_value' => $pkValue]);

        // Kirim respon sukses
        if ($stmt->rowCount() > 0) {
            echo "Row with $pkColumn = $pkValue from table '$table' was deleted successfully.";
        } else {
            // Ini bisa terjadi jika baris dihapus oleh user lain sebelum Anda
            echo "No row found with $pkColumn = $pkValue to delete.";
        }

    } catch (PDOException $e) {
        // Tangani error database (misal: foreign key constraint)
        http_response_code(500);
        echo "Error deleting row: " . $e->getMessage();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
