<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once('./config.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ./user/login.php");
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
  // Fetch the user's name from the database
  $stmt = $pdo->prepare("SELECT fname, lname FROM users WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($user) {
    $fullName = sanitize_output($user['fname'] . ' ' . $user['lname']);
    
    // Display the user's name and a logout button
    echo '<div class="navbar">
            <span>Welcome, ' . $fullName . '!</span>
            <form action="./user/logout.php" method="post">
              <button type="submit" name="logout">Logout</button>
            </form>
          </div>';
  }
} else {
  // Display a login and register link
  echo '<div class="navbar">
          <a href="./user/login.php">Login</a>
          <a href="./user/registration.php">Register</a>
        </div>';
}
?>
