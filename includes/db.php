<?php
// DB CONNECTION PARAMITERS
$host = 'localhost';  
$dbname = 'eclairdb';  
$username = 'iryna';  
$password = 'chocolade';  

// mysql -u iryna -p -h localhost eclairdb
// echo "CONFIG LOADED";
// CONNECTION TO A DATABASE
try {
    // CONNECTION TO A DATABASE VIA PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // SETTING ERRORE MODE
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    // IF A COONNECTION ERROR OCCURS
    echo "Помилка підключення до бази даних: " . $e->getMessage();
    die(); // END SCRIPT EXECUTION
};

?>
