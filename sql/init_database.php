<?php
function initDatabase($pdo) {
    // Daily tracker table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS daily_entries (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            date DATE NOT NULL UNIQUE,
            mood INTEGER NOT NULL DEFAULT 3,
            energy INTEGER NOT NULL DEFAULT 5,
            pain INTEGER NOT NULL DEFAULT 0,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Boat trips table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS boat_trips (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            trip_date DATE NOT NULL,
            location TEXT NOT NULL,
            duration REAL NOT NULL,
            weather TEXT,
            companions TEXT,
            activity TEXT,
            enjoyment INTEGER DEFAULT 3,
            rating INTEGER NOT NULL DEFAULT 3,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Appointments table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS appointments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            appointment_date DATE NOT NULL,
            appointment_time TIME NOT NULL,
            doctor TEXT NOT NULL,
            appointment_type TEXT NOT NULL,
            notes TEXT,
            status TEXT DEFAULT 'scheduled',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Resources table (pre-populated with Milford, SK resources)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS resources (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category TEXT NOT NULL,
            name TEXT NOT NULL,
            address TEXT,
            phone TEXT,
            description TEXT,
            website TEXT,
            hours TEXT,
            icon TEXT DEFAULT '📍',
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Insert default Milford, Saskatchewan resources
    $resources = [
        // Healthcare
        ['Healthcare', 'Kindersley Regional Health Centre', '1003 12th Ave E, Kindersley, SK S0L 1S0', '(306) 463-2656', 'Main hospital serving Milford area', '', 'Emergency: 24/7', '🏥'],
        ['Healthcare', 'Milford Medical Clinic', 'Main St, Milford, SK', '(306) 463-2123', 'Family medicine and walk-in clinic', '', 'Mon-Fri 9AM-5PM', '⚕️'],
        ['Healthcare', 'Unity Health Centre', '306 3rd Ave E, Unity, SK S0K 4L0', '(306) 228-2686', 'Healthcare services for Unity/Milford region', '', 'Mon-Fri 8:30AM-4:30PM', '🏥'],
        
        // Emergency Services
        ['Emergency', 'RCMP Kindersley Detachment', '1405 12th Ave E, Kindersley, SK S0L 1S0', '(306) 463-4642', 'Police services for Milford area', '', '24/7', '🚔'],
        ['Emergency', 'Kindersley Fire Department', '1404 13th Ave E, Kindersley, SK S0L 1S0', '(306) 463-6565', 'Fire and emergency services', '', '24/7 Emergency', '🚒'],
        ['Emergency', 'SaskPower Emergency', '', '1-888-757-6937', 'Power outage reporting', '', '24/7', '⚡'],
        
        // Senior Services
        ['Senior Services', 'West Central Seniors Association', 'Kindersley, SK', '(306) 463-6123', 'Senior programs and support services', '', 'Mon-Fri 9AM-4PM', '👴'],
        ['Senior Services', 'Meals on Wheels Kindersley', 'Kindersley, SK', '(306) 463-4891', 'Meal delivery for seniors', '', 'Mon-Fri', '🍽️'],
        ['Senior Services', 'Home Care Services', 'West Central Health Region', '(306) 463-1000', 'In-home healthcare support', '', 'Mon-Fri 8AM-4PM', '🏠'],
        
        // Transportation
        ['Transportation', 'Handi-Bus West Central', 'Kindersley, SK', '(306) 463-4545', 'Accessible transportation service', '', 'By appointment', '🚐'],
        ['Transportation', 'Unity Taxi', 'Unity, SK', '(306) 228-2345', 'Local taxi service', '', 'Call for hours', '🚕'],
        
        // Pharmacy
        ['Pharmacy', 'Pharmasave Kindersley', '1208 12th Ave E, Kindersley, SK S0L 1S0', '(306) 463-6505', 'Full service pharmacy', '', 'Mon-Sat 9AM-6PM', '💊'],
        ['Pharmacy', 'Unity Pharmacy', '402 Main St, Unity, SK S0K 4L0', '(306) 228-2626', 'Local pharmacy services', '', 'Mon-Fri 9AM-5:30PM', '💊'],
        
        // Social Services
        ['Support', 'Saskatchewan Health Authority', 'Kindersley Office', '(306) 463-1000', 'Health system navigation and support', '', 'Mon-Fri 8AM-4PM', '📋'],
        ['Support', 'Community Living Division', 'Kindersley, SK', '(306) 463-4587', 'Support for individuals with disabilities', '', 'Mon-Fri 8:30AM-4:30PM', '🤝'],
        ['Support', 'Canadian Cancer Society', 'Saskatoon Office', '1-888-939-3333', 'Cancer support and resources', '', 'Mon-Fri 8:30AM-4:30PM', '🎗️'],
        
        // Recreation
        ['Recreation', 'Kindersley Regional Park', 'Kindersley, SK', '(306) 463-2675', 'Camping, fishing, boating facilities', '', 'Seasonal', '🏞️'],
        ['Recreation', 'Unity Lake', 'Unity, SK', '', 'Fishing and boating lake near Milford', '', 'Seasonal access', '⛵'],
        ['Recreation', 'Milford Community Centre', 'Milford, SK', '(306) 228-4567', 'Community events and gatherings', '', 'Varies', '🏢']
    ];
    
    // Check if resources already exist
    $stmt = $pdo->query("SELECT COUNT(*) FROM resources");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO resources (category, name, address, phone, description, website, hours, icon) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($resources as $resource) {
            $stmt->execute($resource);
        }
    }
}
?>