<?php
// Quick inline test to fix enum and show status
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

try {
    $dbHost = '127.0.0.1';
    $dbName = 'db_konseling';
    $dbUser = 'root';
    $dbPass = '';

    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "✓ Connected to database: $dbName\n\n";

    // Get current ENUM definition
    $stmt = $pdo->prepare("
        SELECT COLUMN_TYPE, COLUMN_DEFAULT, IS_NULLABLE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'appointments' AND COLUMN_NAME = 'status'
    ");
    $stmt->execute([$dbName]);
    $column = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($column) {
        echo "Current Status Column Definition:\n";
        echo "  Type: " . $column['COLUMN_TYPE'] . "\n";
        echo "  Default: " . ($column['COLUMN_DEFAULT'] ?? 'None') . "\n";
        echo "  Nullable: " . $column['IS_NULLABLE'] . "\n\n";

        // Check if 'in_progress' is present
        if (strpos($column['COLUMN_TYPE'], 'in_progress') === false) {
            echo "⚠ 'in_progress' is NOT in ENUM. Fixing...\n\n";
            
            $pdo->exec("
                ALTER TABLE appointments 
                MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') 
                DEFAULT 'pending' 
                NOT NULL 
                COLLATE utf8mb4_unicode_ci
            ");

            // Verify the fix
            $stmt = $pdo->prepare("
                SELECT COLUMN_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'appointments' AND COLUMN_NAME = 'status'
            ");
            $stmt->execute([$dbName]);
            $newColumn = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "✓ Fixed! New Type: " . $newColumn['COLUMN_TYPE'] . "\n\n";
            echo "✓ SUCCESS: You can now use 'in_progress' status for appointments!\n";
        } else {
            echo "✓ 'in_progress' is already in ENUM. No changes needed.\n";
        }
    } else {
        echo "✗ ERROR: Could not find 'status' column in appointments table\n";
    }

} catch (PDOException $e) {
    echo "✗ Database Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
