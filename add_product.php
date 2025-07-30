<?php
include('db.php');

if (isset($_POST['add_product'])) {
    $productName = trim($_POST['product_name']);
    $productAmount = trim($_POST['product_amount']);
    $stockQuantity = trim($_POST['stock_quantity']);

    // Handle image upload
    $imageName = $_FILES['product_image']['name'];
    $image="uploads/".$imageName; // Ensure 'uploads/' directory exists
    $target = $image; 

    if (!empty($productName) && !empty($productAmount) && is_numeric($stockQuantity) && !empty($image)) {
        // Move image to uploads folder
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target)) {
            $insertQuery = "INSERT INTO products (name, amount, stock_quantity, image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sdis", $productName, $productAmount, $stockQuantity, $image);

            if ($stmt->execute()) {
                $successMessage = "Product added successfully!";
            } else {
                $errorMessage = "Error adding product to the database.";
            }
        } else {
            $errorMessage = "Failed to upload image.";
        }
    } else {
        $errorMessage = "All fields including image are required.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="admin.css" rel="stylesheet">
    <style>
        .form-container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }

        .form-container .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-container .form-group input {
            width: 97%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Product</h2>
        <?php if (!empty($successMessage)): ?>
            <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
        <?php elseif (!empty($errorMessage)): ?>
            <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
    </div>

    <div class="form-group">
        <label for="product_amount">Product Amount (KES):</label>
        <input type="number" id="product_amount" name="product_amount" step="0.01" required>
    </div>

    <div class="form-group">
        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" id="stock_quantity" name="stock_quantity" required>
    </div>

    <div class="form-group">
        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" accept="image/*" required>
    </div>

    <button type="submit" name="add_product">Add Product</button>
</form>


    </div>
</body>
</html>
