<?php 
include('db.php');

// Fetch delivery areas
$areaQuery = "SELECT * FROM delivery_areas ORDER BY id ASC";
$areaResults = $conn->query($areaQuery);

// Handle delete action
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $deleteQuery = "DELETE FROM delivery_areas WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: locations.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandering Bean Cafe</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        <h2 style="text-decoration: underline;">Delivery Areas</h2>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            
            <button onclick="document.getElementById('addLocationModal').style.display='block'" class="btn btn-primary"><i class="fas fa-plus"></i>Add Location</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Area Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $areaResults->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['area_name']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this location?')">
                                <button type="submit" name="delete" value="<?= $row['id'] ?>" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding New Location -->
    <div id="addLocationModal" class="modal">
        <div class="modal-content">
            <span onclick="document.getElementById('addLocationModal').style.display='none'" class="close">&times;</span>
            <h2>Add New Location</h2>
            <form method="POST" action="add_location.php">
                <label for="area_name">Area Name:</label>
                <input type="text" id="area_name" name="area_name" required>
                <button type="submit" class="btn btn-primary">Add Location</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Admin Portal. All rights reserved.</p>
    </footer>

    <script>
        // Modal functionality
        window.onclick = function(event) {
            var modal = document.getElementById('addLocationModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <style>
        .btn {
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-primary {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #007bff;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</body>
</html>
