<?php
/**
 * Movie Booking System - Main Entry Point
 * 
 * This is the main landing page for the Movie Booking System.
 * It provides navigation to user and admin sections.
 * 
 * @version 1.1.0
 */

// Start secure session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include configuration and functions
require_once('./config.php');
require_once('./includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Movie Booking System - Book tickets for your favorite movies">
    <meta name="keywords" content="movie, booking, tickets, cinema, theater">
    <meta name="author" content="Zain Ul Abidien Qazi">
    <title>Movie Booking System</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px;
        }

        .logo {
            font-size: 48px;
            margin-bottom: 10px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 36px;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 40px;
            font-size: 18px;
        }

        .nav-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            min-width: 150px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .btn-admin {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
        }

        .btn-install {
            background: linear-gradient(45deg, #27ae60, #229954);
            font-size: 14px;
            padding: 10px 20px;
            margin-top: 20px;
        }

        .features {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 40px;
            text-align: left;
        }

        .features h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .feature {
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .feature h4 {
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .feature p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            color: #7f8c8d;
            font-size: 14px;
        }

        .status-message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        @media (max-width: 768px) {
            .container {
                padding: 40px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 28px;
            }

            .nav-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🎬</div>
        <h1>Movie Booking System</h1>
        <p class="subtitle">Your gateway to the best movie experience</p>

        <?php
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            // Fetch user information
            $stmt = $pdo->prepare("SELECT fname, lname FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();
            
            if ($user) {
                echo '<div class="status-message status-success">';
                echo 'Welcome back, ' . sanitize_output($user['fname'] . ' ' . $user['lname']) . '!';
                echo '</div>';
            }
        }

        // Check if database is properly configured
        try {
            $stmt = $pdo->query("SELECT 1 FROM users LIMIT 1");
            $db_status = "operational";
        } catch (Exception $e) {
            $db_status = "needs_setup";
            echo '<div class="status-message status-warning">';
            echo 'System needs to be set up. Please run the installation first.';
            echo '</div>';
        }
        ?>

        <div class="nav-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user/" class="btn">Go to Dashboard</a>
                <a href="user/logout.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="user/login.php" class="btn">User Login</a>
                <a href="user/registration.php" class="btn">Register</a>
            <?php endif; ?>
            
            <a href="admin/" class="btn btn-admin">Admin Panel</a>
        </div>

        <?php if ($db_status === "needs_setup"): ?>
            <a href="install.php" class="btn btn-install">🔧 Run Installation</a>
        <?php endif; ?>

        <div class="features">
            <h3>System Features</h3>
            <div class="feature-grid">
                <div class="feature">
                    <div class="feature-icon">👤</div>
                    <h4>User Management</h4>
                    <p>Secure registration and login system with user profiles and booking history.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">🎭</div>
                    <h4>Movie Management</h4>
                    <p>Comprehensive movie database with trailers, ratings, and detailed information.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">🎫</div>
                    <h4>Booking System</h4>
                    <p>Easy ticket booking with seat selection and multiple payment options.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">🏢</div>
                    <h4>Theater Management</h4>
                    <p>Multiple theater locations with dynamic showtime scheduling.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">📱</div>
                    <h4>Responsive Design</h4>
                    <p>Mobile-friendly interface that works on all devices and screen sizes.</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">🔐</div>
                    <h4>Security</h4>
                    <p>Advanced security features including encryption and secure sessions.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Movie Booking System v1.1.0</strong></p>
            <p>Developed by Zain Ul Abidien Qazi (Student ID: 1319382)</p>
            <p>PHP Movie Booking System Project</p>
            <p>© 2023-2025 All rights reserved</p>
        </div>
    </div>
</body>
</html>
