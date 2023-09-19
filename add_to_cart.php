<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$item_id = $_GET['item_id'];
$_SESSION['cart'][] = $item_id;

header("Location: index.php"); // Redirect back to the main page
