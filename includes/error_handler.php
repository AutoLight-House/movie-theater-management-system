<?php
/**
 * Error Handler and Logger
 * Handles application errors and logging
 */

// Set error reporting level
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to users
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

/**
 * Custom error handler
 */
function custom_error_handler($severity, $message, $file, $line) {
    $error_message = "Error: [$severity] $message in $file on line $line";
    error_log($error_message);
    
    // For fatal errors, show user-friendly message
    if ($severity === E_ERROR || $severity === E_USER_ERROR) {
        include __DIR__ . '/../templates/error.php';
        exit();
    }
}

/**
 * Custom exception handler
 */
function custom_exception_handler($exception) {
    $error_message = "Uncaught exception: " . $exception->getMessage() . 
                    " in " . $exception->getFile() . 
                    " on line " . $exception->getLine();
    error_log($error_message);
    
    include __DIR__ . '/../templates/error.php';
    exit();
}

/**
 * Fatal error handler
 */
function custom_fatal_error_handler() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $error_message = "Fatal error: {$error['message']} in {$error['file']} on line {$error['line']}";
        error_log($error_message);
        
        include __DIR__ . '/../templates/error.php';
        exit();
    }
}

// Set custom handlers
set_error_handler('custom_error_handler');
set_exception_handler('custom_exception_handler');
register_shutdown_function('custom_fatal_error_handler');

/**
 * Log custom messages
 */
function log_message($message, $level = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $message" . PHP_EOL;
    file_put_contents(__DIR__ . '/../logs/application.log', $log_entry, FILE_APPEND | LOCK_EX);
}

/**
 * Log security events
 */
function log_security_event($event, $details = '') {
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    
    $log_entry = "[$timestamp] [SECURITY] $event - IP: $ip - Details: $details - User Agent: $user_agent" . PHP_EOL;
    file_put_contents(__DIR__ . '/../logs/security.log', $log_entry, FILE_APPEND | LOCK_EX);
}
?>
