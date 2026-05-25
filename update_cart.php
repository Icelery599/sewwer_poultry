<?php
// update_cart.php & remove_from_cart.php - Cart management
// update_cart.php
require_once 'config/db.php';
if(isset($_POST['index']) && isset($_POST['quantity'])) {
    $index = $_POST['index'];
    $quantity = max(1, (int)$_POST['quantity']);
    if(isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}
header("Location: cart.php");

// remove_from_cart.php
if(isset($_GET['index'])) {
    $index = $_GET['index'];
    if(isset($_SESSION['cart'][$index])) {
        array_splice($_SESSION['cart'], $index, 1);
    }
}
header("Location: cart.php");
?>