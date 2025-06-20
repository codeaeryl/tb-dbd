<?php
// Fetch POST data
$table = $_POST['table'] ?? '';
$pk = $_POST['pk'] ?? '';
$pk_value = $_POST['pk_value'] ?? '1';

$pdo = new PDO("mysql:host=localhost;dbname=candy_crush_db;charset=utf8mb4", 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Detect primary key if not given
if (!$pk) {
    $stmt = $pdo->query("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    $pkRow = $stmt->fetch();
    $pk = $pkRow['Column_name'] ?? 'id'; // fallback to 'id'
}

// Fetch row data
$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pk` = :pk_value LIMIT 1");
$stmt->execute(['pk_value' => $pk_value]);
$row = $stmt->fetch();

if (!$row) {
    echo "<p>No row found with $pk = $pk_value</p>";
    exit;
}

// Render form
echo "<form id='edit-form'>";
echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";
echo "<input type='hidden' name='pk' value='" . htmlspecialchars($pk) . "'>";

echo "<label>$pk (Primary Key): ";
echo "<input type='number' id='edit-pk-input' name='pk_value' value='" . htmlspecialchars($pk_value) . "'>";
echo "</label><br><br>";

foreach ($row as $field => $value) {
    if ($field === $pk) continue; // already shown above
    echo "<label>$field: ";
    echo "<input name='" . htmlspecialchars($field) . "' value='" . htmlspecialchars($value) . "'>";
    echo "</label><br>";
}

echo "<button type='submit'>Update</button>";
echo "</form>";
