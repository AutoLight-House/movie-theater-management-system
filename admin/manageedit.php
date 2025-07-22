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

$id = $_GET['mid'];
$iddb = $_GET['iddb'];
$query = "SELECT * FROM $iddb WHERE id= '$id'";
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
<!-- Display the form for editing the data -->
                        <form method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="form-control-label">Movie Name</label>
                        <input type="text" name="thtname" value="<?php echo $row['Name']; ?>">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie Description</label>
                        <input name="descript"value="<?php echo $row['description']; ?>">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie Youtube Link</label>
                        <input type="text" name="yt" value="<?php echo $row['yt']; ?>">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie Poster</label>
                        <input type="file" name="picture">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie Update</label>
                        <select name="update" value="<?php echo $row['update']; ?>" class="form-control" id="exampleFormControlSelect1">
                        <option>released</option>
                        <option>soon</option>
                        <option>top</option>
                         <option>released top</option>
                        <option>soon top</option>
    </select>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie IMDB Review Rating</label>
                        <input type="txt" value="<?php echo $row['imdb']; ?>" name="imdb">
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Movie Rating</label>
                        <input type="txt"  value="<?php echo $row['rating']; ?>" name="rating">
                      </div>
                      <div class="form-group">       
                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                      </div>
                    </form>
</form>







    
</body>
</html>



<?php

if (isset($_POST['submit'])) {
    $name = $_POST['thtname'];
    $des = $_POST['descript'];
    $yt = $_POST['yt'];
    $update = $_POST['update'];
    $imdb = $_POST['imdb'];
    $rating = $_POST['rating'];

    // Check if a file was uploaded
    $pic = '';
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        // generate a unique filename for the uploaded picture by appending a timestamp to the original filename
        $timestamp = time();
        $pic = 'uploads/' . $timestamp . '_' . $_FILES['picture']['name'];
        
        // check if a file with the same name already exists
        while (file_exists($pic)) {
            $timestamp++;
            $pic = 'uploads/' . $timestamp . '_' . $_FILES['picture']['name'];
        }
        
        // move the uploaded file to the unique filename
        move_uploaded_file($_FILES['picture']['tmp_name'], $pic);
    } else {
        // If no file was uploaded, use the existing picture path
        $query = "SELECT `picture` FROM `$iddb` WHERE `ID` = :id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $pic = $row['picture'];
    }
    
// Update the data in the database
$query = "UPDATE `$iddb` SET `Name` = :name, `description` = :des, `yt` = :yt, `picture` = :pic, `update` = :update, `imdb` = :imdb, `rating` = :rating WHERE `ID` = :id";
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':des', $des);
$stmt->bindParam(':yt', $yt);
$stmt->bindParam(':pic', $pic);
$stmt->bindParam(':update', $update);
$stmt->bindParam(':imdb', $imdb);
$stmt->bindParam(':rating', $rating);


    if ($stmt->execute()) {
        echo"<script> window.location.href='manageindex.php?iddb=$iddb';</script>";
    } else {
        echo "failed";
    }
}
?>
