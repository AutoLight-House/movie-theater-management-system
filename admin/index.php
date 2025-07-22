<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
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

// Database configuration
$hoste = 'localhost';  // MySQL server host (e.g., localhost)
$dbNamee = 'mirai';  // Your database name
$usernamee = 'root';  // Your database username
$passworde = '';  // Your database password

try {
  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$hoste;dbname=$dbNamee", $usernamee, $passworde);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Query to count the rows in the "user" table
  $query = "SELECT COUNT(*) as count FROM users";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  // Fetch the count value
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $rowCount = $result['count'];
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

try {
  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$hoste;dbname=$dbNamee", $usernamee, $passworde);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Query to count the total bookings
  $query = "SELECT COUNT(*) as count FROM bookings";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  // Fetch the count value
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $bookingCount = $result['count'];

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}


try {
  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$hoste;dbname=$dbNamee", $usernamee, $passworde);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Query to count the total theatres
  $query = "SELECT COUNT(*) as count FROM movie_theatres";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  // Fetch the count value
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $theatreCount = $result['count'];

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
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
<?php include("./template/header.php")?>
    <div class="d-flex align-items-stretch">
    <?php include("./template/side.php")?>
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Total Users</strong>
                    </div>
                    <div class="number dashtext-1"><?php echo $rowCount ?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: <?php echo $rowCount ?>%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="1000" class="progress-bar progress-bar-template dashbg-1"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-contract"></i></div><strong>Total Bookings</strong>
                    </div>
                    <div class="number dashtext-2"><?php echo $bookingCount?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: <?php echo $bookingCount?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="1000" class="progress-bar progress-bar-template dashbg-2"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-contract"></i></div><strong>Total Theatres</strong>
                    </div>
                    <div class="number dashtext-2"><?php echo  $theatreCount?></div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: <?php echo  $theatreCount?>%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="1000" class="progress-bar progress-bar-template dashbg-2"></div>
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
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>