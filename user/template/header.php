<header class="header">
			<div class="container">
				<div class="header-area">
					<div class="logo">
						<a href="index-2.html"><img src="assets/img/logo.png" alt="logo" /></a>
					</div>
					<div class="header-right">
						<form action="#">
						</form>
						<ul>
							<li><a href="#">Welcome <?php echo $fullName ?></a></li>
							<li> Your Selected Location is <strong><?php echo $thted ?> </strong><button onclick="showPopup1()"> Change Location</button></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
					<div class="menu-area">
						<div class="responsive-menu"></div>
					    <div class="mainmenu">
                            <ul id="primary-menu">
                                <li><a class="active" href="index.php?thtid=<?php echo $thted?>">Home</a></li>
                                <li><a class="active" href="ticket.php?thtid=<?php echo $thted?>">Get Tickets</a></li>
                                <li><a class="active" href="mybook.php?thtid=<?php echo $thted?>">My Bookings</a></li>
                              
                            </ul>
					    </div>
					</div>
				</div>
			</div>
		</header>