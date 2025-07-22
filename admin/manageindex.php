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
  


$iddb = $_GET['iddb'];


include('./config.php');
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
    <link rel="shortcut icon" href="./img/favicon.ico">
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
            <h2 class="h5 no-margin-bottom">Management</h2>
          </div>
        </div>
        <!-- Breadcrumb-->
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="theatreindex.php">Theatres</a></li>
            <li class="breadcrumb-item active">          <?php     echo"$iddb" ?>            </li>
          </ul>
        </div>
        <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="block">
                  <div class="title"><strong>Manage Movies</strong></div>
                  <div class="table-responsive"> 
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Youtube Link</th>
        <th>Picture path</th>
        <th>Update</th>
        <th>IMDB</th>
        <th>Rating</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
</thead>
<tbody>


<?php




$res = $pdo ->query("SELECT * FROM $iddb");
while($row = $res->fetch(PDO::FETCH_ASSOC))
{
    ?>




<tr>

<td><?php echo $row['ID']?></td>
<td><a href="./timingsindex.php?iddb=<?php echo $iddb?>&mid=<?php echo $row['ID']?>&nama=<?php echo $row['Name']?>"><?php echo $row['Name']?></a></td>
<td><?php echo $row['description']?></td>
<td><?php echo $row['yt']?></td>
<td><?php echo $row['picture']?></td>
<td><?php echo $row['update']?></td>
<td><?php echo $row['imdb']?></td>
<td><?php echo $row['rating']?></td>
<td><a href="manageedit.php?iddb=<?php  echo $iddb?>&id=<?php echo $row['ID'] ?>&mid=<?php echo $row['ID']?>&nama=<?php echo $namas?>"> Edit</a></td>
<td><a href="managedelete.php?id=<?php echo $row['ID']?>&iddb=<?php echo $iddb?>&mid=<?php echo $row['ID']?>">Delete</a></td>



</tr>

<?php





}
?>
                      </tbody>
                    </table>
                    <h2><a href="managecreate.php?iddb=<?php echo$iddb ?>">Add</a></h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
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






