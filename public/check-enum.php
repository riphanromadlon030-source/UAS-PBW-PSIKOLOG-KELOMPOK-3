<?php
// Verify the ENUM fix
try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;dbname=db_konseling;charset=utf8mb4",
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Check current ENUM values
    $result = $pdo->query('SHOW COLUMNS FROM appointments WHERE Field = "status"')->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    
    if (strpos($result['Type'], 'in_progress') !== false) {
        echo json_encode([
            'success' => true,
            'message' => '✓ ENUM is correctly set with in_progress',
            'status_column_type' => $result['Type']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => '✗ ENUM does NOT have in_progress - needs fixing',
            'status_column_type' => $result['Type']
        ]);
    }

} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
