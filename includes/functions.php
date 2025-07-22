<?php
/**
 * Security and Helper Functions
 * Common functions used throughout the application
 */

/**
 * Start session with security settings
 */
function secure_session_start() {
    if (session_status() == PHP_SESSION_NONE) {
        // Set secure session parameters
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS
        
        session_start();
        
        // Regenerate session ID periodically
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } elseif (time() - $_SESSION['created'] > 1800) { // 30 minutes
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
    }
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if admin is logged in
 */
function is_admin_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Redirect to login if not authenticated
 */
function require_login($admin = false) {
    if ($admin) {
        if (!is_admin_logged_in()) {
            header('Location: login.php');
            exit();
        }
    } else {
        if (!is_logged_in()) {
            header('Location: login.php');
            exit();
        }
    }
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Validate email format
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 */
function validate_password($password) {
    // At least 8 characters, one uppercase, one lowercase, one number
    return strlen($password) >= 8 && 
           preg_match('/[A-Z]/', $password) && 
           preg_match('/[a-z]/', $password) && 
           preg_match('/[0-9]/', $password);
}

/**
 * Log activity for security purposes
 */
function log_activity($user_id, $action, $details = '') {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $action, $details, $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
    } catch (Exception $e) {
        error_log("Failed to log activity: " . $e->getMessage());
    }
}

/**
 * Format date for display
 */
function format_date($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

/**
 * Generate random string for IDs
 */
function generate_random_string($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

/**
 * File upload validation
 */
function validate_image_upload($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Upload error occurred.";
    }
    
    if ($file['size'] > $max_size) {
        return "File size too large. Maximum 5MB allowed.";
    }
    
    if (!in_array($file['type'], $allowed_types)) {
        return "Invalid file type. Only JPG, PNG, and GIF allowed.";
    }
    
    return true;
}
?>
