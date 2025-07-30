<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username or email already exists.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);

                if ($stmt->execute()) {
                    header("Location: login.php?success=1");
                    exit;
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        } else {
            $error = "Passwords do not match.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Wandering Bean</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.signup-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.form-wrapper {
    text-align: center;
}

h1 {
    font-size: 24px;
    color: #333;
    text-decoration: underline;
}

label {
    display: block;
    margin-top: 15px;
    font-size: 14px;
    color: #555;
}

input {
    width: 90%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    padding-bottom: 10px;
}

button {
    width: 80%;
    padding: 10px;
    margin-top: 20px;
    background: #5cb85c;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #4cae4c;
}

.error {
    color: #d9534f;
    font-size: 14px;
    margin-top: 10px;
}

    </style>
</head>
<body>
    <div class="signup-container">
        <div class="form-wrapper">
            <h1>Sign Up</h1>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>

