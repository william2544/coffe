<?php
session_start();
include('db.php');

// Lock values from session
$amount = isset($_SESSION['checkout_total']) ? $_SESSION['checkout_total'] : 0.00;
$product_name = isset($_SESSION['checkout_products']) ? $_SESSION['checkout_products'] : 'Unknown Product';

// Fetch delivery areas
$query = "SELECT * FROM delivery_areas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
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
    .checkout-container {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      padding: 20px;
      text-align: center;
    }
    .checkout-container h2 {
      margin-bottom: 20px;
      color: #333;
      text-decoration: underline;
    }
    .checkout-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .checkout-container select,
    .checkout-container input[type="text"],
    .checkout-container input[type="number"],
    .checkout-container input[type="email"] {
      width: 90%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      margin: auto;
    }
    .checkout-container label {
      font-weight: bold;
      margin-top: 10px;
    }
    .checkout-container input[readonly] {
      background-color: #f5f5f5;
      color: #666;
    }
    .checkout-container button {
      background: #007bff;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .checkout-container button:hover {
      background: #0056b3;
    }
    .error-message {
      color: red;
      font-size: 14px;
    }
    .checkout-container p {
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>

<div class="checkout-container">
  <h2>Checkout</h2>

  <form action="stk_push.php" method="POST" onsubmit="return validateForm()">

    <label for="amount">Amount to Pay:</label>
    <input type="text" id="amount" name="amount" value="<?= $amount ?>" readonly>

    <input type="hidden" name="product_name" value="<?= $product_name ?>">

    <label for="delivery_area">Select Delivery Area:</label>
    <select id="delivery_area" name="delivery_area" required>
      <option value="" disabled selected>Choose your delivery area</option>
      <?php while ($row = $result->fetch_assoc()): ?>
        <option value="<?= $row['area_name'] ?>"><?= $row['area_name'] ?></option>
      <?php endwhile; ?>
    </select>

    <label for="specific_address">Specific Address (Building Name, House Number):</label>
    <input type="text" id="specific_address" name="specific_address" placeholder="Enter your specific address" required>

    <label for="email">Email Address:</label>
    <input type="email" name="email" placeholder="Enter your email address" required>

    <label for="phone">Phone Number:</label>
    <input type="text" name="phone" placeholder="2547XXXXXXXX" pattern="2547[0-9]{8}" required>

    <div id="error-message" class="error-message"></div>

    <button type="submit">Pay Now</button>
  </form>

  <p>Ensure your phone number is correct to receive payment confirmation.</p>
</div>

<script>
  function validateForm() {
    const address = document.getElementById('specific_address').value.trim();
    const errorMessage = document.getElementById('error-message');
    if (address === "") {
      errorMessage.textContent = "Please enter a specific address.";
      return false;
    }
    errorMessage.textContent = "";
    return true;
  }
</script>

</body>
</html>
