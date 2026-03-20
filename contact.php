<?php
session_start();
// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once 'includes/db.php';

$success = "";
$error = "";

// CHECK WEARTHER FORM WAS SUBMITED_____________________________________________________________
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // CHECK WEATHE FIELDS NOT EMPTY___________________________________________________________
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all fields.";
    }
    // CHECK EMAIL_____________________________________________________________________________
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address format.";
    } else {
        try {
            // INSERT INTO DB
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message, created_at) VALUES (:name, :email, :message, NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);

            
            if ($stmt->execute()) {
                $success = "Your message has been sent successfully!";
            } else {
                $error = "Error inserting message.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!-- HTML -->
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
                            <a class="nav-link" href="contact.php" class="active">Contact</a>
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

        <!-- MAIN CONTENT______________________________________________________________________________________________________ -->
        <main>
            <p class="headtext">Please contact us by filling out the form below – we will gladly answer<br> your questions and help with any requests!</p>
            <!-- FORM Bootstrap ----------------------------------------------------------------------------------------------------->
            <form id="contactForm" class="form-container" method="POST" action="contact.php">
                <!-- Name --------------------------------------------------------------------------------------------------------------->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <!-- Email --------------------------------------------------------------------------------------------------------------->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <!-- Повідомлення -------------------------------------------------------------------------------------------------------->
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                </div>
                <!-- ALLERT CONTAINER ------------------------------------------------------------------------------------------------------>
                <div id="alertContainer" class="mt-3"></div>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <!-- BUTTON--------------------------------------------------------------------------------------------  -->
                <button type="submit" class="button">Contact Us</button>
            </form>
        <!-- CONTAKT INFO ------------------------------------------------------------------------------------------------->
            <div class="under">
                <p class="phone">Phone: +33 1 23 45 67 89</p>
                <p class="email">Email: contact@lamagiedeclair.com</p>
                <p class="adress">Address: 123 Rue de Paris, 75001 Paris, France</p>
            </div>
        </main>
        <!-- FOOTER_____________________________________________________________________________________________________________________________ -->
        <footer>
            <p>© 2025 La Magie d’Éclair – All Rights Reserved.</p>
        </footer>
        <!-- JS ------------------------------------------------------------------------------------------------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="js/main.js"></script>
        <script>
            document.getElementById('contactForm').addEventListener('submit', function(event) {
                const nameField = document.getElementById('name');
                const emailField = document.getElementById('email');
                const messageField = document.getElementById('message');
                const alertContainer = document.getElementById('alertContainer');

                const name = nameField.value.trim();
                const email = emailField.value.trim();
                const message = messageField.value.trim();

                // Очищаємо попередні алерти
                alertContainer.innerHTML = '';

                let errorMessage = '';
                console.log("name:", name, "email:", email, "message:", message);

                if (name === '' || email === '' || message === '') {
                    event.preventDefault();
                    errorMessage = 'Please fill in all fields!';
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    event.preventDefault();
                    errorMessage = 'Please enter a valid email address!';
                }

                if (errorMessage !== '') {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.role = 'alert';
                    alertDiv.textContent = errorMessage;
                    alertContainer.appendChild(alertDiv);
                }
            });
        </script>
        <?php if (!empty($success)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('contactForm').reset();
                });
            </script>
        <?php endif; ?>
    </body>

</html>