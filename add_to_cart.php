<?php
session_start(); // START SESSION TO STORE CART

// GET ITEM DETAILS FROM URL PARAMETERS
$id = $_GET['id'];
$name = $_GET['name'];
$price = (float)$_GET['price'];
$quantity = (int)($_GET['quantity'] ?? 1);

// CREATE ITEM ARRAY
$item = [
    'id' => $id,
    'name' => $name,
    'price' => $price,
    'quantity' => $quantity
];

// IF CART DOES NOT EXIST IN SESSION, INITIALIZE AS EMPTY ARRAY
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$found = false;
// CHECK IF ITEM ALREADY EXISTS IN CART
foreach ($_SESSION['cart'] as &$cartItem) {
    if ($cartItem['id'] == $id) {
        // IF FOUND, INCREASE QUANTITY
        $cartItem['quantity'] += $quantity;
        $found = true;
        break;
    }
}
unset($cartItem); // BREAK THE REFERENCE WITH THE LAST ELEMENT

// IF ITEM NOT FOUND, ADD NEW ITEM TO CART
if (!$found) {
    $_SESSION['cart'][] = $item;
}

// SAVE CONFIRMATION MESSAGE TO SESSION
$_SESSION['message'] = "$quantity × \"$name\" added to cart.";

// REDIRECT USER BACK TO SERVICES PAGE
header("Location: services.php");
exit;
