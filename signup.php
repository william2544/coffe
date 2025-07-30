
<?php
session_start();
include('db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    // Sign up process
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email already exists!";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();

        $_SESSION['account_created'] = true;  // Set session to show success alert
        header("Location: index.php");  // Redirect to login page after successful registration
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="sub.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-container">
            <div class="form-box signup-box">
                <h2>Sign Up</h2>
                <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
                <form method="POST" action="signup.php">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="signup" class="btn">Sign Up</button>
                </form>
                <p>Already have an account? <a href="index.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
