#!/bin/bash
# Start PHP development server with the router script to handle CORS
echo "Starting PHP server on http://localhost:3000"
echo "All requests will include CORS headers for cross-origin access"
php -S 0.0.0.0:3000 router.php 