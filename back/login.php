<?php

include('db_connection.php');

session_start();
require_once 'db_connection.php'; // Replace with your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                header("Location: index.html");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "User not found.";
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
    <title>Login - Wandering Bean</title>
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

        .login-container {
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
        form{
            padding: 10px;
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
            padding-bottom: 5px;
        }

        button {
            width: 100%;
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
    <div class="login-container">
        <div class="form-wrapper">
            <h1>Login</h1>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                <br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="login-btn">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Create One</a></p>
        </div>
    </div>
</body>
</html>
