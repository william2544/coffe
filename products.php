<?php
include('db.php');

// Fetch products
$productQuery = "SELECT * FROM products ORDER BY id ASC";
$productResults = $conn->query($productQuery);

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $productId = $_POST['product_id'];
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        header("Location: products.php"); // Refresh the page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandering Bean Cafe</title>
    <link href="admin.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .content {
            padding: 20px;
        }

        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table thead tr {
            background-color: #007BFF;
            text-align: left;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn.remove {
            background-color: #FF0000;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .add-product-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #007bff;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            gap:10px;
        }

        .add-product-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Wandering Bean Cafe</h2>
        <a href="admin_home.php"><i class="fas fa-home"></i> Home</a>
        <a href="products.php"><i class="fas fa-cogs"></i> Products</a>
        <a href="transactions.php"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
        <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
        <a href="locations.php"><i class="fas fa-map-marker-alt"></i> Delivery Areas</a>
        <a href="manage_deliveries.php"><i class="fas fa-bicycle"></i>Delivery drivers</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <h1>Products</h1>

        <!-- Add Product Button -->
        <a href="add_product.php" class="add-product-btn"><i class="fas fa-plus"></i> Add Product</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount (KES)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $productResults->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['amount'], 2) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_product" class="btn remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 Admin Portal. All rights reserved.</p>
    </footer>

</body>
</html>
