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
  

  $nama = $_GET['nama'];

$table = $_GET['table'];
require_once('./config.php');
$id = $_GET['id'];
$mid = $_GET['mid'];
$iddb = $_GET['iddb'];
$tablename = $_GET['table'];
$query = "DELETE FROM `$tablename` WHERE id= '$id'";
$res = $con->query($query);
if($res)
{
    header("Location: timingsindex.php?iddb=$iddb&mid=$mid&nama=$nama");
}
else{
    echo "failed";
}
 
?>