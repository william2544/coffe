<?php

session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("SELECT SUM(p.price * c.quantity) as total FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total'] + 50;

    if ($amount == $total) {
        // Clear cart
        $stmt = $conn->prepare("DELETE FROM carts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        echo "<script>alert('Payment Successful!'); window.location.href='cart.php';</script>";
    } else {
        echo "<script>alert('Please pay the exact amount!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <h1>Payment</h1>
    <form method="POST">
        <label for="amount">Total Amount:  <?= $total ?> shs</label><br>
        <input type="number" id="amount" name="amount" required><br>
        <button type="submit">Pay</button>
    </form>
</body>
</html>
