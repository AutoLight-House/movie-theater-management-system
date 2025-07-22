<?php
session_start();
require('./config.php');








if(isset($_SESSION['user_id'])) {
    $username = $_SESSION['user_id'];
} else {
    $username = '';
}

echo $_SESSION['user_id'];









?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <style>
        /* Flex container for navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f1f1f1;
        }
        
        /* Links in navbar */
        .navbar a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
        
        /* Logout button in navbar */
        .navbar button {
            margin: 0 10px;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div><?php echo $username; ?></div>
        <?php if(isset($_SESSION['user_id'])) { ?>
            <button onclick="window.location.href='./php/logout.php'">Logout</button>
        <?php } else { ?>
            <a href="./php/login.php">Login</a>
            <a href="./php/registration.php">Register</a>
        <?php } ?>
    </div>
    <h1>Welcome to my website!</h1>
</body>
</html>