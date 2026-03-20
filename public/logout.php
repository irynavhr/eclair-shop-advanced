<?php
session_start();
// DEL ALL DATA IN SESSION____________________
session_unset();
// DEL SESSION________________________________
session_destroy();
// DEL COOKIE_________________________________
setcookie('username', '', time() - 3600, '/');
$currentPage = 'logout';
include 'index.php';
// DIRRECT TO HOME PAGE_______________________
header("Location: ../index.php");
exit();
