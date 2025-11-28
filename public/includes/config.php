<?php
// includes/config.php - app configuration (local dev)
return [
    'db' => [
        'host' => '127.0.0.1',
        'name' => 'inanna_db',   // <-- confirmed database name
        'user' => 'root',
        'pass' => '',            // default XAMPP root has empty password
        'charset' => 'utf8mb4',
    ],
    // mail/twilio configs can be added here later
];
