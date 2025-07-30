<?php
include('db.php');

// Free delivery persons after 45 minutes
$conn->query("
    UPDATE delivery_persons dp
    JOIN transactions t ON dp.id = t.delivery_person_id
    SET dp.status = 'Available'
    WHERE t.status = 'Pending' 
      AND t.created_at < NOW() - INTERVAL 45 MINUTE
");

// Fetch transactions with delivery details
$sql = "
    SELECT t.*, dp.name AS delivery_name, dp.phone AS delivery_phone
    FROM transactions t
    LEFT JOIN delivery_persons dp ON t.delivery_person_id = dp.id
    ORDER BY t.created_at DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandering Bean Cafe</title>
    <link href="admin.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            width: 220px;
            height: 100%;
            background: blue;
            padding: 20px;
            box-sizing: border-box;
            color: #fff;
        }

        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: blue;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .overdue {
            background: #ffe6e6 !important;
            color: #a00;
            font-weight: bold;
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

    <div class="main-content">
        <h2>Manage Deliveries</h2>

        <table>
            <thead>
                <tr>
                    
                    <th>Product</th>
                    <th>Customer Phone</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Delivery Driver No.</th>
                    <th>Placed At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):
                    $createdAt = strtotime($row['created_at']);
                    $isOverdue = (time() - $createdAt) > (45 * 60); // 45 minutes
                ?>
                <tr class="<?= $isOverdue ? 'overdue' : '' ?>">
                    
                    <td><?= $row['product_name'] ?></td>
                    <td><?= $row['phone_number'] ?></td>
                    
                    <td><?= $row['address'] ?></td>
                    <td>Ksh <?= number_format($row['amount'], 2) ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['delivery_name'] ?? 'Unassigned' ?></td>
                    <td><?= $row['delivery_phone'] ?? '-' ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
