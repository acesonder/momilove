<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method');
}

try {
    $trip_date = sanitizeInput($_POST['trip_date']);
    $location = sanitizeInput($_POST['location']);
    $duration = (float)$_POST['duration'];
    $weather = sanitizeInput($_POST['weather']);
    $companions = sanitizeInput($_POST['companions']);
    $activity = sanitizeInput($_POST['activity']);
    $enjoyment = (int)$_POST['enjoyment'];
    $rating = (int)$_POST['rating'];
    $notes = sanitizeInput($_POST['notes']);
    
    // Validate input
    if (empty($trip_date) || empty($location)) {
        respond(false, 'Trip date and location are required');
    }
    
    if ($duration <= 0) {
        respond(false, 'Duration must be greater than 0');
    }
    
    if ($enjoyment < 1 || $enjoyment > 4) {
        respond(false, 'Invalid enjoyment value');
    }
    
    if ($rating < 1 || $rating > 5) {
        respond(false, 'Rating must be between 1 and 5');
    }
    
    // Insert boat trip entry
    $stmt = $pdo->prepare("
        INSERT INTO boat_trips (trip_date, location, duration, weather, companions, activity, enjoyment, rating, notes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([$trip_date, $location, $duration, $weather, $companions, $activity, $enjoyment, $rating, $notes]);
    
    respond(true, 'Boat trip logged successfully');
    
} catch (Exception $e) {
    error_log('Error saving boat trip: ' . $e->getMessage());
    respond(false, 'Error saving boat trip');
}
?>