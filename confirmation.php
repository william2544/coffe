<?php
// Check for the status parameter in the URL
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'Unknown';

// Message based on the status
if ($status === "Success") {
    $message = "Payment was successful! Thank you for your purchase.";
    $color = "green";
} elseif ($status === "Pending") {
    $message = "Your payment is being processed. Please check your Mpesa app for the STK push.";
    $color = "orange";
} else {
    $message = "Payment failed. Please try again.";
    $color = "red";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .confirmation-container {
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        .confirmation-container h1 {
            color: <?= $color ?>;
            margin-bottom: 20px;
        }
        .confirmation-container p {
            color: #333;
            font-size: 16px;
        }
        .confirmation-container .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .confirmation-container .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1><?= $status ?></h1>
        <p><?= $message ?></p>
        <a href="homepage.php" class="button">Return to Home</a>
    </div>
</body>
</html>
