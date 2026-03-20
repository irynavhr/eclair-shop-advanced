<?php
session_start(); // START SESSION TO ACCESS USER DATA
require_once 'includes/db.php'; // CONNECT TO DATABASE

if (!isset($_SESSION['user_id'])) {
    // REDIRECT TO LOGIN IF NOT AUTHENTICATED
    header("Location: public/login.html");
    exit;
}

$userId = $_SESSION['user_id'];

// FETCH ALL ORDERS FOR LOGGED-IN USER, MOST RECENT FIRST
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PAGE METADATA AND STYLES -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main_srcture.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/service.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body class="background" style="padding-top: 60px;">
    <!-- NAVBAR: MAIN NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-light color fixed-top">
        <div class="container-fluid">
            <!-- BURGER MENU BUTTON FOR MOBILE NAVIGATION -->
            <button
                style=" border: none; box-shadow: none;"
                class="navbar-toggler d-lg-none nav-bar-btn-color"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span style="font-size: 1.5rem;">☰</span>
            </button>
            <!-- NAVBAR LINKS -->
            <div class="collapse navbar-collapse header-bs justify-content-center text-center" id="navbarNav">
                <ul class="navbar-nav" style="color: #2b2b2b;">
                    <!-- MAIN SITE PAGES -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
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
                    <!-- AUTHENTICATION LINKS -->
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
                    <!-- DARK MODE TOGGLE BUTTON -->
                    <li class="nav-item">
                        <button id="theme-toggle" class="nav-link bg-transparent border-0">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <h2 style="text-align:center; margin-top: 30px;">My Orders</h2>

        <?php if (empty($orders)): ?>
            <!-- MESSAGE IF USER HAS NO ORDERS -->
            <p class="headtext">You have no orders yet.</p>
        <?php else: ?>
            <!-- ORDER LIST: SHOW USER'S ORDERS -->
            <div class="form-container">
                <div class="container mt-4">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($orders as $order): ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <!-- ORDER INFO -->
                                        <h5 class="card-title">Order #<?= $order['id'] ?></h5>
                                        <p class="card-text mb-1"><strong>Date:</strong> <?= $order['created_at'] ?></p>
                                        <p class="card-text mb-2">
                                            <strong>Status:</strong>
                                            <!-- STATUS BADGE COLOR BASED ON STATUS -->
                                            <span class="badge 
                                <?= ($order['status'] ?? 'pending') === 'delivered' ? 'bg-success' : (($order['status'] ?? 'pending') === 'processing' ? 'bg-warning text-dark' :
                                        'bg-secondary') ?>">
                                                <?= ucfirst($order['status'] ?? 'pending') ?>
                                            </span>
                                        </p>
                                        <!-- ORDER ITEMS LIST -->
                                        <h6>Items:</h6>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($pdo->query("
                                            SELECT s.title, oi.quantity FROM order_items oi 
                                            JOIN services s ON s.id = oi.service_id 
                                            WHERE oi.order_id = {$order['id']}
                                            ") as $item): ?>
                                                <li class="list-group-item">
                                                    <?= htmlspecialchars($item['title']) ?> <span class="text-muted">(×<?= $item['quantity'] ?>)</span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>
