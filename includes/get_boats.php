<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->prepare("
        SELECT trip_date, location, duration, weather, companions, activity, enjoyment, rating, notes 
        FROM boat_trips 
        ORDER BY trip_date DESC 
        LIMIT 10
    ");
    
    $stmt->execute();
    $trips = $stmt->fetchAll();
    
    respond(true, '', ['trips' => $trips]);
    
} catch (Exception $e) {
    error_log('Error fetching boat trips: ' . $e->getMessage());
    respond(false, 'Error loading boat trips');
}
?>