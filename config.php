<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'schoolar');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Application configuration
define('APP_NAME', 'Schoolar');
define('APP_ENV', 'development');
define('APP_DEBUG', true);
define('APP_URL', 'http://localhost/schoolar/schoolar');

// JWT configuration
define('JWT_SECRET', 'your-secret-key-here'); // Change this to a secure secret key in production

// Set error reporting based on environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Time zone
date_default_timezone_set('UTC');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));

// Return configuration as array for easy access
return [
    'app' => [
        'name' => APP_NAME,
        'env' => APP_ENV,
        'debug' => APP_DEBUG,
        'url' => APP_URL
    ],
    'database' => [
        'host' => DB_HOST,
        'name' => DB_NAME,
        'user' => DB_USER,
        'password' => DB_PASSWORD
    ]
]; 