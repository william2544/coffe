<?php
session_start();
include('db.php');

// Initialize cart if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$alertMessage = "";

// Fetch products from DB
$products = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];

    // Get current stock
    $stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE name = ?");
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && $product['stock_quantity'] > 0) {
        $found = false;

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] == $productName) {
                if ($item['quantity'] < $product['stock_quantity']) {
                    $item['quantity'] += 1;
                    $alertMessage = "$productName quantity increased.";
                } else {
                    $alertMessage = "Only {$product['stock_quantity']} left in stock.";
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $productName,
                'price' => $productPrice,
                'image' => $productImage,
                'quantity' => 1
            ];
            $alertMessage = "$productName added to cart!";
        }
    } else {
        $alertMessage = "$productName is out of stock.";
    }
}

// Handle checkout - reduce stock
if (isset($_GET['checkout']) && $_GET['checkout'] === 'true') {
    foreach ($_SESSION['cart'] as $item) {
        $stmt = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE name = ?");
        $stmt->bind_param("is", $item['quantity'], $item['name']);
        $stmt->execute();
    }
    $_SESSION['cart'] = [];
    header("Location: success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wandering Bean Coffee Shop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php if (!empty($alertMessage)): ?>
<script>
    alert("<?= htmlspecialchars($alertMessage) ?>");
</script>
<?php endif; ?>

<header>
    <nav class="navbar">
        <div class="logo-container">
            <img src="images/logo.jpeg" alt="Logo" class="logo-img">
            <h1>Wandering Bean Coffee Shop</h1>
        </div>
        <ul class="nav-links">
            <li><a href="homepage.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="menu.php"><i class="fas fa-list"></i>Menu</a></li>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart</a></li>
            <li><a href="contact.php"><i class="fas fa-envelope"></i>Contact Us</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            <?php endif; ?>
        </ul>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        </div>
    </nav>
</header>

<div class="menu">
    <div class="drinks">
        <h2>Explore our tasty delights</h2>
        <section class="drinks-lineup">
            <?php foreach ($products as $product): ?>
                <div class="drink">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="drink-img">
                    <p><?= htmlspecialchars($product['name']) ?></p>
                    <p class="bill"><i class="far fa-money-bill-alt"></i> Kshs. <?= number_format($product['amount']) ?></p>
                    <p><strong>In Stock:</strong> <?= $product['stock_quantity'] ?></p>
                    <form method="POST">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="product_price" value="<?= $product['amount'] ?>">
                        <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']) ?>">
                        <button class="add-to-cart" type="submit" name="add_to_cart"
                            <?= $product['stock_quantity'] <= 0 ? 'disabled style="background:gray;"' : '' ?>>
                            <?= $product['stock_quantity'] <= 0 ? 'Out of Stock' : '<i class="fas fa-shopping-cart"></i> Cart' ?>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
</div>

<footer>
    <p>Follow us: Facebook | Instagram | Twitter</p>
    <p>Our mission: To brew happiness with every cup.</p>
    <p>&copy; 2024 Wandering Bean Coffee Shop</p>
</footer>

<script src="script.js"></script>
</body>
</html>
