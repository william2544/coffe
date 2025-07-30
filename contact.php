<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

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
    
    </header>


    <section class="contact-grid">
        <div class="contact-details">
            <h2>Get in Touch</h2>
            <p>If you have any questions about our products or need further assistance, reach us on:</p>
            <ul>
                <li><i class="fas fa-phone"></i> <strong>Phone:</strong> +254 790405253</li>
                <li><i class="fas fa-envelope"></i> <strong>Email:</strong> onyangowilliam2002@gmail.com</li>
                <li><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> Thika Town</li>
                <li><i class="fas fa-clock"></i> <strong>Hours:</strong> Mon - Fri: 8 AM - 6 PM</li>
            </ul>
        </div>
        <div class="contact-form">
            <form action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="9385f35d-1dc4-4142-8479-48d4fb83fc59">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-comment-alt"></i>
                    <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <footer style="margin-top:95px;">
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>Our mission: To brew happiness with every cup.</p>
        <p>&copy; 2024 Wandering Bean Coffee Shop</p>
    </footer>

    
    <script src="script.js"></script>
</body>
</html>
