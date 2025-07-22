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
$query = "SELECT * FROM users WHERE id= '$id'";
$res = $con->query($query);
$row=  $res->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="./vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="./css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="./css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="./css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
</head>
<body>

<?php include("./template/header.php")?>

    <div class="d-flex align-items-stretch">
    <?php include("./template/sidetable.php")?>
      <div class="page-content">
        <!-- Page Header-->
        <div class="page-header no-margin-bottom">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Basic forms</h2>
          </div>
        </div>
        <!-- Breadcrumb-->
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Basic forms            </li>
          </ul>
        </div>
        <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <!-- Basic Form-->
              <div class="col-lg-12">
                <div class="block">
                  <div class="title"><strong class="d-block">Basic Form</strong><span class="d-block">Lorem ipsum dolor sit amet consectetur.</span></div>
                  <div class="block-body">
                  <form method="POST">
                  <div class="form-group">
                    <label class="form-control-label">First Name</label>
                    <input type="text" value="<?php echo$row['fname'] ?>" name="first_name" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Last Name</label>
                    <input type="text" value="<?php echo$row['lname'] ?>" name="last_name" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Email</label>
                    <input type="email" value="<?php echo$row['Email'] ?>" name="email" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Username</label>
                    <input type="text" value="<?php echo sanitize_output($row['username']) ?>" name="username" required>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label">Passowrd</label>
                    <input type="txt" value="<?php echo$row['password'] ?>" name="password" required>
                  </div>
                  <div class="form-group">       
                    <input type="submit" name="submit" class="btn btn-primary">
                  </div>
                </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>



<?php

$oldpass = $row['password'];

if (isset($_POST['submit'])) {
  // Retrieve the updated user details from the form
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($password == $oldpass) {


    $stmt = $pdo->prepare("UPDATE users SET fname = :first_name, lname = :last_name, email = :email, username = :username WHERE id = :id");
    $result = $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'id' => $id]);

} else {
     // Hash the new password
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
     // Update the user record with the hashed password
     $stmt = $pdo->prepare("UPDATE users SET fname = :first_name, lname = :last_name, email = :email, username = :username, password = :password WHERE id = :id");
     $result = $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'password' => $hashed_password, 'id' => $id]);}

// Check if the update was successful
if ($result) {
    // Redirect to the userindex.php page
    echo"<script> window.location.href='userindex.php';</script>";
    exit();
} else {
    echo "Failed to update user.";
}
}


?>


