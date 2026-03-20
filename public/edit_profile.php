<?php
session_start();

// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once '../includes/db.php';
require_once '../classes/Service.php';

// IF NOT LOGGED IN, REDIRECT TO LOGIN PAGE
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// CHECK WEATHER WAS SUBMITED
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'] ?? '';
    $new_password = password_hash($_POST['password'], 
                                    PASSWORD_DEFAULT);

    // EMAIL ISNOT EDITABLE
    $email = $_SESSION['email']; 

    // UPDATE DB WITH NEW USER DATA 
    $stmt = $pdo->prepare("UPDATE users SET username = ?, 
                            password = ? WHERE email = ?");
    $stmt->execute([$new_username, $new_password, $email]);

    // UPDATE SESSION
    $_SESSION['username'] = $new_username;
    $message = "Profile updated successfully.";
}
?>
<!-- HTML________________________________________________________________________________________________________ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SCRIPT FOR HIDDING PASSWORD -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const toggleButton = document.getElementById("togglePassword");
            const eyeIcon = document.getElementById("eyeIcon");

            toggleButton.addEventListener("click", function () {
                const isHidden = passwordInput.type === "password";
                passwordInput.type = isHidden ? "text" : "password";

                // CHANGE ICON
                eyeIcon.classList.toggle("fa-eye");
                eyeIcon.classList.toggle("fa-eye-slash");
                
                // CHANGE HINT
            toggleButton.title = isHidden ? "Hide password" : "Show password";
            });
        });

    </script>
    <title>Dashboard - La Magie d’Éclair</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- WELLCOME -->
        <h1>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Here you can manage your account, view your orders, and more.</p>
        <!-- ALLERT -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"> <?php echo $message; ?> </div>
        <?php endif; ?>
        <!-- PROFILE CARD -->
        <div class="card mt-4">
            <div class="card-header">Your Profile</div>
            <div class="card-body">
                <form method="POST">
                    <!-- USERNAME -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                    </div>
                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email (not editable)</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" disabled>
                    </div>
                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Show password temporarily">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <!-- BACK BUTTON -->
                    <a href="../services.php" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
</body>
</html>
