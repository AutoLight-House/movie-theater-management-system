<?php

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  // Check if the user is not logged in
  if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ./login.php");
    exit();
  }
  
  // Check if the user is logged in
  if (isset($_SESSION['user_id'])) {
  // Connect to the database
  $pdo = new PDO("mysql:host=localhost;dbname=mirai", "root", "");
  
  // Fetch the user's name from the database
  $stmt = $pdo->prepare("SELECT fname, lname FROM admins WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $fullName = $user['fname'] . ' ' . $user['lname'];
  
  } else {
  
  }
  





require_once('./config.php');
$id = $_GET['id'];
$iddb = $_GET['iddb'];
$mid = $_GET['id'];
$timing_table_name = "$iddb" . "_" . "$mid" . "_Timing";

$query = "DELETE FROM `$iddb` WHERE ID = :id;
DROP TABLE `$timing_table_name`;";

$stmt = $con->prepare($query);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header("Location: manageindex.php?iddb=$iddb");
} else {
    echo "Failed to delete data";
}

?>
