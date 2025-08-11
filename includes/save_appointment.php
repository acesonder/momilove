<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method');
}

try {
    $appointment_date = sanitizeInput($_POST['appointment_date']);
    $appointment_time = sanitizeInput($_POST['appointment_time']);
    $doctor = sanitizeInput($_POST['doctor']);
    $appointment_type = sanitizeInput($_POST['appointment_type']);
    $notes = sanitizeInput($_POST['notes']);
    
    // Validate input
    if (empty($appointment_date) || empty($appointment_time) || empty($doctor) || empty($appointment_type)) {
        respond(false, 'Date, time, doctor, and type are required');
    }
    
    // Insert appointment
    $stmt = $pdo->prepare("
        INSERT INTO appointments (appointment_date, appointment_time, doctor, appointment_type, notes) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([$appointment_date, $appointment_time, $doctor, $appointment_type, $notes]);
    
    respond(true, 'Appointment saved successfully');
    
} catch (Exception $e) {
    error_log('Error saving appointment: ' . $e->getMessage());
    respond(false, 'Error saving appointment');
}
?>