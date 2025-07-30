<?php
include('db.php');

// Fetch orders
$orderQuery = "SELECT * FROM transactions  ORDER BY created_at DESC";
$orderResults = $conn->query($orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandering Bean Cafe</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>

    <div class="sidebar">
        <h2>Wandering Bean Cafe</h2>
        <a href="admin_home.php"><i class="fas fa-home"></i> Home</a>
        <a href="products.php"><i class="fas fa-cogs"></i> Products</a>
        <a href="transactions.php"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
        <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
        <a href="locations.php"><i class="fas fa-map-marker-alt"></i>Delivery Areas</a>
        <a href="manage_deliveries.php"><i class="fas fa-bicycle"></i>Delivery drivers</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <h1>Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Amount (KES)</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orderResults->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['Order_id'] ?></td>
                        <td><?= $row['product_name'] ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= number_format($row['amount'], 2) ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['created_at'] ?></td>
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
