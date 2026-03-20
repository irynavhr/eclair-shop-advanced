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

// CHECK WEATHER WE KNOW WICH ECLAIR TO EDIT______________________________________________________________________
if (!isset($_GET['id'])) {
    header('Location: service_dashboard.php');
    exit();
}

// FIND THE ECLAIR_________________________________________________________________________________________________
// SET VARS--------------------------------------------------------------------------------------------------------
$id = $_GET['id'];
$result = $service->readAll();
$currentService = null;
// FIND DATA BY THE ID---------------------------------------------------------------------------------------------
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if ($row['id'] == $id) {
        $currentService = $row;
        break;
    }
}
// IF ECLAIR NOT EXIST
if (!$currentService) {
    echo "Service not found.";
    exit();
}

// FORM WAS SENT__________________________________________________________________________________________________
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $keywords = $_POST['keywords'];
    $category = $_POST['category'];
    $img = $_POST['image'];
    $price = $_POST['price'];


    // UPDATE DASHBOARD
    if ($service->update($id, $title, $desc, $keywords, $category,$img, $price)) {
        header("Location: service_dashboard.php");
        exit();
    } else {
        echo "Error updating the service.";
    }
}
?>

<!-- PAGE STRUCTURE________________________________________________________________________________________________ -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit service</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container py-5">
        <h1>Edit service</h1>
        <form method="POST" action="">
            <!-- ECLAIR NAME -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($currentService['title']) ?>" required>
            </div>
            <!-- ECLAIR DESCRIPTION -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($currentService['description']) ?></textarea>
            </div>
            <!-- KEYWORDS -->
            <div class="mb-3">
                <label for="keywords" class="form-label">Keywords</label>
                <input type="text" class="form-control" id="keywords" name="keywords" value="<?= htmlspecialchars($currentService['keywords']) ?>" required>
            </div>

            <!-- CATEGORY -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?= htmlspecialchars($currentService['category']) ?>" required>
            </div>
            <!-- IMG -->
            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($currentService['image']) ?>" required>
            </div>
            <!-- preview -->
            <div class="mb-3">
                <label>Current image preview:</label><br>
                <img src="<?= htmlspecialchars($currentService['image']) ?>" width="200" alt="Current Image">
            </div>
            <!-- PRICE -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (€)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($currentService['price']) ?>" required>
            </div>
            <!-- UPDATE BUTTON -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <!-- BACK BUTTON -->
        <a href="service_dashboard.php" class="btn btn-secondary mt-3">Back</a>
    </body>
</html>