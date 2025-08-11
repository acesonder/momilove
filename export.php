<?php
require_once 'config/database.php';

// Export functionality
if (isset($_GET['export']) && $_GET['export'] === 'json') {
    try {
        $export_data = [];
        
        // Export daily entries
        $stmt = $pdo->query("SELECT * FROM daily_entries ORDER BY date DESC");
        $export_data['daily_entries'] = $stmt->fetchAll();
        
        // Export boat trips
        $stmt = $pdo->query("SELECT * FROM boat_trips ORDER BY trip_date DESC");
        $export_data['boat_trips'] = $stmt->fetchAll();
        
        // Export appointments
        $stmt = $pdo->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
        $export_data['appointments'] = $stmt->fetchAll();
        
        // Set headers for download
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="momilove_data_' . date('Y-m-d') . '.json"');
        
        echo json_encode($export_data, JSON_PRETTY_PRINT);
        exit;
        
    } catch (Exception $e) {
        error_log('Error exporting data: ' . $e->getMessage());
        header('Location: index.php?error=export_failed');
        exit;
    }
}

// If not exporting, redirect to main page
header('Location: index.php');
exit;
?>