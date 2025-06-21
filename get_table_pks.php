<?php
// GET PKs for DELETE's DROPDOWN
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $stmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
        $pkRow = $stmt->fetch();

        if (!$pkRow) {
            echo json_encode(['error' => 'No primary key found for table.']);
            exit;
        }

        $pk = $pkRow['Column_name'];
        $stmt = $pdo->query("SELECT `$pk` FROM `$table` ORDER BY `$pk` ASC");
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode(['pk' => $pk, 'values' => $ids]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'DB Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
