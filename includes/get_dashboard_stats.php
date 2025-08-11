<?php
require_once '../config/database.php';

try {
    $stats = [];
    
    // Next appointment
    $stmt = $pdo->query("
        SELECT DATE_FORMAT(appointment_date, '%b %d') as next_appointment
        FROM appointments 
        WHERE appointment_date >= CURDATE() 
        ORDER BY appointment_date ASC, appointment_time ASC 
        LIMIT 1
    ");
    $stats['next_appointment'] = $stmt->fetchColumn();
    
    // Average mood (last 7 days)
    $stmt = $pdo->query("
        SELECT AVG(mood) as avg_mood 
        FROM daily_entries 
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ");
    $stats['avg_mood'] = round($stmt->fetchColumn());
    
    // Total boat trips
    $stmt = $pdo->query("SELECT COUNT(*) as boat_trips FROM boat_trips");
    $stats['boat_trips'] = $stmt->fetchColumn();
    
    // Days logged (all time)
    $stmt = $pdo->query("SELECT COUNT(*) as days_logged FROM daily_entries");
    $stats['days_logged'] = $stmt->fetchColumn();
    
    respond(true, '', ['stats' => $stats]);
    
} catch (Exception $e) {
    error_log('Error fetching dashboard stats: ' . $e->getMessage());
    respond(false, 'Error loading dashboard stats');
}
?>