<?php
session_start();
// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once 'includes/db.php';
require_once 'classes/Service.php';

// CHECK WEATHRE USER == ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// CREATE NEW SERVICE OBJECT
$service = new Service($pdo);

// IF BUTTONE DELL WAS PUSHED_______________________________________________________________________________________
if (isset($_GET['delete'])) {
    $service->delete($_GET['delete']);
    header("Location: service_dashboard.php");
    exit();
}
// UPDATE SERVICES AFTER POSSIBLE PREVIOS DELLETION
$services = $service->readAll();
?>

<!-- PAGE STRUCTURE________________________________________________________________________________________________ -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administrator panel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container py-5">
        <!-- TITLE -->
        <h1>Services control panel</h1>
        <!-- BUTTONS -->
        <a href="add_service.php" class="btn btn-success mb-3">Add service</a>
        <a href="services.php" class="btn btn-secondary mb-3">Back to site</a>
        <!-- SERVICES TABLE_______________________________________________________________________________________ -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Keywords</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $services->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['keywords']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><img src="<?= htmlspecialchars($row['image']) ?>" width="100" alt="Image"></td>
                        <td><?= number_format($row['price'], 2) ?> €</td>
                        <td>
                            <a href="edit_service.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="service_dashboard.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this masterpiece?')">Remove</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
</html>