<?php
/**
 * Database Migration Script
 * Migrates from old schema with inappropriate field names to new clean schema
 * 
 * @author Zain Ul Abidien Qazi
 * @version 2.0.0
 * @date 2025-01-22
 */

require_once 'config.php';

class DatabaseMigration {
    private $pdo;
    private $backup_dir;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->backup_dir = __DIR__ . '/backups/';
        
        if (!is_dir($this->backup_dir)) {
            mkdir($this->backup_dir, 0755, true);
        }
    }
    
    /**
     * Check if migration is needed
     */
    public function needsMigration() {
        try {
            // Check if old field name exists
            $stmt = $this->pdo->query("SHOW COLUMNS FROM users LIKE 'niganame'");
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Create backup before migration
     */
    public function createBackup() {
        $filename = 'pre_migration_backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $this->backup_dir . $filename;
        
        global $dbname, $host, $username, $password;
        
        $command = "mysqldump --host=$host --user=$username";
        if (!empty($password)) {
            $command .= " --password=$password";
        }
        $command .= " $dbname > $filepath";
        
        $result = exec($command, $output, $return_code);
        
        if ($return_code === 0) {
            return "Backup created: $filename";
        } else {
            throw new Exception("Backup failed: " . implode("\n", $output));
        }
    }
    
    /**
     * Migrate users table
     */
    public function migrateUsersTable() {
        try {
            $this->pdo->beginTransaction();
            
            // Add new username column
            $this->pdo->exec("ALTER TABLE users ADD COLUMN username VARCHAR(255) AFTER id");
            
            // Copy data from niganame to username
            $this->pdo->exec("UPDATE users SET username = niganame");
            
            // Add unique constraint to username
            $this->pdo->exec("ALTER TABLE users ADD UNIQUE KEY username (username)");
            
            // Add new columns for enhanced user management
            $this->pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN date_of_birth DATE DEFAULT NULL AFTER phone");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER date_of_birth");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL DEFAULT NULL AFTER updated_at");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER last_login");
            $this->pdo->exec("ALTER TABLE users ADD COLUMN email_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER is_active");
            
            // Rename Email to email if it exists in uppercase
            $stmt = $this->pdo->query("SHOW COLUMNS FROM users LIKE 'Email'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE users CHANGE Email email VARCHAR(255) NOT NULL");
            }
            
            // Rename ID to id if it exists in uppercase
            $stmt = $this->pdo->query("SHOW COLUMNS FROM users LIKE 'ID'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE users CHANGE ID id INT(11) NOT NULL AUTO_INCREMENT");
            }
            
            $this->pdo->commit();
            return "Users table migrated successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Users table migration failed: " . $e->getMessage());
        }
    }
    
    /**
     * Migrate admins table
     */
    public function migrateAdminsTable() {
        try {
            $this->pdo->beginTransaction();
            
            // Add new username column
            $this->pdo->exec("ALTER TABLE admins ADD COLUMN username VARCHAR(255) AFTER id");
            
            // Copy data from niganame to username, but clean up inappropriate values
            $this->pdo->exec("UPDATE admins SET username = CASE 
                                WHEN niganame = 'Nigga' THEN 'admin'
                                ELSE niganame 
                              END");
            
            // Add unique constraint to username
            $this->pdo->exec("ALTER TABLE admins ADD UNIQUE KEY username (username)");
            
            // Add new columns for enhanced admin management
            $this->pdo->exec("ALTER TABLE admins ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER email");
            $this->pdo->exec("ALTER TABLE admins ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
            $this->pdo->exec("ALTER TABLE admins ADD COLUMN last_login TIMESTAMP NULL DEFAULT NULL AFTER updated_at");
            $this->pdo->exec("ALTER TABLE admins ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER last_login");
            
            // Rename Email to email if it exists in uppercase
            $stmt = $this->pdo->query("SHOW COLUMNS FROM admins LIKE 'Email'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE admins CHANGE Email email VARCHAR(255) NOT NULL");
            }
            
            // Rename ID to id if it exists in uppercase
            $stmt = $this->pdo->query("SHOW COLUMNS FROM admins LIKE 'ID'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE admins CHANGE ID id INT(11) NOT NULL AUTO_INCREMENT");
            }
            
            $this->pdo->commit();
            return "Admins table migrated successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Admins table migration failed: " . $e->getMessage());
        }
    }
    
    /**
     * Migrate bookings table
     */
    public function migrateBookingsTable() {
        try {
            $this->pdo->beginTransaction();
            
            // Add new columns for enhanced booking management
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN movie_name VARCHAR(255) DEFAULT NULL AFTER mid");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER kelass");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN booking_status ENUM('confirmed','cancelled','pending') NOT NULL DEFAULT 'confirmed' AFTER total_amount");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN payment_status ENUM('paid','pending','failed') NOT NULL DEFAULT 'pending' AFTER booking_status");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN payment_method VARCHAR(50) DEFAULT NULL AFTER payment_status");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER payment_method");
            $this->pdo->exec("ALTER TABLE bookings ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
            
            // Add indexes for better performance
            $this->pdo->exec("CREATE INDEX idx_user_id ON bookings(uid)");
            $this->pdo->exec("CREATE INDEX idx_location ON bookings(location)");
            $this->pdo->exec("CREATE INDEX idx_date ON bookings(DATE)");
            $this->pdo->exec("CREATE INDEX idx_booking_status ON bookings(booking_status)");
            $this->pdo->exec("CREATE INDEX idx_bookings_movie ON bookings(mid)");
            $this->pdo->exec("CREATE INDEX idx_bookings_date_time ON bookings(DATE, TIME)");
            $this->pdo->exec("CREATE INDEX idx_bookings_status ON bookings(booking_status, payment_status)");
            
            // Add foreign key constraint to users table
            $this->pdo->exec("ALTER TABLE bookings ADD FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE");
            
            $this->pdo->commit();
            return "Bookings table migrated successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Bookings table migration failed: " . $e->getMessage());
        }
    }
    
    /**
     * Migrate movie_theatres table
     */
    public function migrateTheatresTable() {
        try {
            $this->pdo->beginTransaction();
            
            // Add new columns for enhanced theater management
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN address TEXT DEFAULT NULL AFTER theatres");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN city VARCHAR(100) DEFAULT NULL AFTER address");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN state VARCHAR(100) DEFAULT NULL AFTER city");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN zip_code VARCHAR(10) DEFAULT NULL AFTER state");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER zip_code");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN email VARCHAR(255) DEFAULT NULL AFTER phone");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN capacity INT(11) DEFAULT NULL AFTER email");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN facilities TEXT DEFAULT NULL AFTER capacity");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER facilities");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
            $this->pdo->exec("ALTER TABLE movie_theatres ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER updated_at");
            
            // Add unique constraint
            $this->pdo->exec("ALTER TABLE movie_theatres ADD UNIQUE KEY theatre_name (theatres)");
            
            $this->pdo->commit();
            return "Movie theatres table migrated successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Movie theatres table migration failed: " . $e->getMessage());
        }
    }
    
    /**
     * Create new system tables
     */
    public function createSystemTables() {
        try {
            $this->pdo->beginTransaction();
            
            // Create activity_logs table
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS activity_logs (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) DEFAULT NULL,
                user_type ENUM('user','admin') NOT NULL DEFAULT 'user',
                action VARCHAR(255) NOT NULL,
                details TEXT DEFAULT NULL,
                ip_address VARCHAR(45) DEFAULT NULL,
                user_agent TEXT DEFAULT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY idx_user_id (user_id),
                KEY idx_action (action),
                KEY idx_created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
            
            // Create user_sessions table
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS user_sessions (
                id VARCHAR(128) NOT NULL,
                user_id INT(11) NOT NULL,
                ip_address VARCHAR(45) NOT NULL,
                user_agent TEXT DEFAULT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                last_activity TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                expires_at TIMESTAMP NOT NULL,
                PRIMARY KEY (id),
                KEY idx_user_id (user_id),
                KEY idx_last_activity (last_activity),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
            
            // Create system_settings table
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS system_settings (
                id INT(11) NOT NULL AUTO_INCREMENT,
                setting_key VARCHAR(255) NOT NULL,
                setting_value TEXT DEFAULT NULL,
                setting_type ENUM('string','integer','boolean','json') NOT NULL DEFAULT 'string',
                description TEXT DEFAULT NULL,
                is_editable TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY setting_key (setting_key)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
            
            // Insert default system settings
            $this->pdo->exec("INSERT IGNORE INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
                ('site_name', 'Movie Booking System', 'string', 'Name of the website'),
                ('site_email', 'admin@moviebooking.com', 'string', 'Main contact email'),
                ('default_currency', 'PKR', 'string', 'Default currency for pricing'),
                ('booking_advance_days', '30', 'integer', 'How many days in advance can bookings be made'),
                ('silver_base_price', '3000', 'integer', 'Base price for silver class tickets'),
                ('gold_base_price', '6000', 'integer', 'Base price for gold class tickets'),
                ('platinum_base_price', '9000', 'integer', 'Base price for platinum class tickets'),
                ('max_tickets_per_booking', '10', 'integer', 'Maximum tickets per booking'),
                ('booking_cancellation_hours', '2', 'integer', 'Hours before show time to allow cancellation'),
                ('enable_email_notifications', '1', 'boolean', 'Enable email notifications for bookings')");
            
            // Create movie_genres table
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS movie_genres (
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                description TEXT DEFAULT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY name (name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
            
            // Insert common movie genres
            $this->pdo->exec("INSERT IGNORE INTO movie_genres (name, description) VALUES
                ('Action', 'High-energy films with physical stunts and chase scenes'),
                ('Comedy', 'Films intended to make the audience laugh'),
                ('Drama', 'Films with serious, realistic stories'),
                ('Horror', 'Films intended to frighten, unsettle, or create suspense'),
                ('Romance', 'Films with romantic relationships as central theme'),
                ('Thriller', 'Films with suspenseful, exciting plots'),
                ('Sci-Fi', 'Films with science fiction elements'),
                ('Fantasy', 'Films with magical or supernatural elements'),
                ('Adventure', 'Films with exciting journeys or quests'),
                ('Crime', 'Films involving criminal activities')");
            
            $this->pdo->commit();
            return "System tables created successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("System tables creation failed: " . $e->getMessage());
        }
    }
    
    /**
     * Remove old columns after successful migration
     */
    public function cleanupOldColumns() {
        try {
            $this->pdo->beginTransaction();
            
            // Remove niganame column from users table
            $stmt = $this->pdo->query("SHOW COLUMNS FROM users LIKE 'niganame'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE users DROP COLUMN niganame");
            }
            
            // Remove niganame column from admins table
            $stmt = $this->pdo->query("SHOW COLUMNS FROM admins LIKE 'niganame'");
            if ($stmt->rowCount() > 0) {
                $this->pdo->exec("ALTER TABLE admins DROP COLUMN niganame");
            }
            
            $this->pdo->commit();
            return "Old columns cleaned up successfully";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Cleanup failed: " . $e->getMessage());
        }
    }
    
    /**
     * Run complete migration
     */
    public function runMigration() {
        $results = [];
        
        try {
            // Create backup first
            $results[] = $this->createBackup();
            
            // Run migrations
            $results[] = $this->migrateUsersTable();
            $results[] = $this->migrateAdminsTable();
            $results[] = $this->migrateBookingsTable();
            $results[] = $this->migrateTheatresTable();
            $results[] = $this->createSystemTables();
            
            // Clean up old columns (optional - commented out for safety)
            // $results[] = $this->cleanupOldColumns();
            
            return $results;
            
        } catch (Exception $e) {
            throw new Exception("Migration failed: " . $e->getMessage());
        }
    }
}

// Web interface
if (!isset($_GET['action'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Migration</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
            .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 5px; }
            .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 20px 0; border-radius: 5px; }
            .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 20px 0; border-radius: 5px; }
            .btn { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; display: inline-block; border-radius: 5px; }
            .btn-danger { background: #dc3545; }
            .btn:hover { opacity: 0.8; }
        </style>
    </head>
    <body>
        <h1>Database Migration Tool</h1>
        
        <?php
        $migration = new DatabaseMigration($pdo);
        $needsMigration = $migration->needsMigration();
        ?>
        
        <?php if ($needsMigration): ?>
            <div class="warning">
                <h3>⚠️ Migration Required</h3>
                <p>Your database contains old field names that need to be updated. This migration will:</p>
                <ul>
                    <li>Create a backup of your current database</li>
                    <li>Replace inappropriate field names with proper ones</li>
                    <li>Add new enhanced features and security</li>
                    <li>Preserve all your existing data</li>
                </ul>
                <p><strong>Important:</strong> This process will modify your database structure. Make sure you have a backup!</p>
            </div>
            
            <a href="?action=migrate" class="btn" onclick="return confirm('Are you sure you want to proceed with the migration? This will modify your database structure.')">
                🔧 Start Migration
            </a>
        <?php else: ?>
            <div class="success">
                <h3>✅ Database is Up to Date</h3>
                <p>Your database schema is already using the latest field names and structure.</p>
            </div>
        <?php endif; ?>
        
        <h2>Migration Features</h2>
        <ul>
            <li>✅ Automatic backup creation</li>
            <li>✅ Clean field name conversion</li>
            <li>✅ Enhanced security features</li>
            <li>✅ New system tables for logging</li>
            <li>✅ Improved database indexes</li>
            <li>✅ Foreign key constraints</li>
        </ul>
        
        <p><a href="index.php">← Back to Home</a></p>
    </body>
    </html>
    <?php
    exit;
}

// Handle migration
if ($_GET['action'] === 'migrate') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Migration Results</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
            .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
            .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
            .btn { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; display: inline-block; border-radius: 5px; }
        </style>
    </head>
    <body>
        <h1>Migration Results</h1>
        
        <?php
        $migration = new DatabaseMigration($pdo);
        
        try {
            $results = $migration->runMigration();
            
            echo '<div class="success">';
            echo '<h3>✅ Migration Completed Successfully!</h3>';
            echo '<ul>';
            foreach ($results as $result) {
                echo '<li>' . htmlspecialchars($result) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            
            echo '<p><strong>Next Steps:</strong></p>';
            echo '<ul>';
            echo '<li>✅ Test your application functionality</li>';
            echo '<li>✅ Verify all user accounts work correctly</li>';
            echo '<li>✅ Check admin panel functionality</li>';
            echo '<li>✅ Update any custom code if needed</li>';
            echo '</ul>';
            
        } catch (Exception $e) {
            echo '<div class="error">';
            echo '<h3>❌ Migration Failed</h3>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p>Please check your database configuration and try again.</p>';
            echo '</div>';
        }
        ?>
        
        <p><a href="index.php" class="btn">Go to Home Page</a></p>
    </body>
    </html>
    <?php
}
?>
