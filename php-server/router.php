<?php
// Apply CORS headers to all responses
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,Content-Type,Origin,Accept');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
header('X-Frame-Options: ALLOWALL'); // Allow iframe embedding from any domain
header('Access-Control-Max-Age: 86400');

// Handle OPTIONS preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Check if the requested file exists directly
$file_path = __DIR__ . $_SERVER['REQUEST_URI'];
if (file_exists($file_path) && !is_dir($file_path)) {
    // It's a real file, return it with appropriate MIME type
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);
    
    // Define common MIME types
    $mime_types = [
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
    ];
    
    // Set content type if we know it
    if (isset($mime_types[$extension])) {
        header('Content-Type: ' . $mime_types[$extension]);
    }
    
    // Output the file
    readfile($file_path);
    return true;
}

// If it's a request for PHP files, route to controller
if (strpos($_SERVER['REQUEST_URI'], 'php/controller.php') !== false) {
    include __DIR__ . '/php/controller.php';
    return true;
}

// Default fallback route
include __DIR__ . '/index.html';
?> 