<?php

include('db.php');
session_start();


if (isset($_SESSION['user_id'])) {
    // Check if the welcome message has been shown already
    if (!isset($_SESSION['welcome_message_shown'])) {
        // Show the welcome message in a JavaScript alert
        echo "<script>alert('Welcome back, " . $_SESSION['user_name'] . "!');</script>";

        // Set the session variable to indicate the message has been shown
        $_SESSION['welcome_message_shown'] = true;
    }
} else {
    echo "<script>alert(Please log in to access the site.);</script>";
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


</head>
<body>
    <div class="sidebar">
        <h2>Wandering Bean Cafe</h2>
        <a href="admin_home.php"><i class="fas fa-home"></i> Home</a>
        <a href="products.php"><i class="fas fa-cogs"></i> Products</a>
        <a href="transactions.php"><i class="fas fa-file-invoice-dollar"></i> Transactions</a>
        <a href="orders.php"><i class="fas fa-box"></i> Orders</a>
        <a href="locations.php"><i class="fas fa-map-marker-alt"></i>Delivery Areas</a>
        <a href="manage_deliveries.php"><i class="fas fa-map-marker-alt"></i>Delivery drivers</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <h1 style="font-style:italic; margin-top:20px; font-weight:700; margin-left:40px; text-decoration:none;"> Welcome To The Admin's Dashboard</h1>
         <!-- cards -->
    
         <div class="card-container">
         <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="products.php">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-primary border-primary">
                                        <i class="fas fa-cogs"></i>
                                    </span>
                                    <div class="dash-count">
											<h3>
											<?php
												$sql = "SELECT * FROM products";
												$query = mysqli_query($conn, $sql);
												$num = mysqli_num_rows($query);
												echo $num;
											?>
											</h3>
										</div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Products</h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="transactions.php">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-success">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                    <div class="dash-count">
											<h3>
												<?php
												$sql = "SELECT * FROM transactions";
												$query = mysqli_query($conn, $sql);
												$num = mysqli_num_rows($query);
												echo $num;
												?>
											</h3>
										</div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Transactions</h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                       <a href="orders.php">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-danger border-danger">
                                        <i class="fas fa-box"> </i>
                                    </span>
                                    <div class="dash-count">
											<h3>
											<?php
												$sql = "SELECT * FROM transactions";
												$query = mysqli_query($conn, $sql);
												$num = mysqli_num_rows($query);
												echo $num;
												?>
											</h3>
										</div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Orders</h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-sm-6 col-12">
                      <a href="transactions.php">
                        <div class="card">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon text-warning border-warning">
                                        <i class="fas fa-money-bill"></i>
                                    </span>
                                    <div class="dash-count">
											<h3>
												<?php

													$sql = "SELECT SUM(amount) FROM transactions";
													$query = mysqli_query($conn,$sql);
													$res = mysqli_fetch_assoc($query);

													do {
														$total = $res['SUM(amount)'];
														$res =mysqli_fetch_assoc($query);
													} while ($res);
													 echo "Ksh.".number_format($total)."/=";

												?>
											</h3>
										</div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6 class="text-muted">Revenue Generation</h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
         </div>
           <!-- /cards -->			
    </div>

    
</body>
</html>

