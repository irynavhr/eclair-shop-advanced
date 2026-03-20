<?php
session_start();
// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once 'includes/db.php';
require_once 'classes/Service.php';

// CREATE NEW OBJECT SERVICE
$service = new Service($pdo);
// get categories
$categories = $service->getCategories();
// GET SEARCH INPUT
$keyword = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'all';
// CHECK WEATHER KEYWORD NOT EMPTY  & SEARCH
if (!empty($keyword)) {
    $services = $service->search($keyword);
} elseif ($category !== 'all') {
    $services = $service->filterByCategory($category);
} else {
    $services = $service->readAll();
}
?>
<!-- PAGE STRUCTURE_____________________________________________________________________________________________________ -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Services - La Magie d’Éclair</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/main_srcture.css">
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/about.css">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/service.css">
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
                            <a style="font-weight: normal;" class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a style="font-weight: normal;" class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a style="font-weight: normal;" class="nav-link" href="services.php" class="active">Services</a>
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
                        <!-- EDIT ECLAIRS ASSORTIMENT BUTTON --- FOR ADMIN ONLY ------------------------------------------->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li><a class="nav-link" href="service_dashboard.php">Edit Eclairs</a></li>
                        <?php endif; ?>
                        <!-- EDIT PROFILE -->
                        <?php if (isset($_SESSION['username'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="public/edit_profile.php">Edit Profile</a>
                            </li>
                        <?php endif; ?>
                        <!-- ALL ORDERS -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin_orders.php">All Orders</a>
                            </li>
                        <!-- MY ORDERS -->
                        <?php elseif (isset($_SESSION['username'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="my_orders.php">My Orders</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </nav>
        <div class="wrapper">
            <main>
                <!-- FIRST SECTION -->
                <div class="img">
                    <img src="images/f.png" alt="Éclairs">
                    <h1>OUR ÉCLAIRS ARE MORE THAN JUST DESSERTS!</h1>
                </div>
                <!-- CATAGORY DROP DOWN -->
                <div class="container mt-5" id="services-section">
                    <div class="row mb-4 justify-content-center">
                        <div class="col-md-6">
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6" id="services-section">
                                    <select id="category-filter" class="form-select">
                                        <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>All Categories</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                                            <?= ucfirst(htmlspecialchars($cat)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SEARCH_________________________________________________________________________________________ -->
                <form method="GET" action="services.php" class="mb-4 mt-5">
                    <div class="row justify-content-center">
                        <!-- FIELD -->
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Search for a flavor..." value="<?= htmlspecialchars($keyword) ?>">
                        </div>
                        <!-- BUTTON -->
                        <div class="col-md-2 mt-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                        
                    </div>
                </form>

                 <!-- BUTTON VIEW ADDED ORDERS______________________________________________________________________-->
            <div class="floating-btn">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">
                    View Added Orders
                </button>
            </div> 
                <!-- ECLAIR GRID____________________________________________________________________________________ -->
                <div class="container py-4">
                    <div class="row g-4">
                        <?php while ($row = $services->fetch(PDO::FETCH_ASSOC)): ?>
                            <!-- ECLAIR CARD -------------------------------------------------------------------------->
                            <div class="col-12 col-md-4">
                                <div class="card h-100 text-center border-0 shadow-sm">
                                    <!-- IMG -->
                                    <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>">
                                    <div class="card-body">
                                        <!-- TITLE -->
                                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                        <!-- DESCRIPTION -->
                                        <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>

                                         <!-- ÉCLAIR PRICE -->
                                        <p class="card-text fw-bold">Price: <?= htmlspecialchars($row['price']) ?> ₴</p>

                                        <!-- ORDER FORM-->
                                        <form action="add_to_cart.php" method="GET" class="d-flex flex-column align-items-center gap-2">
                                        <!--HIDDEN DATA-->
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <input type="hidden" name="name" value="<?= htmlspecialchars($row['title']) ?>">
                                        <input type="hidden" name="price" value="<?= htmlspecialchars($row['price']) ?>">

                                        <!-- Quantity input with arrows -->
                                        <input type="number" name="quantity" value="1" min="1" class="form-control w-50 text-center" style="width: 70px;">

                                        <button type="submit" class="btn btn-outline-success btn-sm">Add to Order</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <!-- IF NOTHING FOUND -->
                        <?php if ($services->rowCount() == 0): ?>
                            <div class="alert alert-warning text-center">
                                Oops! Nothing found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
            <!-- FOTER_________________________________________________________________________________ -->
            <footer>
                <p class="n">© 2025 La Magie d’Éclair – All Rights Reserved.</p>
            </footer>
        </div>
        <!-- JS_________________________________________________________________________________________ -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="js/main.js"></script>
        <!-- PAGE SCROLL AFTER SEARCH -->
        <script>
            window.addEventListener("DOMContentLoaded", function () {
                const url = new URL(window.location.href);
                const hasCategory = url.searchParams.get("category");
                const hasSearch = url.searchParams.get("search");

                if (hasCategory || hasSearch) {
                    window.scrollTo({
                        top: 420,
                        behavior: "smooth"
                    });
                }
            });
        </script>
        <!-- FILTER -->
        <script>
            document.getElementById("category-filter").addEventListener("change", function() {
                const selected = this.value;
                document.querySelector("input[name='search']").value = '';
                window.location.href = `services.php?category=${selected}`;
            });
        </script>
        
        <script>
            // HINTS FOR INPUT
            function showHint(str) {
                if (str.length == 0) {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "search_service.php?q=" + encodeURIComponent(str), true);
                    xmlhttp.send();
                }
            }
        </script>

<!-- ORDER SUMMARY MODAL -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Your Order Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <?php
                        $total = 0;
                        ?>
                        <ul class="list-group">
                            <?php foreach ($_SESSION['cart'] as $item):
                                $subtotal = $item['quantity'] * $item['price'];
                                $total += $subtotal;
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <!-- Left: Name + Subtotal -->
                                    <div>
                                        <?= htmlspecialchars($item['name']) ?>
                                        <span class="badge bg-success rounded-pill ms-2">
                                            <?= number_format($subtotal, 2) ?> ₴
                                        </span>
                                    </div>
                                    <!-- Right: Quantity×Price + Remove button -->
                                    <div class="d-flex align-items-center">
                                        <small class="me-2">
                                            <?= $item['quantity'] ?> × <?= number_format($item['price'], 2) ?> ₴
                                        </small>
                                        <a href="remove_from_cart.php?id=<?= $item['id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Remove this item?');">
                                            &times;
                                        </a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Total -->
                        <div class="mt-3 text-end fw-bold">
                            Total: <?= number_format($total, 2) ?> ₴
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            No items in your order yet.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="cart.php" class="btn btn-outline-primary">Go to Cart</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
</html>