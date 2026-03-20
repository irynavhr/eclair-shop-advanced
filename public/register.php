<?php
session_start();
// CONNECT TO FILE WITH DB CONNECTION - PDO
require_once '../includes/db.php';

// CHECK WEARTHER FORM WAS SUBMITED_____________________________________________________________
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // IF USERNAME OR PASSWORD NOT RECIEVED__________________________________________________
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // PASSWORD ENCRYPTION______________________________________________________________________
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // CHECK WEATHER EMAIL ALREADY EXIST________________________________________________________
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // IF EXIST
    if ($user) {
        echo "This email is already registered!";
        exit();
    }

    $role = 'user';
    // PASTE DATA INTO TABLE___________________________________________________________________
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) 
                           VALUES (:username, :email, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    // STORE USERNAME IN SESSION AND STORE COOKIE
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $user['email'];

    setcookie('username', $username, time() + 3600, "/");

    // DIRECT TO HOME PAGE
    header("Location: ../index.php");
    exit();
}
