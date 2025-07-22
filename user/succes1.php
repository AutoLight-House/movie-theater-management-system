

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
$stmt = $pdo->prepare("SELECT fname, lname FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$fullName = $user['fname'] . ' ' . $user['lname'];

} else {

}

$thted = $_GET['thtid'];
$iddb = $_GET['thtid'];


$midi = $_GET['midi'];
$datei = $_GET['datei'];
$timeii = $_GET['timeii'];
$kelass = $_GET['kelass'];
$tiki = $_GET['tiki'];
$kidoo = $_GET['kiddo'];
$banda = $_GET['banda'];
$jagah = $_GET['jagah'];

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
       
        <h2>Booking</h2>
</div>
    <div class="row">
        <div class="col-md-3 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your Bookings Selection</span>
            </h4>
            <ul class="list-group mb-3 sticky-top" id="billing-list">
  <li class="list-group-item d-flex justify-content-between lh-condensed" id="regular-tickets-list">
    <div>
      <h6 class="my-0">Regular Tickets</h6>
      <small class="text-muted" id="regular-tickets-description"></small>
    </div>
    <span class="text-muted" id="regular-tickets-cost">$0</span>
  </li>
  <li class="list-group-item d-flex justify-content-between" id="kids-tickets-list-item" style="display: none;">
    <div>
      <h6 class="my-0">Kids' Tickets</h6>
      <small class="text-muted" id="kids-tickets-description"></small>
    </div>
    <span class="text-muted" id="kids-tickets-cost">$0</span>
  </li>
  <li class="list-group-item d-flex justify-content-between">
    <span>Total (USD)</span>
    <strong id="total-cost">$0</strong>
  </li>
</ul>

        </div>
        <div class="col-md-8 order-md-1" method="POST">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" method="POST" novalidate="">
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label name="movieselect"for="country">Movie</label>
                        <select name="selector" onchange="myFunction(this.value)" class="custom-select d-block w-100" id="country" required="">
                        <option name="mid" value="">Select Movie</option>
                        <?php

$res = $pdo ->query("SELECT * FROM $thted");
while($row = $res->fetch(PDO::FETCH_ASSOC))
{
    
    ?>

    <option value="<?php echo $row ['ID']?>"><?php echo $row ['Name']?></option>


<?php





}
?>              

                        </select>
                        <div class="invalid-feedback"> Please select a valid Movie. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state">Date</label>
                        <select class="custom-select d-block w-100" name="datei" id="sdate" required="">
                        <option value="">Select Date</option>

                        </select>
                        <div class="invalid-feedback"> Please provide a valid state. </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="state">Timings</label>
                        <select class="custom-select d-block w-100" id="timeii" required="">


                        </select>
                        <div class="invalid-feedback"> Please provide a valid state. </div>
                    </div>
                   
<div class="col-md-2 mb-3">
  <label for="seat-class">Seat Class</label>
  <select class="custom-select d-block w-100" id="seat-class" onchange="calculateTotal()" required>
    <option value="3000">Silver ($3000)</option>
    <option value="6000">Gold ($6000)</option>
    <option value="9000">Platinum ($9000)</option>
  </select>
  <div class="invalid-feedback">Please provide a valid seat class.</div>
</div>

<div class="col-md-2 mb-3">
  <label for="regular-tickets">Regular Tickets</label>
  <select class="custom-select d-block w-100" id="regular-tickets" onchange="calculateTotal()" required>
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
  </select>
  <div class="invalid-feedback">Please provide a valid number of regular tickets.</div>
</div>

<hr class="mb-4">

<div class="custom-control custom-checkbox">
  <input type="checkbox" class="custom-control-input" id="kids-ticket-checkbox" onchange="toggleKidsTicketInput()">
  <label class="custom-control-label" for="kids-ticket-checkbox">Want to buy kids ticket? 30% Concession(aged between 3 to 12 years)</label>
</div>

<div id="kids-ticket-input" style="display: none;">
  <label for="kids-ticket">Kids Tickets</label>
  <select class="custom-select d-block w-100" id="kids-ticket" onchange="calculateTotal()">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
  </select>
</div>

<hr class="mb-4">

                <hr class="mb-2">
                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3">

                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback"> Name on card is required </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                        <div class="invalid-feedback"> Credit card number is required </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                        <div class="invalid-feedback"> Expiration date required </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                        <div class="invalid-feedback"> Security code required </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Book Now</button>
            </form>
        </div>
    </div>


	</body>

</html>


