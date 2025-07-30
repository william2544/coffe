<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Check if the welcome message has been shown already
    if (!isset($_SESSION['welcome_message_shown'])) {
        // Show the welcome message in a JavaScript alert
        echo "<script>alert('Welcome, " . $_SESSION['user_name'] . "!');</script>";

        // Set the session variable to indicate the message has been shown
        $_SESSION['welcome_message_shown'] = true;
    }
} else {
    echo "Please log in to access the site.";
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandering Bean Coffee Shop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo-container">
                <img src="images/logo.jpeg" alt="Logo" class="logo-img">
                <h1>Wandering Bean Coffee Shop</h1>
            </div>
            
            

            <ul class="nav-links">
                <li><a href="homepage.php"><i class="fas fa-home"></i>Home</a></li>
                <li><a href="menu.php"><i class="fas fa-list"></i>Menu</a></li>

                <li><a href="cart.php" id="view-cart--button"><i class="fas fa-shopping-cart"></i>Cart <span id="cart-counter">(<?php echo count($cart); ?>)</span></a></li>

                <li><a href="contact.php"><i class="fas fa-envelope"></i>Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                <?php endif; ?>
                
            </ul>
            <!-- Navbar menu toggle button for small screens-->
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
        
        <div class="video-slide">
            <video autoplay muted loop>
                <source src="images/Beige Brown Abstract Modern Coffee Shop.mp4" type="video/mp4">
            </video>
        </div>
        
    </header>

    <section class="specialties">
        <div class="specials">
            <img src="images/s1.jpg" alt="coffee icon">
            <p>Coffee</p>
        </div>
        <div class="specials">
            <img src="images/s6.jpg" alt="tea icon">
            <p>Tea</p>
        </div>
        <div class="specials">
            <img src="images/s7.jpg" alt="milkshake icon">
            <p>Milkshakes</p>
        </div>
        <div class="specials">
            <img src="images/s3.jpg" alt="cake icon">
            <p>Desserts</p>
        </div>
    </section>


    <main class="display">
        <h3>Tang-Tastic Drinks</h3>
        
        <section class="drinks-lineup">
            
            <div class="drink">
                <img src="images/coffee2.jpeg" alt="Coffee" class="drink-img">
                <p>Coffee</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 150</p>
            </div>
            <div class="drink">
                <img src="images/capuccino.jpeg" alt="Cappuccino" class="drink-img">
                <p>Cappuccino</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 300</p>
            </div>
            <div class="drink">
                <img src="images/Iced Mocha.jpeg" alt="Latte" class="drink-img">
                <p>Iced Mocha</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 400</p>
            </div>
            <div class="drink">
                <img src="images/Iced Caramel Latte.jpeg" alt="Tea" class="drink-img">
                <p>Iced Caramel Latte</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 350</p>
            </div>
            <div class="drink">
                <img src="images/Coffee Milkshake.jpeg" alt="Tea" class="drink-img">
                <p>Coffee Milkshake</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 400</p>
            </div>
        </section>
    </main>
    
    <main class="display">
        <h3>To Go With Drinks</h3>
        <section class="drinks-lineup">
            <div class="drink">
                <img src="images/Pineapple  Donuts.jpeg" alt="Coffee" class="drink-img">
                <p>Donuts</p>
                <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 150</p>
            </div>
            <div class="drink">
                <img src="images/Chocolate Tiramisu.jpeg" alt="Chocolate Tiramisu" class="drink-img">
                    <p>Chocolate Tiramisu</p>
                    <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 120</p>
            </div>
            <div class="drink">
                <img src="images/Mocha Ice Cream Cake.jpeg" alt="Mocha Ice Cream Cake" class="drink-img">
                    <p>Mocha Ice Cream Cake</p>
                    <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 250</p>
            </div>
            <div class="drink">
                <img src="images/Strawberry Cheesecake.jpeg" alt="Strawberry Cheesecake" class="drink-img">
                    <p>Strawberry Cheesecake </p>
                    <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 250</p>
            </div>
            <div class="drink">
                <img src="images/Chocolate Peanut Butter Swirl Muffins.jpeg" alt="Chocolate Peanut Butter Swirl Muffins" class="drink-img">
                    <p>Peanut Butter Muffins</p>
                    <p class="bill"> <i class="far fa-money-bill-alt"></i> Kshs. 40</p>
            </div>
            
            
        </section>
        
    </main>

    <p class="direct"> <a href="menu.php"> View More</a></p>
        
    <!-- Footer -->
    <footer>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>Our mission: To brew happiness with every cup.</p>
        <p>&copy; 2024 Wandering Bean Coffee Shop</p>
    </footer>
    
    <script src="script.js"> </script>
    
</body>
</html>
