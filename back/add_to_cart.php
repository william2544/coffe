<?php

include('db_connection.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// Check if the product is already in the cart
$stmt = $conn->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if the product is already in the cart
    $stmt = $conn->prepare("UPDATE carts SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
} else {
    // Insert a new record if the product is not in the cart
    $stmt = $conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $user_id, $product_id);
}
$stmt->execute();

header("Location: cart.php");

?>