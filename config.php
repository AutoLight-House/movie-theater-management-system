<?php
/**
 * Database Configuration File
 * Contains database connection settings and PDO instance
 */

// Database configuration
$host = 'localhost';
$dbname = 'mirai';
$username = 'root';
$password = '';

try {
    // Create PDO instance with proper error handling
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set PDO attributes for better security and error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Create connection variable for backward compatibility
    $con = $pdo;
    
} catch(PDOException $e) {
    // Log error instead of displaying it to users
    error_log("Database connection failed: " . $e->getMessage());
    
    // Display user-friendly error message
    die("Database connection failed. Please try again later.");
}

/**
 * Sanitize output to prevent XSS attacks
 */
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Validate and sanitize input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>