<?php
/**
 * Database Backup and Maintenance Script
 * Use this script to backup and maintain your database
 */

require_once 'config.php';

class DatabaseMaintenance {
    private $pdo;
    private $backup_dir;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->backup_dir = __DIR__ . '/backups/';
        
        // Create backup directory if it doesn't exist
        if (!is_dir($this->backup_dir)) {
            mkdir($this->backup_dir, 0755, true);
        }
    }
    
    /**
     * Create database backup
     */
    public function createBackup() {
        $filename = 'mirai_backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $this->backup_dir . $filename;
        
        // Get database name from config
        global $dbname, $host, $username, $password;
        
        $command = "mysqldump --host=$host --user=$username --password=$password $dbname > $filepath";
        
        // Execute backup command
        $result = exec($command, $output, $return_code);
        
        if ($return_code === 0) {
            return "Backup created successfully: $filename";
        } else {
            return "Backup failed: " . implode("\n", $output);
        }
    }
    
    /**
     * Optimize database tables
     */
    public function optimizeTables() {
        try {
            $tables = $this->pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $optimized = [];
            
            foreach ($tables as $table) {
                $this->pdo->exec("OPTIMIZE TABLE `$table`");
                $optimized[] = $table;
            }
            
            return "Optimized tables: " . implode(', ', $optimized);
        } catch (Exception $e) {
            return "Optimization failed: " . $e->getMessage();
        }
    }
    
    /**
     * Clean old session data
     */
    public function cleanSessions() {
        try {
            // Clean sessions older than 24 hours
            $cutoff = date('Y-m-d H:i:s', strtotime('-24 hours'));
            $stmt = $this->pdo->prepare("DELETE FROM user_sessions WHERE last_activity < ?");
            $stmt->execute([$cutoff]);
            
            return "Cleaned " . $stmt->rowCount() . " old sessions";
        } catch (Exception $e) {
            return "Session cleanup failed: " . $e->getMessage();
        }
    }
    
    /**
     * Clean old activity logs
     */
    public function cleanLogs($days = 30) {
        try {
            $cutoff = date('Y-m-d H:i:s', strtotime("-$days days"));
            $stmt = $this->pdo->prepare("DELETE FROM activity_logs WHERE created_at < ?");
            $stmt->execute([$cutoff]);
            
            return "Cleaned " . $stmt->rowCount() . " old log entries";
        } catch (Exception $e) {
            return "Log cleanup failed: " . $e->getMessage();
        }
    }
    
    /**
     * Get database statistics
     */
    public function getStats() {
        try {
            $stats = [];
            
            // Table sizes
            $query = "SELECT 
                        table_name as 'Table',
                        round(((data_length + index_length) / 1024 / 1024), 2) as 'Size (MB)',
                        table_rows as 'Rows'
                      FROM information_schema.tables 
                      WHERE table_schema = DATABASE()
                      ORDER BY (data_length + index_length) DESC";
            
            $stats['tables'] = $this->pdo->query($query)->fetchAll();
            
            // Total database size
            $query = "SELECT 
                        round(sum((data_length + index_length) / 1024 / 1024), 2) as 'Total Size (MB)'
                      FROM information_schema.tables 
                      WHERE table_schema = DATABASE()";
            
            $stats['total_size'] = $this->pdo->query($query)->fetchColumn();
            
            return $stats;
        } catch (Exception $e) {
            return "Failed to get stats: " . $e->getMessage();
        }
    }
}

// CLI usage
if (php_sapi_name() === 'cli') {
    $maintenance = new DatabaseMaintenance($pdo);
    
    if ($argc < 2) {
        echo "Usage: php maintenance.php [backup|optimize|clean|stats]\n";
        exit(1);
    }
    
    switch ($argv[1]) {
        case 'backup':
            echo $maintenance->createBackup() . "\n";
            break;
        case 'optimize':
            echo $maintenance->optimizeTables() . "\n";
            break;
        case 'clean':
            echo $maintenance->cleanSessions() . "\n";
            echo $maintenance->cleanLogs() . "\n";
            break;
        case 'stats':
            $stats = $maintenance->getStats();
            if (is_array($stats)) {
                echo "Database Statistics:\n";
                echo "Total Size: " . $stats['total_size'] . " MB\n\n";
                echo "Table Details:\n";
                foreach ($stats['tables'] as $table) {
                    echo sprintf("%-20s %10s MB %10s rows\n", 
                        $table['Table'], 
                        $table['Size (MB)'], 
                        $table['Rows']
                    );
                }
            } else {
                echo $stats . "\n";
            }
            break;
        default:
            echo "Unknown command: " . $argv[1] . "\n";
            exit(1);
    }
}
?>
