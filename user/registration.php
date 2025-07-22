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

// Check if the registration form has been submitted
if(isset($_POST['submit'])) {

    // Include the database connection file
    include('./config.php');

    // Get the user's entered details
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username or email already exists in the database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $user = $stmt->fetch();

    // If the username or email already exists, display an error message
    if($user) {
        if($user['username'] == $username) {
            $error = "Username already exists.";
        } else {
            $error = "Email already exists.";
        }
    } else {
        // If the username and email are unique, insert the new user into the database and set the user_id session variable
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fname, lname, email, username, password) VALUES (:first_name, :last_name, :email, :username, :password)");
        $stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'password' => $hashed_password]);
        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        header('Location: ./index.php');
        exit();
    }
}

// // Display the registration form
// include('../templates/header.php');

?>

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
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
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
                  <form method="POST" class="text-left form-validate">
                    <div class="form-group-material">
                      <input id="register-firstname" type="text" name="first_name" required data-msg="Please enter your username" class="input-material">
                      <label for="register-irstname" class="label-material">First Name</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-lastname" type="text" name="last_name" required data-msg="Please enter your username" class="input-material">
                      <label for="register-lastname" class="label-material">Last Name</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-username" type="text" name="username" required data-msg="Please enter your username" class="input-material">
                      <label for="register-username" class="label-material">Username</label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-email" type="email" name="email" required data-msg="Please enter a valid email address" class="input-material">
                      <label for="register-email" class="label-material">Email Address      </label>
                    </div>
                    <div class="form-group-material">
                      <input id="register-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                      <label for="register-password" class="label-material">Password        </label>
                    </div>
                    <div class="form-group text-center">
                      <input id="register" type="submit" value="Register" class="btn btn-primary">
                    </div>
                  </form><small>Already have an account? </small><a href="login.php" class="signup">Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
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




















<!-- <h2>Register</h2>

<?php if(isset($error)): ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" name="submit">Register</button>
</form>
<a href="./login.php">Login</a> -->