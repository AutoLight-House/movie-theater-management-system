

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

  // Fetch the user's ID from the database
  $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $userId = $user['id'];

  // Fetch the user's name from the database
  $stmt = $pdo->prepare("SELECT fname, lname FROM users WHERE id = ?");
  $stmt->execute([$userId]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $fullName = $user['fname'] . ' ' . $user['lname'];
} else {
  // User is not logged in
  // Handle the case where the user is not logged in
}


$thted = $_GET['thtid'];
$iddb = $_GET['thtid'];

?>
<!DOCTYPE HTML>
<html lang="zxx">
	
<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Moviepoint - Online Movie,Vedio and TV Show HTML Template</title>
		<!-- Favicon Icon -->
		<link rel="icon" type="image/png" href="assets/img/favcion.png" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="all" />
		<!-- Slick nav CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/slicknav.min.css" media="all" />
		<!-- Iconfont CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/icofont.css" media="all" />
		<!-- Owl carousel CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.css">
		<!-- Popup CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/magnific-popup.css">
		<!-- Main style CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all" />
		<!-- Responsive CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="all" />
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
    /* Style for the popup box */
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      width: 300px;
      padding: 20px;
      border: 1px solid black;
	  z-index: 9999; /* Set the z-index to a high value */
    }
  </style>
	</head>
	<body onload="showPopup()">
		<!-- Page loader -->
	    <div id="preloader"></div>
		<!-- header section start -->

		<div id="popupBox" class="popup">
  <h2>Select Location</h2>
  <form action="index.php" method="get">
    <select name="thtid" id="locationSelect">

      <?php
      $res = $pdo->query("SELECT * FROM movie_theatres");
      while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $theatre_name = $row['theatres'];
        echo "<option value='$theatre_name'>$theatre_name</option>";
      }
      ?>

    </select>
    <br><br>
    <button onclick="submitPopup()" type="submit">Submit</button>
  </form>
</div>










</div>
<?php include('./template/header.php') ?>
<div class="container">
    <div class="py-5 text-center">
       

</div>
    <div class="row">
        <div class="col-md-3 order-md-2 mb-4">
            

        </div>
        <div class=" .container-fluid col-md-12 col-lg-12 text-center order-md-1" method="POST">
            <h4 class="mb-3">My bookings</h4>

            <table>
<thead>
<th>
<tr>
    <td >Booking ID</td>
    <td>Location</td>
    <td>Movie</td>
    <td>DATE</td>
    <td>TIME</td>
    <td>Regular Tickets</td>
    <td>Kids Tickets</td>
    <td>Class</td>
</tr>
</th>
<tbody>
<?php
$res = $pdo->query("SELECT * FROM bookings WHERE uid = $userId");
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
        <td><?php echo $row['BookingID'] ?></td>
        <td><?php echo $row['location'] ?></td>
        <?php
        $mid = $row['mid'];
        $res2 = $pdo->query("SELECT * FROM $thted WHERE ID = $mid");
        while ($row1 = $res2->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <td><?php echo $row1['Name'] ?></td>
            <?php
        }
        ?>
        
        <td><?php echo $row['DATE'] ?></td>
        <td><?php echo $row['TIME'] ?></td>

        <td><?php echo $row['Rticket'] ?></td>
        <td><?php echo $row['Kticket'] ?></td>
        <td><?php echo ($row['kelass'] == 3000) ? 'Silver' : (($row['kelass'] == 6000) ? 'Gold' : (($row['kelass'] == 9000) ? 'Platinum' : '')) ?></td>
    </tr>
    <?php
}
?>

</tbody>


</thead>




            </table>
        </div>
    </div>

<?php
  $banda = $fullName;
  $bandaid = $userId;
  $jagah = $thted;


?>




		<!-- jquery main JS -->
		<script src="assets/js/jquery.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<!-- Slick nav JS -->
		<script src="assets/js/jquery.slicknav.min.js"></script>
		<!-- owl carousel JS -->
		<script src="assets/js/owl.carousel.min.js"></script>
		<!-- Popup JS -->
		<script src="assets/js/jquery.magnific-popup.min.js"></script>
		<!-- Isotope JS -->
		<script src="assets/js/isotope.pkgd.min.js"></script>
		<!-- main JS -->
		<script src="assets/js/main.js"></script>



	</body>

</html>


