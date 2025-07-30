<?php


include('db_connection.php');
include('cart_counter.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT p.name, p.price, c.quantity 
    FROM carts c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$shipping_fee = 50;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    
<header>
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo-container">
                <img src="images/logo.jpeg" alt="Logo" class="logo-img">
                <h1>Wandering Bean Coffee Shop</h1>
            </div>
            
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>

            <ul class="nav-links">
                <li><a href="index.html"><i class="fas fa-home"></i>Home</a></li>
                <li><a href="menu.php"><i class="fas fa-list"></i>Menu</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart (<?= $cart_count ?>)</a></li>
                <li><a href="contact.html"><i class="fas fa-envelope"></i>Contact Us</a></li>
                
            </ul>
        </nav>
    </header>

<h1>Your Cart</h1>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['price'] * $row['quantity'] ?> shs</td>
            </tr>
            <?php $total += $row['price'] * $row['quantity']; ?>
        <?php endwhile; ?>
    </tbody>
</table>

<p>Subtotal: <?= $total ?> shs</p>
<p>Shipping Fee: <?= $shipping_fee ?> shs</p>
<p>Total: <?= $total + $shipping_fee ?> shs</p>

<a href="payment.php">Checkout</a>

</body>
</html>
