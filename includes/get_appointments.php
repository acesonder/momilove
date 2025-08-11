<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->prepare("
        SELECT appointment_date, appointment_time, doctor, appointment_type, notes, status 
        FROM appointments 
        WHERE appointment_date >= date('now')
        ORDER BY appointment_date ASC, appointment_time ASC 
        LIMIT 10
    ");
    
    $stmt->execute();
    $appointments = $stmt->fetchAll();
    
    respond(true, '', ['appointments' => $appointments]);
    
} catch (Exception $e) {
    error_log('Error fetching appointments: ' . $e->getMessage());
    respond(false, 'Error loading appointments');
}
?>