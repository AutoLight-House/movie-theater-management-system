<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
    exit();
}

// Check if the login form has been submitted
if(isset($_POST['submit'])) {

    // Include the database connection file
    include('./config.php');

    // Get the user's entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute a SQL statement to retrieve the user with the matching username and password
    $stmt = $pdo->prepare("SELECT id, username, password FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // If a matching user is found and the password is correct, log them in by setting the user_id session variable
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ./index.php');
        exit();
    } else {
        // If the username or password is incorrect, display an error message
        $error = "Incorrect username or password.";
    }
}

// // Display the login form
// include('./index.php');
?>



<!-- <form method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" name="submit">Log In</button>

</form>
<a href="./registration.php">Register</a> -->


<!DOCTYPE html>
<html>
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
  <body>
    <div class="login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>
                      <?php if(isset($error)): ?>
      <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>
                      </h1>
                    <h1>Dashboard</h1>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="POST" class="form-validate">
                    <div class="form-group">
                      <input type="text"  name="username" required data-msg="Please enter your username" class="input-material">
                      <label for="login-username" class="label-material">User Name</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                      <label for="login-password" class="label-material">Password</label>
                    </div><button id="login" name="submit" type="submit" class="btn btn-primary">Login</button>
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
         <p>2018 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/popper.js/umd/popper.min.js"> </script>
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="./vendor/chart.js/Chart.min.js"></script>
    <script src="./vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="./js/front.js"></script>
  </body>
</html>