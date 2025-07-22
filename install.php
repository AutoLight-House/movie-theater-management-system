<?php
/**
 * Installation Script for Movie Booking System
 * This script helps set up the database and initial configuration
 */

$errors = [];
$success = [];

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0') < 0) {
    $errors[] = "PHP 7.4 or higher is required. Current version: " . PHP_VERSION;
}

// Check required extensions
$required_extensions = ['pdo', 'pdo_mysql', 'session'];
foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $errors[] = "Required PHP extension missing: $ext";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $dbname = $_POST['dbname'] ?? 'mirai';
    $username = $_POST['username'] ?? 'root';
    $password = $_POST['password'] ?? '';
    
    try {
        // Test database connection
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $success[] = "Database '$dbname' created successfully!";
        
        // Select database
        $pdo->exec("USE `$dbname`");
        
        // Read and execute SQL file
        $sql_file = __DIR__ . '/mirai.sql';
        if (file_exists($sql_file)) {
            $sql = file_get_contents($sql_file);
            
            // Remove comments and split by semicolon
            $sql = preg_replace('/--.*$/m', '', $sql);
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    $pdo->exec($statement);
                }
            }
            $success[] = "Database tables created successfully!";
        } else {
            $errors[] = "SQL file 'mirai.sql' not found!";
        }
        
        // Update config file
        $config_content = "<?php
/**
 * Database Configuration File
 * Contains database connection settings and PDO instance
 */

// Database configuration
\$host = '$host';
\$dbname = '$dbname';
\$username = '$username';
\$password = '$password';

try {
    // Create PDO instance with proper error handling
    \$pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname;charset=utf8\", \$username, \$password);
    
    // Set PDO attributes for better security and error handling
    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    \$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    \$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Create connection variable for backward compatibility
    \$con = \$pdo;
    
} catch(PDOException \$e) {
    // Log error instead of displaying it to users
    error_log(\"Database connection failed: \" . \$e->getMessage());
    
    // Display user-friendly error message
    die(\"Database connection failed. Please try again later.\");
}

/**
 * Sanitize output to prevent XSS attacks
 */
function sanitize_output(\$data) {
    return htmlspecialchars(\$data, ENT_QUOTES, 'UTF-8');
}

/**
 * Validate and sanitize input
 */
function sanitize_input(\$data) {
    \$data = trim(\$data);
    \$data = stripslashes(\$data);
    \$data = htmlspecialchars(\$data);
    return \$data;
}
?>";
        
        file_put_contents(__DIR__ . '/config.php', $config_content);
        $success[] = "Configuration file updated successfully!";
        
        // Create default admin user
        $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT IGNORE INTO admins (username, password, fname, lname, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['admin', $admin_password, 'System', 'Administrator', 'admin@moviebooking.com']);
        $success[] = "Default admin user created! Username: admin, Password: admin123";
        
    } catch (PDOException $e) {
        $errors[] = "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        $errors[] = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System - Installation</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .error { color: red; background: #ffe6e6; padding: 10px; border: 1px solid red; margin: 10px 0; }
        .success { color: green; background: #e6ffe6; padding: 10px; border: 1px solid green; margin: 10px 0; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background: #005a87; }
    </style>
</head>
<body>
    <h1>Movie Booking System Installation</h1>
    
    <?php if ($errors): ?>
        <div class="error">
            <h3>Errors:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success">
            <h3>Success:</h3>
            <ul>
                <?php foreach ($success as $msg): ?>
                    <li><?php echo htmlspecialchars($msg); ?></li>
                <?php endforeach; ?>
            </ul>
            <?php if (empty($errors)): ?>
                <p><strong>Installation completed successfully!</strong></p>
                <p><a href="admin/login.php">Go to Admin Panel</a> | <a href="user/login.php">Go to User Login</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($success) || !empty($errors)): ?>
        <form method="POST">
            <div class="form-group">
                <label for="host">Database Host:</label>
                <input type="text" id="host" name="host" value="localhost" required>
            </div>
            
            <div class="form-group">
                <label for="dbname">Database Name:</label>
                <input type="text" id="dbname" name="dbname" value="mirai" required>
            </div>
            
            <div class="form-group">
                <label for="username">Database Username:</label>
                <input type="text" id="username" name="username" value="root" required>
            </div>
            
            <div class="form-group">
                <label for="password">Database Password:</label>
                <input type="password" id="password" name="password" value="">
            </div>
            
            <button type="submit">Install</button>
        </form>
    <?php endif; ?>
    
    <h2>System Requirements</h2>
    <ul>
        <li>PHP 7.4 or higher ✓</li>
        <li>MySQL 5.7 or higher</li>
        <li>PDO extension ✓</li>
        <li>Web server (Apache/Nginx)</li>
    </ul>
</body>
</html>
