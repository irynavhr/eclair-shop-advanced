<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home - La Magie d’Éclair</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/main_srcture.css">
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/about.css">
        <link rel="stylesheet" href="css/service.css">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
    <!-- NAVIGATION BAR_______________________________________________________________________________________________ -->
        <nav class="navbar navbar-expand-lg navbar-light color fixed-top">
            <div class="container-fluid">
                <!-- BURGER-MENU-BUTTON --------------------------------------------------------------------------------->
                <button
                    style="border: none; box-shadow: none;"
                    class="navbar-toggler d-lg-none nav-bar-btn-color"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                    <span style="font-size: 1.5rem;">☰</span>
                </button>
                <!-- LIST OF BTNS TO PAGES ------------------------------------------------------------------------------>
                <div class="collapse navbar-collapse header-bs justify-content-center text-center" id="navbarNav">
                    <ul class="navbar-nav" style="color: #2b2b2b;">
                        <!-- 4 MAIN PAGES ------------------------------------------------------------------------------->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php" class="active">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
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
                                <a class="nav-link" href="public/logout.php" class="<?= ($currentPage == 'logout') ? 'active' : '' ?>">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="public/login.html" class="<?= ($currentPage == 'login') ? 'active' : '' ?>">Log in</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="public/register.html" class="<?= ($currentPage == 'signup') ? 'active' : '' ?>">Sign up</a>
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
                <!-- BANNER -------------------------------------------------------------------------------------------------->
                <section id="home" class="full-screen d-flex align-items-center text-center" style="background-image: url('images/mainPhoto.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-white">
                                <p class="lead">La Lune French Bistro</p>
                                <h1 class="display-4 fw-bold">LA MAGIE D’ÉCLAIR</h1>
                                <a href="#" class="btn btn-light btn-lg mt-3">Dine with Us</a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- WELCOME ------------------------------------------------------------------------------------------------>
                <section class="welcome-section" style="background-color: #d18955; text-align: center; padding: 30px 0;">
                    <div class="container" style="display: flex; justify-content: center;">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<div>";
                            echo "<h2 style='color: white;'>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
                            if (isset($_COOKIE['last_visit'])) {
                                $lastVisit = date('d-m-Y H:i:s', $_COOKIE['last_visit']);
                                echo "<p style='color: white;'>Last visit: " . $lastVisit . "</p>";
                            }
                            echo "</div>";
                        } elseif (isset($_COOKIE['username'])) {
                            echo "<div>";
                            echo "<h2 style='color: white;'>Welcome back, " . htmlspecialchars($_COOKIE['username']) . "!</h2>";
                            if (isset($_COOKIE['last_visit'])) {
                                $lastVisit = date('d-m-Y H:i:s', $_COOKIE['last_visit']);
                                echo "<p style='color: white;'>Last visit: " . $lastVisit . "</p>";
                            }
                            echo "</div>";
                        } else {
                            echo "<div>";
                            echo "<h2 style='color: white;'>Welcome, Guest!</h2>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </section>

                <!-- ABOUT ------------------------------------------------------------------------------------------------>
                <section class="about">
                    <div class="about-content">
                        <div class="about-images">
                            <img src="images/1photoFor2slide.jpg" alt="Eclairs on a plate">
                        </div>
                        <div class="about-images">
                            <img src="images/2photoFor2slide.jpg" alt="French pastries">
                        </div>
                        <div class="about-text">
                            <h2>A French pleasure</h2>
                            <p>La Magie d’Éclair is a charming bakery where éclairs become magic.
                                We create delicious, fresh éclairs with creamy fillings and delicate toppings.
                                Every bite is a little piece of happiness. Come and taste the magic!
                            </p>
                            <a href="#" class="btnMore">More</a>
                        </div>
                    </div>
                </section>

                <!-- POPULAR FLAVOURS ------------------------------------------------------------------------------------>
                <section class="flavors">
                    <div class="flavors-content">
                        <div class="flavors-text">
                            <h2>FLAVORS OF FRANCE</h2>
                            <p>We use only the finest ingredients:
                                fresh cream, high-quality chocolate,
                                and natural fruits, ensuring that each éclair is perfect.</p>
                        </div>
                        <div class="flavors-images">
                            <div class="flavor-item">
                                <img src="images/chocolate2.jpg" alt="Eclairs on a plate">
                                <h3>PREMIUM CHOCOLATE</h3>
                            </div>

                            <div class="flavor-item">
                                <img src="images/Cream.jpg" alt="Eclairs on a plate">
                                <h3>FINEST CREAM</h3>
                            </div>

                            <div class="flavor-item">
                                <img src="images/Fruits.jpeg" alt="Eclairs on a plate">
                                <h3>RIPE FRUITS</h3>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- WHY OUR CONFECTIONARY ------------------------------------------------------------------------------->
                <section class="why-us-section">
                    <div class="name-section">
                        <h2>WHY US?</h2>
                    </div>
                    <div class="why-us-content-wrapper">
                        <div class="why-us-box">
                            <div class="why-us-icon">●●●</div>
                            <h3>Delicious Éclair Flavors</h3>
                            <p>From classic vanilla to luxurious chocolate and fresh fruits — everyone will find their favorite flavor!</p>
                        </div>
                        <div class="why-us-box">
                            <div class="why-us-icon">●●●</div>
                            <h3>Special Offers</h3>
                            <p>Éclairs for holidays, mini-éclairs for events, custom orders — we create desserts for every special moment.</p>
                        </div>
                        <div class="why-us-box">
                            <div class="why-us-icon">●●●</div>
                            <h3>How We Make Them</h3>
                            <p>Only the finest ingredients, professionalism in every step — our éclairs are the result of craftsmanship and a passion for flavor!</p>
                        </div>
                    </div>
                </section>



                <!-- FOOTER___________________________________________________________________________________________________ -->
                <div class="stylyshed-home-page-footer-container">
                    <div class="footer-img-section">
                        <img src="images/footer_image.jpg" alt="Eclairs">
                    </div>
                    <div class="footer-content-section">
                        <h2>FOLLOW US</h2>
                        <div class="social-links">
                            <a href="#"><i class="fa-brands fa-instagram"></i> @LaMagieDEclair</a>
                            <a href="#"><i class="fa-brands fa-facebook"></i> facebook.com/LaMagieDEclair</a>
                            <a href="#"><i class="fa-brands fa-x-twitter"></i> @LaMagieEclair</a>
                        </div>
                        <div class="privacy-approvance">
                            © 2025 La Magie d’Éclair – All Rights Reserved.
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- GS CONNECTION -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="js/main.js"></script>
    </body>
</html>