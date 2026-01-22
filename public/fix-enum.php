<?php
// Simple database fix script
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=db_konseling;charset=utf8mb4",
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

try {
    // Check current ENUM values
    $result = $pdo->query('SHOW COLUMNS FROM appointments WHERE Field = "status"')->fetch(PDO::FETCH_ASSOC);
    echo "Current status column type: " . $result['Type'] . "\n\n";

    // Fix the ENUM - add 'in_progress' if missing
    if (strpos($result['Type'], 'in_progress') === false) {
        echo "Fixing ENUM to include 'in_progress'...\n";
        $pdo->exec("ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci");
        
        // Verify the fix
        $result = $pdo->query('SHOW COLUMNS FROM appointments WHERE Field = "status"')->fetch(PDO::FETCH_ASSOC);
        echo "Updated status column type: " . $result['Type'] . "\n";
        echo "✓ ENUM fixed successfully!\n";
    } else {
        echo "✓ 'in_progress' already exists in ENUM\n";
    }

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
