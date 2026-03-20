<?php
session_start(); // START SESSION TO ACCESS CART

// GET THE ITEM ID FROM QUERY STRING (URL)
$id = isset($_GET['id']) ? $_GET['id'] : null;

// IF ID EXISTS AND CART EXISTS IN SESSION
if ($id !== null && isset($_SESSION['cart'])) {

    // REMOVE ITEM FROM CART BY FILTERING OUT ITEM WITH THIS ID
    $_SESSION['cart'] = array_filter(
        $_SESSION['cart'],
        function ($item) use ($id) {
            // KEEP ALL ITEMS EXCEPT THE ONE WITH MATCHING ID
            return $item['id'] != $id;
        }
    );
}

// REDIRECT BACK TO SERVICES PAGE
header("Location: services.php");
exit;
