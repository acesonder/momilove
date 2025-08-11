<?php
require_once '../config/database.php';

try {
    // Group resources by category
    $stmt = $pdo->prepare("
        SELECT category, name, address, phone, description, website, hours, icon
        FROM resources 
        ORDER BY category, sort_order, name
    ");
    
    $stmt->execute();
    $resources = $stmt->fetchAll();
    
    // Group by category
    $categories = [];
    foreach ($resources as $resource) {
        $category = $resource['category'];
        if (!isset($categories[$category])) {
            $categories[$category] = [
                'name' => $category,
                'icon' => $resource['icon'],
                'resources' => []
            ];
        }
        $categories[$category]['resources'][] = $resource;
    }
    
    respond(true, '', ['categories' => array_values($categories)]);
    
} catch (Exception $e) {
    error_log('Error fetching resources: ' . $e->getMessage());
    respond(false, 'Error loading resources');
}
?>