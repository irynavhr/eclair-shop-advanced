<?php
// PARAMS FOR CONNECTION TO DB
$host = 'localhost';  
$dbname = 'eclairdb';  
$username = 'iryna';  
$password = 'chocolade';   

try {
    // CONNECTION TO MYSQL WITHOUT DB NAME
   $pdo = new PDO("mysql:host=$host", $username, $password);
    // SET ERROR MODE AS EXEPTIONS
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // CREATE DB IF DOESENT EXIST
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    // CONNECT TO THE DB
    $pdo->exec("USE `$dbname`");

    // CREATE TABLE USERS__________________________________________________________________________________
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) DEFAULT 'user'
    )");

    // CREATE TABLE MESSAGES_______________________________________________________________________________
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // CREATE TABLE SERVICES_______________________________________________________________________________
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        category VARCHAR(100),
        keywords TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // CREATE TABLE CUSTUMER_ORDERS_________________________________________________________________________________
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        customer_name VARCHAR(100),
        customer_email VARCHAR(100),
        total DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status VARCHAR(50) DEFAULT 'pending',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

    // CREATE TABLE ORDER_ITEMS_____________________________________________________________________________________
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    service_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
)");

    // $pdo->exec("ALTER TABLE order_items ADD COLUMN service_id INT;");
    // $pdo->exec("ALTER TABLE orders ADD COLUMN status VARCHAR(50) DEFAULT 'pending';");

    echo "Database and tables created successfully!";
} catch (PDOException $e) {
    // ERROR WITH CONN TO DB
    echo "Database connection error: " . $e->getMessage();
    // die("ERROR: " . $e->getMessage());
}