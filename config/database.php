<?php
// Database configuration - Using SQLite for demo purposes
$db_path = __DIR__ . '/../data/momilove.db';

// Create data directory if it doesn't exist
$data_dir = dirname($db_path);
if (!file_exists($data_dir)) {
    mkdir($data_dir, 0755, true);
}

try {
    $pdo = new PDO("sqlite:$db_path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Initialize database if needed
    include_once __DIR__ . '/../sql/init_database.php';
    initDatabase($pdo);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper functions
function respond($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data] + $data);
    exit;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>