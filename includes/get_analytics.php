<?php
require_once '../config/database.php';

try {
    // Get analytics data
    $analytics = [];
    
    // Total daily entries
    $stmt = $pdo->query("SELECT COUNT(*) as total_entries FROM daily_entries");
    $analytics['total_entries'] = $stmt->fetchColumn();
    
    // Average energy (last 30 days)
    $stmt = $pdo->query("
        SELECT AVG(energy) as avg_energy 
        FROM daily_entries 
        WHERE date >= date('now', '-30 days')
    ");
    $analytics['avg_energy'] = $stmt->fetchColumn();
    
    // Total boat hours
    $stmt = $pdo->query("SELECT SUM(duration) as total_hours FROM boat_trips");
    $analytics['total_boat_hours'] = $stmt->fetchColumn() ?: 0;
    
    // Best rated trip location
    $stmt = $pdo->query("
        SELECT location 
        FROM boat_trips 
        WHERE rating = (SELECT MAX(rating) FROM boat_trips) 
        LIMIT 1
    ");
    $analytics['best_trip'] = $stmt->fetchColumn();
    
    respond(true, '', ['analytics' => $analytics]);
    
} catch (Exception $e) {
    error_log('Error fetching analytics: ' . $e->getMessage());
    respond(false, 'Error loading analytics');
}
?>