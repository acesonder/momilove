<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method');
}

try {
    $date = sanitizeInput($_POST['date']);
    $mood = (int)$_POST['mood'];
    $energy = (int)$_POST['energy'];
    $pain = (int)$_POST['pain'];
    $notes = sanitizeInput($_POST['notes']);
    
    // Validate input
    if (empty($date)) {
        respond(false, 'Date is required');
    }
    
    if ($mood < 1 || $mood > 4) {
        respond(false, 'Invalid mood value');
    }
    
    if ($energy < 0 || $energy > 10) {
        respond(false, 'Energy must be between 0 and 10');
    }
    
    if ($pain < 0 || $pain > 10) {
        respond(false, 'Pain must be between 0 and 10');
    }
    
    // Insert or update entry
    $stmt = $pdo->prepare("
        INSERT OR REPLACE INTO daily_entries (date, mood, energy, pain, notes) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([$date, $mood, $energy, $pain, $notes]);
    
    respond(true, 'Daily entry saved successfully');
    
} catch (Exception $e) {
    error_log('Error saving daily entry: ' . $e->getMessage());
    respond(false, 'Error saving daily entry');
}
?>