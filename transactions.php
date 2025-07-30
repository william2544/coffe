<?php
include('db.php');

// Fetch transactions
$transactionQuery = "SELECT * FROM transactions ORDER BY created_at DESC";
$transactionResults = $conn->query($transactionQuery);
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
        <h1>Transactions</h1>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount (KES)</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $transactionResults->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['transaction_id'] ?></td>
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


