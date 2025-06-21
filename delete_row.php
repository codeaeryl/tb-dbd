<?php
// DELETE BACK END
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'], $_POST['pk_value'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table']);
    $pk_value = $_POST['pk_value'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // Get primary key
        $stmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
        $row = $stmt->fetch();
        if (!$row) exit("❌ No PK found for $table.");

        $pk = $row['Column_name'];

        $stmt = $pdo->prepare("DELETE FROM `$table` WHERE `$pk` = :pk_value");
        $stmt->execute(['pk_value' => $pk_value]);

        echo "✅ Deleted row with $pk = $pk_value from $table.";
    } catch (PDOException $e) {
        echo "❌ DB Error: " . $e->getMessage();
    }
} else {
    echo "❌ Invalid request.";
}