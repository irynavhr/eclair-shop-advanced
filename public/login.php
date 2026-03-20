<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once '../includes/db.php';

// CHECK WEARTHER FORM WAS SUBMITED_____________________________________________________________
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // STORE INPUT DATA FROM USER
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // IF USERNAME OR PASSWORD NOT RECIEVED__________________________________________________
    if (empty($username) || empty($password)) {
        echo "Both fields are required!";
        exit();
    }

    // SQL REQUEST_______________________________________________________________________________
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // CHECK PASSWORD____________________________________________________________________________
    if ($user && password_verify($password, $user['password'])) {
        // SAVE USER INFO IN SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        // STORE COOKIE
        setcookie('username', $user['username'], time() + (86400 * 30), "/"); // запам'ятати ім'я користувача на 30 днів
        setcookie('last_visit', time(), time() + (86400 * 30), "/"); // запам'ятати час останнього візиту
        // DIRECT TO HOME PAGE
        header("Location: ../index.php");
        exit();
        // IF WRONG 
    } else {
        echo "Invalid username or password!";
    }
}
