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
$query = "SELECT * FROM movie_theatres WHERE theatre_id= '$id'";
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
                        <label class="form-control-label">Theatre Name</label>
                        <input type="text" value="<?php echo $row['theatres']?>" name="thtname">
                      </div>
                      <div class="form-group">       
                        <input type="submit" value="submit" class="btn btn-primary">
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
            <div class="container-fluid text-center">
               <p class="no-margin-bottom">2018 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
            </div>
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



if(isset($_POST['submit'])){

    $name = $_POST['thtname'];

    $query = "UPDATE `movie_theatres` SET `theatres`='$name' WHERE theatre_id=$id";


    $res = $con -> query($query);

    if($res)
    {
        header("Location:index.php");
    }
    else{
        echo "failed";
    }
}




?>


