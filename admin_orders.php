<?php
session_start(); // START SESSION TO ACCESS USER AND ROLE
require_once 'includes/db.php'; // CONNECT TO DATABASE

// CHECK IF USER IS ADMIN, IF NOT REDIRECT TO HOMEPAGE
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// IF FORM IS SUBMITTED TO UPDATE ORDER STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = (int)$_POST['order_id'];
    $status = $_POST['status'];
    // UPDATE ORDER STATUS IN DATABASE
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $orderId]);
    $_SESSION['message'] = "Status updated successfully.";
    header("Location: admin_orders.php");
    exit;
}

// GET ALL ORDERS FROM DATABASE
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PAGE META, TITLE AND BOOTSTRAP CSS -->
    <meta charset="UTF-8">
    <title>All Orders (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* SIMPLE PAGE STYLING */
        body {
            padding: 30px;
            background-color: #f7f7f7;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- PAGE HEADER AND BACK LINK -->
        <h2 class="mb-4">All Orders</h2>
        <a href="services.php" class="btn btn-dark mb-3">&larr; Back to Services</a>

        <!-- SHOW SUCCESS MESSAGE IF EXISTS -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- LOOP THROUGH ALL ORDERS -->
        <?php foreach ($orders as $order): ?>

            <!-- GET LIST OF PRODUCTS FOR CURRENT ORDER -->
            <?php
            $orderId = $order['id'];
            $stmtItems = $pdo->prepare("
                SELECT s.title AS product_name, oi.quantity, oi.price
                FROM order_items oi
                JOIN services s ON s.id = oi.service_id
                WHERE oi.order_id = ?
            ");
            $stmtItems->execute([$orderId]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="card mb-3">
                <div class="card-body">
                    <!-- ORDER BASIC INFO -->
                    <h5 class="card-title">Order #<?= $order['id'] ?></h5>
                    <p class="card-text">
                        <strong>Date:</strong> <?= $order['created_at'] ?><br>
                        <strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?><br>
                        <strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?><br>
                        <strong>Total:</strong> <?= number_format($order['total'], 2) ?> ₴
                    </p>

                    <!-- FORM TO UPDATE ORDER STATUS -->
                    <form method="POST" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <label class="me-2">Status:</label>
                        <select name="status" class="form-select w-auto">
                            <?php foreach (["pending", "processing", "delivered"] as $status): ?>
                                <option value="<?= $status ?>" <?= ($order['status'] === $status ? 'selected' : '') ?>>
                                    <?= ucfirst($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                    </form>

                    <!-- LIST OF ITEMS IN THIS ORDER -->
                    <?php if (!empty($items)): ?>
                        <ul class="mt-3">
                            <?php foreach ($items as $item): ?>
                                <li>
                                    <?= htmlspecialchars($item['product_name']) ?> (x<?= $item['quantity'] ?>)
                                    — <?= number_format($item['price'], 2) ?> ₴ each
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
