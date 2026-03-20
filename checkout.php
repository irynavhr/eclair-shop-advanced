<?php
session_start(); // START SESSION TO ACCESS USER DATA AND CART

// IF USER IS NOT LOGGED IN, REDIRECT TO LOGIN PAGE WITH MESSAGE
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please log in or register to complete your order.";
    header("Location: public/login.html");
    exit;
}

// IF CART IS EMPTY, REDIRECT BACK TO SERVICES PAGE
if (empty($_SESSION['cart'])) {
    header("Location: services.php");
    exit;
}

require_once 'includes/db.php'; // CONNECT TO DATABASE

// CALCULATE TOTAL AMOUNT OF ORDER
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['quantity'] * $item['price'];
}

// GET USER DATA FROM SESSION
$userId = $_SESSION['user_id'];
$customerName = $_SESSION['username'] ?? 'Unknown';
$customerEmail = $_SESSION['email'] ?? 'unknown@example.com';

// 1. INSERT NEW ORDER INTO ORDERS TABLE
$stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, customer_email, total, status) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$userId, $customerName, $customerEmail, $total, 'pending']);
$orderId = $pdo->lastInsertId(); // GET LAST INSERTED ORDER ID

// 2. INSERT ORDER ITEMS INTO ORDER_ITEMS TABLE
foreach ($_SESSION['cart'] as $item) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, service_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
}

// 3. CLEAR THE CART AFTER ORDER IS PLACED
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PAGE META, TITLE, BOOTSTRAP, FAVICON, AND CUSTOM CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - La Magie d’Éclair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/telephone.png" type="image/png">
    <link rel="stylesheet" href="css/main_srcture.css" type="text/css">
    <link rel="stylesheet" href="css/contact.css" type="text/css">
    <style>
        /* CENTERED MESSAGE BOX STYLES */
        body {
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-box {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }
    </style>
</head>

<body class="background" style="padding-top: 60px;">
    <!-- THANK YOU MESSAGE AND ACTION BUTTONS -->
    <div class="message-box">
        <h2 class="mb-3">Thank you for choosing us!</h2>
        <p>Your order has been placed successfully.</p>
        <button class="btn btn-primary mt-4" onclick="redirectOrders()">Go to my orders</button>
        <button class="btn btn-primary mt-4" onclick="redirectBack()">Back</button>
    </div>

    <script>
        // REDIRECT TO MY ORDERS PAGE
        function redirectOrders() {
            window.location.href = "my_orders.php";
        }
        // REDIRECT BACK TO SERVICES PAGE
        function redirectBack() {
            window.location.href = "services.php";
        }
    </script>
</body>

</html>
