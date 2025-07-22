

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
		<div class="buy-ticket">
			<div class="container">
				<div class="buy-ticket-area">
					<a href="#"><i class="icofont icofont-close"></i></a>
					<div class="row">
						<div class="col-lg-8">
							<div class="buy-ticket-box">
								<h4>Buy Tickets</h4>
								<h5>Seat</h5>
								<h6>Screen</h6>
								<div class="ticket-box-table">
									<table class="ticket-table-seat">
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
									</table>
									<table>
										<tr>
											<td>1</td>
										</tr>
										<tr>
											<td>2</td>
										</tr>
										<tr>
											<td>3</td>
										</tr>
										<tr>
											<td>4</td>
										</tr>
										<tr>
											<td>5</td>
										</tr>
									</table>
									<table class="ticket-table-seat">
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td class="active">1</td>
											<td class="active">1</td>
											<td class="active">1</td>
											<td class="active">1</td>
											<td class="active">1</td>
											<td class="active">1</td>
											<td class="active">1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
									</table>
									<table>
										<tr>
											<td>1</td>
										</tr>
										<tr>
											<td>2</td>
										</tr>
										<tr>
											<td>3</td>
										</tr>
										<tr>
											<td>4</td>
										</tr>
										<tr>
											<td>5</td>
										</tr>
									</table>
									<table class="ticket-table-seat">
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
										<tr>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
											<td>1</td>
										</tr>
									</table>
								</div>
								<div class="ticket-box-available">
									<input type="checkbox" />
									<span>Available</span>
									<input type="checkbox" checked />
									<span>Unavailable</span>
									<input type="checkbox" />
									<span>Selected</span>
								</div>
								<a href="#" class="theme-btn">previous</a>
								<a href="#" class="theme-btn">Next</a>
							</div>
						</div>
						<div class="col-lg-3 offset-lg-1">
							<div class="buy-ticket-box mtr-30">
								<h4>Your Information</h4>
								<ul>
									<li>
										<p>Location</p>
										<span>HB Cinema Box Corner</span>
									</li>
									<li>
										<p>TIME</p>
										<span>2018.07.09   20:40</span>
									</li>
									<li>
										<p>Movie name</p>
										<span>Home Alone</span>
									</li>
									<li>
										<p>Ticket number</p>
										<span>2 Adults, 2 Children, 2 Seniors</span>
									</li>
									<li>
										<p>Price</p>
										<span>89$</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- header section end -->
		<!-- hero area start -->
		<section class="hero-area" id="home">
			<div class="container">
				<div class="hero-area-slider">
					<div class="row hero-area-slide">
						<div class="col-lg-6 col-md-5">
							<div class="hero-area-content">
								<img src="assets/img/john.jpg" alt="about" />
							</div>
						</div>
						<div class="col-lg-6 col-md-7">
							<div class="hero-area-content pr-50">
								<h2>John Wick: Chapter 4</h2>
							<div class="review">
	  									<p>IMDB Review Rating 10</p>
                                
                                    <p>Rating: R (Some Language|Pervasive Strong Violence)</p>
                                </div>
								<p>
                                John Wick uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe and forces that turn old friends into foes.
                                </p>
							
								<div class="slide-trailor">
									<h3><a href="https://www.youtube.com/watch?v=qEVUtrk8_B4" class="popup-youtube">Watch Trailer </a></h3>
                                    
									
								</div>
							</div>
						</div>
					</div>
					<div class="row hero-area-slide">
						<div class="col-lg-6 col-md-5">
							<div class="hero-area-content">
								<img src="assets/img/video/int.jpg" alt="about" />
							</div>
						</div>
						<div class="col-lg-6 col-md-7">
							<div class="hero-area-content pr-50">
								<h2>Interstellar</h2>
								<div class="review">
                                    <div>
									<p>IMDB Review Rating 10</p>
    <p>PG-13 (Some Intense Perilous Action|Brief Strong Language)</p>                                    
</div>
								</div>
								<p>
                                When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.
                                </p>

							
								<div class="slide-trailor">
									<h3><a href="https://www.youtube.com/watch?v=zSWdZVtXT7E" class="popup-youtube">Watch Trailer </a></h3>
                                    
								</div>
							</div>
						</div>
					</div>
					<div class="row hero-area-slide">
						<div class="col-lg-6 col-md-5">
							<div class="hero-area-content">
								<img src="assets/img/video/tom.jpg" alt="about" />
							</div>
						</div>
						<div class="col-lg-6 col-md-7">
							<div class="hero-area-content pr-50">
								<h2>TOMORROWLAND</h2>
								<p>IMDB Review Rating 10</p>
                                <p>PG (Sci-Fi Action Peril|Language|Sci-Fi Action Violence|Thematic Elements)</p>
								</div>
								<p>
                                Bound by a shared destiny, a teen bursting with scientific curiosity and a former boy-genius inventor embark on a mission to unearth the secrets of a place somewhere in time and space that exists in their collective memory.        
                            </p>
                            <div class="slide-trailor">
									<h3><a href="https://www.youtube.com/watch?v=lNzukD8pS_s" class="popup-youtube">Watch Trailer </a></h3>
                                    
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="hero-area-thumb">
					<div class="thumb-prev">
						<div class="row hero-area-slide">
							<div class="col-lg-6">
								<div class="hero-area-content">
									<img src="assets/img/slide3.png" alt="about" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="hero-area-content pr-50">
									<h2>Last Avatar</h2>
									<div class="review">
										<div class="author-review">
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
										</div>
										<h4>180k voters</h4>
									</div>
									<p>She is a devil princess from the demon world. She grew up sheltered by her parents and doesn't really know how to be evil or any of the common actions,   She is unable to cry due to Keita's accidental first wish, despite needed for him to wish...</p>
									<h3>Cast:</h3>
									<div class="slide-cast">
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast1.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast2.html" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast3.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast4.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast5.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast6.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast7.png" alt="about" />
										</div>
										<div class="single-slide-cast text-center">
											5+
										</div>
									</div>
									<div class="slide-trailor">
										<h3>Watch Trailer</h3>
										<a class="theme-btn theme-btn2" href="#"><i class="icofont icofont-play"></i> Tickets</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="thumb-next">
						<div class="row hero-area-slide">
							<div class="col-lg-6">
								<div class="hero-area-content">
									<img src="assets/img/slide1.png" alt="about" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="hero-area-content pr-50">
									<h2>The Deer God</h2>
									<div class="review">
										<div class="author-review">
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
											<i class="icofont icofont-star"></i>
										</div>
										<h4>180k voters</h4>
									</div>
									<p>She is a devil princess from the demon world. She grew up sheltered by her parents and doesn't really know how to be evil or any of the common actions,   She is unable to cry due to Keita's accidental first wish, despite needed for him to wish...</p>
									<h3>Cast:</h3>
									<div class="slide-cast">
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast1.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast2.html" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast3.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast4.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast5.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast6.png" alt="about" />
										</div>
										<div class="single-slide-cast">
											<img src="assets/img/cast/cast7.png" alt="about" />
										</div>
										<div class="single-slide-cast text-center">
											5+
										</div>
									</div>
									<div class="slide-trailor">
										<h3>Watch Trailer</h3>
										<a class="theme-btn theme-btn2" href="#"><i class="icofont icofont-play"></i> Tickets</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!-- hero area end -->
		<!-- portfolio section start -->
		<section class="portfolio-area pt-60">
			<div class="container">
				<div class="row flexbox-center">
					<div class="col-lg-6 text-center text-lg-left">
					    <div class="section-title">
							<h1><i class="icofont icofont-movie"></i> Spotlight This Month</h1>
						</div>
					</div>
					<div class="col-lg-6 text-center text-lg-right">
					    <div class="portfolio-menu">
							<ul>
								<li data-filter="*" class="active">Latest</li>
								<li data-filter=".soon">Comming Soon</li>
								<li data-filter=".top">Top Rated</li>
								<li data-filter=".released">Recently Released</li>
							</ul>
						</div>
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-lg-12">
						<div class="row portfolio-item">
						<?php

if (isset($_GET['thtid'])) {
	// Handle the form submission here
	$selected_theatre_id = $_GET['thtid'];

	$thtid = $_GET['thtid'];
	$res = $pdo->query("SELECT * FROM $thtid");
	while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
	  $movie_id = $row['ID'];
	  $movie_name = $row['Name'];
	  $movie_descrip = $row['description'];
	  $movie_yt = $row['yt'];
	  $movie_pic = $row['picture'];
	  $movie_update = $row['update'];
	  $movie_imdb = $row['imdb'];
	  $movie_rating = $row['rating'];
	  echo"
	  
	  
	  


	  <div class='col-md-4 col-sm-6 $movie_update'>
	  <div class='single-portfolio'>
		  <div class='single-portfolio-img'>
			  <img src='../admin/$movie_pic' alt='portfolio' />
			  <a href='$movie_yt' class='popup-youtube'>
				  <i class='icofont icofont-ui-play'></i>
			  </a>
		  </div>
		  <div class='portfolio-content'>
			  <h2>$movie_name</h2>
			  <p>$movie_descrip </p>
			  <div class='review'>
				  <div class='author-review'>
					  <p>IMDB Review Rating: $movie_imdb </p>
					  <br>
					  <p>Rating: $movie_rating</p>
				  </div>

			  </div>
		  </div>
	  </div>
  </div>
</div>
";
	}
  }



?>



     




							
					</div>

				</div>
			</div>
		</section><!-- portfolio section end -->
		<!-- video section start -->
		<section class="video ptb-90">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
					    <div class="section-title pb-20">
							<h1><i class="icofont icofont-film"></i> Trailers & Videos</h1>
						</div>
					</div>
				</div>
				<hr />
				<div class="row">
                    <div class="col-md-9">
						<div class="video-area">
							<img src="assets/img/video/john.png" alt="video" />
							<a href="https://www.youtube.com/watch?v=qEVUtrk8_B4" class="popup-youtube">
								<i class="icofont icofont-ui-play"></i>
							</a>
							<div class="video-text">
								<h2>John Wick: Chapter 4</h2>
							
							</div>
						</div>
                    </div>
                    <div class="col-md-3">
						<div class="row">
							<div class="col-md-12 col-sm-6">
								<div class="video-area">
									<img src="assets/img/video/int.jpg" alt="video" />
									<a href="https://www.youtube.com/watch?v=zSWdZVtXT7E" class="popup-youtube">
										<i class="icofont icofont-ui-play"></i>
									</a>
								</div>
							</div>
							<div class="col-md-12 col-sm-6">
								<div class="video-area">
									<img src="assets/img/video/tom.jpg" alt="video" />
									<a href="https://www.youtube.com/watch?v=lNzukD8pS_s" class="popup-youtube">
										<i class="icofont icofont-ui-play"></i>
									</a>
								</div>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</section><!-- video section end -->
<?php include('./template/footer.php') ?>
<?php
// Check if the form is submitted
if (isset($_GET['thtid'])) {
  // Handle the form submission here
  $selected_theatre_id = $_GET['thtid'];
  // Add JavaScript code to hide the popup
  echo "<script>
    window.addEventListener('DOMContentLoaded', function() {
      var popup = document.getElementById('popupBox');
      popup.style.display = 'none';
    });
  </script>";
}
?>

<script>
  // Function to show the popup box
  function showPopup() {
    var popup = document.getElementById("popupBox");
    var urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has('thtid')) {
      popup.style.display = "block";
    }
  }
</script>
<script>
  // Function to show the popup box
  function showPopup1() {
    var popup = document.getElementById("popupBox");
    popup.style.display = "block";
  }
</script>


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