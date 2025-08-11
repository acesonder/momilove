<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->prepare("
        SELECT date, mood, energy, pain, notes 
        FROM daily_entries 
        ORDER BY date DESC 
        LIMIT 10
    ");
    
    $stmt->execute();
    $entries = $stmt->fetchAll();
    
    respond(true, '', ['entries' => $entries]);
    
} catch (Exception $e) {
    error_log('Error fetching daily entries: ' . $e->getMessage());
    respond(false, 'Error loading daily entries');
}
?>