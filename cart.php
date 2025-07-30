<?php 
session_start();
include('db.php'); // DB connection

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$shippingFee = 0;
$subtotal = 0;

// Remove item if "remove" parameter is set
if (isset($_GET['remove'])) {
    $removeKey = $_GET['remove'];
    unset($cart[$removeKey]);
    $_SESSION['cart'] = $cart;
    header("Location: cart.php");
    exit();
}

// Calculate subtotal
foreach ($cart as $item) {
    if (isset($item['price'], $item['quantity']) && is_numeric($item['price']) && is_numeric($item['quantity'])) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}

$total = $subtotal + $shippingFee;

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    foreach ($cart as $item) {
        $stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE name = ? AND stock_quantity >= ?");
        $stmt->bind_param("isi", $item['quantity'], $item['name'], $item['quantity']);
        $stmt->execute();
    }

    $_SESSION['cart'] = [];
    header("Location: success.php");
    exit();
}

$productNames = array_column($cart, 'name');
$joinedProducts = urlencode(implode(', ', $productNames));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .checkout-button{
            display:block;
            margin:auto;
            width:200px;
            text-decoration:none;
            color: white;
            font-size:18px;
            font-weight:bold;
            border: 1px solid;
            background:brown;
            padding: 7px;
            border-radius:10px;
            text-align:center;
            

        }
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo-container">
            <img src="images/logo.jpeg" alt="Logo" class="logo-img">
            <h1>Wandering Bean Coffee Shop</h1>
        </div>

        <ul class="nav-links">
            <li><a href="homepage.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="menu.php"><i class="fas fa-list"></i>Menu</a></li>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart <span id="cart-counter">(<?= count($cart); ?>)</span></a></li>
            <li><a href="contact.php"><i class="fas fa-envelope"></i>Contact Us</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            <?php endif; ?>
        </ul>

        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>
</header>

<div class="cart">
    <h2>Your Cart</h2>

    <div class="cart-items">
        <?php foreach ($cart as $key => $item): ?>
            <div class="cart-item">
                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="cart-item-image">
                <p class="cart-item-name"><?= $item['name'] ?></p>
                <p class="cart-item-quantity"><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
                <p class="cart-item-price"><strong>Price:</strong> Kshs. <?= $item['price'] ?></p>
                <a href="cart.php?remove=<?= $key ?>" class="remove-item">Remove</a>
            </div>
        <?php endforeach; ?>
    </div>

    <hr style="margin-top: 30px;">
    <div class="cart-summary">
        <p><strong>Subtotal:</strong> Kshs. <?= $subtotal ?></p>
        <p><strong>Shipping Fee:</strong> Kshs. <?= $shippingFee ?></p>
        <p><strong>Total:</strong> Kshs. <?= $total ?></p>

        <?php if (!empty($cart)): ?>
        <form action="checkout.php" method="POST" style="margin-top: 20px;">
    <input type="hidden" name="checkout" value="true">
    <?php 
// Store total and product name in session
$_SESSION['checkout_total'] = $total;
$_SESSION['checkout_products'] = $joinedProducts;
?>
<a href="checkout.php" class="checkout-button">Proceed to Checkout</a>

</form>

        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div>

<footer style="margin-top:230px;">
    <p>Follow us: Facebook | Instagram | Twitter</p>
    <p>Our mission: To brew happiness with every cup.</p>
    <p>&copy; 2024 Wandering Bean Coffee Shop</p>
</footer>

<script src="script.js"></script>
</body>
</html>
