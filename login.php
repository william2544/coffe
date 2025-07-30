

<?php
session_start();
include('db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Login process
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user data
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php");  // Redirect to homepage after successful login
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sub.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-container">
            <div class="form-box login-box">
                <h2>Login</h2>
                <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
                <form method="POST" action="login.php">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login" class="btn">Login</button>
                </form>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>

    <!-- Account Creation Success Alert -->
    <?php if (isset($_SESSION['account_created']) && $_SESSION['account_created'] === true) { ?>
        <script>
            alert('Account created successfully! Please login.');
        </script>
        <?php
        unset($_SESSION['account_created']);  // Unset session variable after alert
        ?>
    <?php } ?>
</body>
</html>
