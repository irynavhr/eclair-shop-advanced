<?php
session_start();

// Deleting a product__________________________________________________________________________________________
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($removeId) {
        return $item['id'] !== $removeId;
    });
    // Redirects to avoid deletion on page refresh____________________________________________________________
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - La Magie d’Éclair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/telephone.png" type="image/png">
    <link rel="stylesheet" href="css/main_srcture.css" type="text/css">
    <link rel="stylesheet" href="css/contact.css" type="text/css">
</head>

<body class="background" style="padding-top: 60px;">

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
                        <a style="font-weight: normal;" class="nav-link" href="services.php">Services</a>
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
                    <!-- SHOW MESSAGES DASHBOARD BUTTON-->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="public/messages_dashboard.php">Messages</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container mt-5">
        <h2 class="mb-4">Your Order</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <ul class="list-group mb-4">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['quantity'] * $item['price'];
                    $total += $subtotal;
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($item['name']) ?></strong>
                            <br>
                            <?= $item['quantity'] ?> × <?= number_format($item['price'], 2) ?> ₴
                        </div>

                        <!-- HTML with a ‘Remove’ button next to each product -->

                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-success rounded-pill">
                                <?= number_format($subtotal, 2) ?> ₴
                            </span>
                            <a href="cart.php?remove=<?= urlencode($item['id']) ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Remove this item?');">&times;</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mb-4 text-end fw-bold">
                Total: <?= number_format($total, 2) ?> ₴
            </div>

            <div class="text-center d-flex justify-content-center gap-3">
   <a href="services.php" class="btn btn-dark btn-lg">Continue Shopping</a>
    <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
</div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Your cart is empty.
            </div>
        <?php endif; ?>
    </div>
</body>

</html>