
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us - La Magie d’Éclair</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/main_srcture.css">
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/about.css">
        <link rel="stylesheet" href="css/service.css">
        <link rel="stylesheet" href="css/contact.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    <body class="background1" style="padding-top: 60px;">
    <!-- NAVIGATION BAR_______________________________________________________________________________________________ -->
        <nav class="navbar navbar-expand-lg navbar-light color fixed-top">
            <div class="container-fluid">
				<!-- BURGER-MENU-BUTTON --------------------------------------------------------------------------------->
    			<button
					style=" border: none; box-shadow: none;"
					class="navbar-toggler d-lg-none nav-bar-btn-color"
					type="button"
					data-bs-toggle="collapse"
					data-bs-target="#navbarNav"
					>
  					<span style="font-size: 1.5rem;">☰</span>
				</button>
                <!-- LIST OF BTNS TO PAGES ------------------------------------------------------------------------------>                       
				<div class="collapse navbar-collapse header-bs justify-content-center text-center" id="navbarNav">
					<ul class="navbar-nav" style="color: #2b2b2b;">
                        <!-- 4 MAIN PAGES ------------------------------------------------------------------------------->
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.php" class="active">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="services.php">Services</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="contact.php">Contact</a>
						</li>
                        <!-- LOGIN/LOGOUT ------------------------------------------------------------------------------>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="public/logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="public/login.html">Log in</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="public/register.html">Sign up</a>
                            </li>
                            
                        <?php endif; ?>
                        <!-- DARK MODE -------------------------------------------------------------------------------->
						<li class="nav-item">
							<button id="theme-toggle" class="nav-link bg-transparent border-0">Dark Mode</button>
						</li>
                        
					</ul>
				</div>
            </div>
        </nav>





        <!-- MAIN CONTENT______________________________________________________________________________________________________ -->
        <div class="wrapper">
            <main>
                <div style="text-align: center;">
					<!-- DESCRIPTION-------------------------------------------------------------------------------------- -->
                    <p class="text">Our mission is to bring joy through taste!<br>
						We create not just éclairs, but true emotions that fill the day with warmth and delight.<br>
						Natural ingredients, original recipes, and a flawless balance of flavors – all of this makes each éclair special.<br>
						From classic vanilla to bold berry and chocolate experiments – we are constantly evolving to surprise you.<br>
						And behind this magic stands a team of people who put not only their skill but also their love for their craft<br> into every dessert.
                    </p>
                    <br>
					<!-- STAFF-------------------------------------------------------------------------------------------- -->
                    <div class="circle">
                        <div class="photo">
                            <img src="images/ALEXANDER.jpg" alt="Фото 1" class="circle-img">
                            <p class="caption">ALEXANDER</p>
                            <p class="O">BACKING MASTER</p>
                        </div>
                        <div class="photo">
                            <img src="images/ANNA.jpg" alt="Фото 2" class="circle-img">
                            <p class="caption">ANNA</p>
                            <p class="O">FOUNDER AND CHIEF PASTY CHIEF</p>
                        </div>
                        <div class="photo">
                            <img src="images/KATERYNA.jpg" alt="Фото 3" class="circle-img">
                            <p class="caption">KATERYNA</p>
                            <p class="O">dessert designer</p>
                        </div>
                    </div>
				</div>
				<!-- LINE ---------------------------------------------------------------------------------------------------->
				<div class="center-line">
				<hr class="line">
				</div>
				<!-- INTRDUTION TO HISTORY------------------------------------------------------------------------------------>
				<p class="text">
				How did it all begin?
				We have always dreamed of creating unique French éclairs. At first, it was just a love for baking, then came experiments <br>with recipes, and today La Magie d’Éclair is true pastry magic!
				</p>
				<!-- HISTORY LINE -------------------------------------------------------------------------------------------->
				<div class="timeline">
                    <div class="event">
                        <span>LITTLE BAKERY IN GIVERNY<br><br></span>
                        <div class="dot"></div>
                        <span>2017</span>
                    </div>
                    <div class="event">
                        <span>OPEN BAKERY IN PARIS<br><br></span>
                        <div class="dot"></div>
                        <span>2021</span>
                    </div>
                    <div class="event">
                        <span>THE BIGGEST CHAIN OF <br>ECLAIR BAKERY IN FRANCE</span>
                        <div class="dot"></div>
                        <span>2025</span>
                    </div>
                </div>
            </main>
			<!-- FOOTER______________________________________________________________________________________________________ -->
            <footer>
              <p>© <span id="year"></span> La Magie d’Éclair – All Rights Reserved.</p>
            </footer>
        </div>
		<!-- JS CONNECTION -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="js/main.js"></script>
		<!-- CURRENT YEAR-->
        <script>
          document.addEventListener("DOMContentLoaded", function () {
            const year = new Date().getFullYear();
            document.getElementById("year").textContent = year;
          });
        </script>
    </body>
</html>