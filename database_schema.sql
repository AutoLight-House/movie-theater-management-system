-- ======================================================
-- Movie Booking System Database Schema
-- Version: 2.0.0
-- Author: Zain Ul Abidien Qazi
-- Student ID: 1319382
-- Date: 2025-01-22
-- ======================================================

-- Set SQL mode and charset
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ======================================================
-- Create Database
-- ======================================================
CREATE DATABASE IF NOT EXISTS `mirai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mirai`;

-- ======================================================
-- Table: admins
-- Purpose: Store administrator account information
-- ======================================================
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default admin user
INSERT INTO `admins` (`username`, `password`, `fname`, `lname`, `email`) VALUES
('admin', '$2y$10$EE/ahEi7ppMELQCmJqGuDOWkl2slmbOJRLvydRE/xFPsctlWxKRQm', 'System', 'Administrator', 'admin@moviebooking.com');

-- ======================================================
-- Table: users
-- Purpose: Store user account information
-- ======================================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample user
INSERT INTO `users` (`username`, `password`, `fname`, `lname`, `email`) VALUES
('testuser', '$2y$10$EE/ahEi7ppMELQCmJqGuDOWkl2slmbOJRLvydRE/xFPsctlWxKRQm', 'Test', 'User', 'test@example.com');

-- ======================================================
-- Table: movie_theatres
-- Purpose: Store theater/cinema information
-- ======================================================
CREATE TABLE `movie_theatres` (
  `theatre_id` int(11) NOT NULL AUTO_INCREMENT,
  `theatres` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `facilities` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`theatre_id`),
  UNIQUE KEY `theatre_name` (`theatres`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample theaters
INSERT INTO `movie_theatres` (`theatres`, `address`, `city`, `capacity`) VALUES
('Bahria Town Cinema', 'Bahria Town, Phase 4', 'Rawalpindi', 300),
('DHA Cinema Complex', 'DHA Phase 1', 'Lahore', 250),
('Gulberg Multiplex', 'Gulberg III', 'Lahore', 400),
('F-7 Movie Theater', 'F-7 Markaz', 'Islamabad', 200);

-- ======================================================
-- Table: bookings
-- Purpose: Store movie ticket booking information
-- ======================================================
CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `mid` varchar(50) NOT NULL,
  `movie_name` varchar(255) DEFAULT NULL,
  `DATE` date NOT NULL,
  `TIME` time NOT NULL,
  `Rticket` int(11) NOT NULL DEFAULT 0,
  `Kticket` int(11) NOT NULL DEFAULT 0,
  `kelass` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `booking_status` enum('confirmed','cancelled','pending') NOT NULL DEFAULT 'confirmed',
  `payment_status` enum('paid','pending','failed') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`BookingID`),
  KEY `idx_user_id` (`uid`),
  KEY `idx_location` (`location`),
  KEY `idx_date` (`DATE`),
  KEY `idx_booking_status` (`booking_status`),
  FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ======================================================
-- Dynamic Theater-Movie Tables
-- Purpose: Store movie information for each theater
-- Note: These are created dynamically by the application
-- Example structure for Bahria Town Cinema
-- ======================================================

-- Bahria Town Cinema Movies
CREATE TABLE `bahriatown` (
  `ID` varchar(255) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `yt` varchar(500) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `update` varchar(255) DEFAULT NULL,
  `imdb` varchar(10) DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `cast` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `box_office` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample movie
INSERT INTO `bahriatown` (`ID`, `Name`, `description`, `yt`, `picture`, `update`, `imdb`, `rating`, `genre`, `director`, `duration`) VALUES
('6974', 'John Wick Chapter 4', 'John Wick uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe and forces that turn old friends into foes.', 
'https://www.youtube.com/watch?v=qEVUtrk8_B4', 'uploads/john_64676eda381a5.jpg', 'released top', '8.2', 'R (Some Language|Pervasive Strong Violence)', 'Action, Crime, Thriller', 'Chad Stahelski', 169);

-- ======================================================
-- Dynamic Timing Tables
-- Purpose: Store showtimes for each movie in each theater
-- Example structure for timing tables
-- ======================================================

-- Example: Bahria Town - John Wick Chapter 4 - Date specific timings
CREATE TABLE `bahriatown_6974_timing` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` date NOT NULL,
  `Timings` time NOT NULL,
  `screen_number` int(11) DEFAULT 1,
  `available_seats` int(11) DEFAULT 100,
  `silver_price` decimal(10,2) DEFAULT 3000.00,
  `gold_price` decimal(10,2) DEFAULT 6000.00,
  `platinum_price` decimal(10,2) DEFAULT 9000.00,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `unique_datetime` (`DATE`, `Timings`, `screen_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample timings
INSERT INTO `bahriatown_6974_timing` (`DATE`, `Timings`, `available_seats`) VALUES
('2025-01-22', '09:00:00', 100),
('2025-01-22', '12:30:00', 100),
('2025-01-22', '16:00:00', 100),
('2025-01-22', '19:30:00', 100),
('2025-01-22', '22:00:00', 100);

-- ======================================================
-- Table: activity_logs
-- Purpose: Log user and admin activities for security
-- ======================================================
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_type` enum('user','admin') NOT NULL DEFAULT 'user',
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ======================================================
-- Table: user_sessions
-- Purpose: Manage user sessions for security
-- ======================================================
CREATE TABLE `user_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_last_activity` (`last_activity`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ======================================================
-- Table: system_settings
-- Purpose: Store application configuration settings
-- ======================================================
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('string','integer','boolean','json') NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `is_editable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default system settings
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', 'Movie Booking System', 'string', 'Name of the website'),
('site_email', 'admin@moviebooking.com', 'string', 'Main contact email'),
('default_currency', 'PKR', 'string', 'Default currency for pricing'),
('booking_advance_days', '30', 'integer', 'How many days in advance can bookings be made'),
('silver_base_price', '3000', 'integer', 'Base price for silver class tickets'),
('gold_base_price', '6000', 'integer', 'Base price for gold class tickets'),
('platinum_base_price', '9000', 'integer', 'Base price for platinum class tickets'),
('max_tickets_per_booking', '10', 'integer', 'Maximum tickets per booking'),
('booking_cancellation_hours', '2', 'integer', 'Hours before show time to allow cancellation'),
('enable_email_notifications', '1', 'boolean', 'Enable email notifications for bookings');

-- ======================================================
-- Table: movie_genres
-- Purpose: Store movie genre information
-- ======================================================
CREATE TABLE `movie_genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert common movie genres
INSERT INTO `movie_genres` (`name`, `description`) VALUES
('Action', 'High-energy films with physical stunts and chase scenes'),
('Comedy', 'Films intended to make the audience laugh'),
('Drama', 'Films with serious, realistic stories'),
('Horror', 'Films intended to frighten, unsettle, or create suspense'),
('Romance', 'Films with romantic relationships as central theme'),
('Thriller', 'Films with suspenseful, exciting plots'),
('Sci-Fi', 'Films with science fiction elements'),
('Fantasy', 'Films with magical or supernatural elements'),
('Adventure', 'Films with exciting journeys or quests'),
('Crime', 'Films involving criminal activities');

-- ======================================================
-- Create Indexes for Performance
-- ======================================================

-- Indexes for bookings table
CREATE INDEX `idx_bookings_movie` ON `bookings` (`mid`);
CREATE INDEX `idx_bookings_date_time` ON `bookings` (`DATE`, `TIME`);
CREATE INDEX `idx_bookings_status` ON `bookings` (`booking_status`, `payment_status`);

-- Indexes for users table
CREATE INDEX `idx_users_last_login` ON `users` (`last_login`);
CREATE INDEX `idx_users_created` ON `users` (`created_at`);

-- Indexes for admins table
CREATE INDEX `idx_admins_last_login` ON `admins` (`last_login`);

-- ======================================================
-- Create Views for Common Queries
-- ======================================================

-- View for active bookings with user information
CREATE VIEW `active_bookings_view` AS
SELECT 
    b.BookingID,
    b.uid as user_id,
    CONCAT(u.fname, ' ', u.lname) as user_name,
    u.email as user_email,
    b.location,
    b.mid as movie_id,
    b.movie_name,
    b.DATE as show_date,
    b.TIME as show_time,
    b.Rticket + b.Kticket as total_tickets,
    b.total_amount,
    b.booking_status,
    b.payment_status,
    b.created_at as booking_date
FROM bookings b
JOIN users u ON b.uid = u.id
WHERE b.booking_status = 'confirmed'
AND u.is_active = 1;

-- View for theater statistics
CREATE VIEW `theater_stats_view` AS
SELECT 
    mt.theatre_id,
    mt.theatres as theater_name,
    COUNT(DISTINCT b.BookingID) as total_bookings,
    SUM(b.total_amount) as total_revenue,
    AVG(b.total_amount) as avg_booking_amount,
    COUNT(DISTINCT b.uid) as unique_customers
FROM movie_theatres mt
LEFT JOIN bookings b ON mt.theatres = b.location
WHERE mt.is_active = 1
GROUP BY mt.theatre_id, mt.theatres;

-- ======================================================
-- Create Stored Procedures
-- ======================================================

DELIMITER //

-- Procedure to get available seats for a show
CREATE PROCEDURE GetAvailableSeats(
    IN p_theater VARCHAR(255),
    IN p_movie_id VARCHAR(255),
    IN p_date DATE,
    IN p_time TIME
)
BEGIN
    DECLARE total_booked INT DEFAULT 0;
    DECLARE table_name VARCHAR(500);
    DECLARE available_seats INT DEFAULT 100;
    
    -- Get booked tickets count
    SELECT COALESCE(SUM(Rticket + Kticket), 0) INTO total_booked
    FROM bookings 
    WHERE location = p_theater 
    AND mid = p_movie_id 
    AND DATE = p_date 
    AND TIME = p_time 
    AND booking_status = 'confirmed';
    
    -- Get total available seats from timing table (if exists)
    SET table_name = CONCAT(LOWER(REPLACE(p_theater, ' ', '')), '_', p_movie_id, '_timing');
    
    SET @sql = CONCAT('SELECT COALESCE(available_seats, 100) INTO @available FROM ', table_name, 
                      ' WHERE DATE = ''', p_date, ''' AND Timings = ''', p_time, ''' LIMIT 1');
    
    -- Execute if table exists
    SET @table_exists = 0;
    SELECT COUNT(*) INTO @table_exists 
    FROM information_schema.tables 
    WHERE table_schema = DATABASE() 
    AND table_name = table_name;
    
    IF @table_exists > 0 THEN
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
        SET available_seats = @available;
    END IF;
    
    SELECT (available_seats - total_booked) as available_seats;
END //

-- Procedure to create dynamic timing table
CREATE PROCEDURE CreateTimingTable(
    IN p_theater VARCHAR(255),
    IN p_movie_id VARCHAR(255)
)
BEGIN
    DECLARE table_name VARCHAR(500);
    DECLARE sql_create TEXT;
    
    SET table_name = CONCAT(LOWER(REPLACE(p_theater, ' ', '')), '_', p_movie_id, '_timing');
    
    SET sql_create = CONCAT('CREATE TABLE IF NOT EXISTS `', table_name, '` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `DATE` date NOT NULL,
        `Timings` time NOT NULL,
        `screen_number` int(11) DEFAULT 1,
        `available_seats` int(11) DEFAULT 100,
        `silver_price` decimal(10,2) DEFAULT 3000.00,
        `gold_price` decimal(10,2) DEFAULT 6000.00,
        `platinum_price` decimal(10,2) DEFAULT 9000.00,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `is_active` tinyint(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`ID`),
        UNIQUE KEY `unique_datetime` (`DATE`, `Timings`, `screen_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
    
    SET @sql = sql_create;
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

-- ======================================================
-- Create Triggers for Audit Trail
-- ======================================================

DELIMITER //

-- Trigger for user login tracking
CREATE TRIGGER users_login_update 
BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.last_login != OLD.last_login THEN
        INSERT INTO activity_logs (user_id, user_type, action, details, ip_address)
        VALUES (NEW.id, 'user', 'login', 'User logged in', @user_ip);
    END IF;
END //

-- Trigger for booking creation
CREATE TRIGGER booking_created
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    INSERT INTO activity_logs (user_id, user_type, action, details)
    VALUES (NEW.uid, 'user', 'booking_created', 
            CONCAT('Booking created for movie ', NEW.mid, ' on ', NEW.DATE, ' at ', NEW.TIME));
END //

DELIMITER ;

-- ======================================================
-- Final Setup
-- ======================================================

-- Update AUTO_INCREMENT values
ALTER TABLE `admins` AUTO_INCREMENT = 2;
ALTER TABLE `users` AUTO_INCREMENT = 2;
ALTER TABLE `movie_theatres` AUTO_INCREMENT = 5;
ALTER TABLE `bookings` AUTO_INCREMENT = 1;
ALTER TABLE `activity_logs` AUTO_INCREMENT = 1;
ALTER TABLE `system_settings` AUTO_INCREMENT = 11;
ALTER TABLE `movie_genres` AUTO_INCREMENT = 11;

-- Commit the transaction
COMMIT;

-- Reset SQL settings
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ======================================================
-- Database Schema Complete
-- Total Tables: 10 (6 static + 4 dynamic examples)
-- Total Views: 2
-- Total Procedures: 2
-- Total Triggers: 2
-- ======================================================
