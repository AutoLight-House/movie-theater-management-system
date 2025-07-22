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
$iddb = $_GET['iddb'];
?>

<!DOCTYPE html>
<html lang="en">
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
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="form-control-label" >Movie ID</label>
                    <input type="text" name="mid">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Movie Name</label>
                    <input type="text" name="thtname">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Movie Description</label>
                    <input type="text" name="descript">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Movie Youtube Trailer Link</label>
                    <input type="text" name="yt">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Movie Poster</label>
                    <input type="file" name="picture">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Update</label>
                    <select name="update" class="form-control" id="exampleFormControlSelect1">
                    <option>released</option>
                    <option>soon</option>
                   <option>top</option>
                   <option>released top</option>
                   <option>soon top</option>
                 </select>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >IMDB</label>
                    <input type="txt" name="imdb">
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" >Rating</label>
                    <input type="txt" name="rating">
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


if (isset($_POST['submit'])) {

  $name = $_POST['thtname'];
  $des = $_POST['descript'];
  $yt = $_POST['yt'];
  $mid = $_POST['mid'];
  $update = $_POST['update'];
  $imdb = $_POST['imdb'];
  $rating = $_POST['rating'];
  
  // Handle the uploaded file
  $pic = '';
  if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
      $pic_name = $_FILES['picture']['name'];
      $pic_extension = pathinfo($pic_name, PATHINFO_EXTENSION);
      $pic_basename = pathinfo($pic_name, PATHINFO_FILENAME);
      $pic_unique_name = $pic_basename . '_' . uniqid() . '.' . $pic_extension;
      $pic = 'uploads/' . $pic_unique_name;
      move_uploaded_file($_FILES['picture']['tmp_name'], $pic);

  }

  // Check for duplicate picture names
  $query = "SELECT `picture` FROM `$iddb` WHERE `picture` LIKE :pic";
  $stmt = $con->prepare($query);
  $stmt->bindParam(':pic', $pic);
  $stmt->execute();
  $existing_pics = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  if (!in_array($pic, $existing_pics)) {
      // Insert data into database
      $query = "INSERT INTO `$iddb` (`ID`,`Name`, `description`, `yt`, `picture`, `update`, `imdb`, `rating`) VALUES (:mid,:name, :des, :yt, :pic, :update, :imdb, :rating)";
      $stmt = $con->prepare($query);
      $stmt->bindParam(':mid', $mid);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':des', $des);
      $stmt->bindParam(':yt', $yt);
      $stmt->bindParam(':pic', $pic);
      $stmt->bindParam(':update', $update);
      $stmt->bindParam(':imdb', $imdb);
      $stmt->bindParam(':rating', $rating);
  
      if ($stmt->execute()) {
          // Create timing table for this video
          $timing_table_name = "$iddb" . "_" . "$mid" . "_Timing";
          $query = "CREATE TABLE `$timing_table_name` (`ID` INT(255) NOT NULL AUTO_INCREMENT, `DATE` DATE NOT NULL, PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
          $stmt = $con->prepare($query);
          if ($stmt->execute()) {
              echo "<script> window.location.href='manageindex.php?iddb=$iddb';</script>";
              exit; // Add exit to prevent further code execution
          } else {
              echo "Failed to create timing table";
          }
      } else {
          echo "Failed to insert data";
      }
  }
}
?>



?>