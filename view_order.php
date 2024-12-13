<?php
require('db_connection_mysqli.php'); // Ensure database connection

if (isset($_GET['id'])) {
    $orderId = intval($_GET['id']); // Sanitize input
    // Fetch the order details from the database
    $query = "SELECT * FROM orders WHERE id = $orderId";
    $result = mysqli_query($dbc, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        die('Order not found.');
    }
} else {
    die('Invalid order ID.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #f8f9fa !important;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .order-detail p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Beautymania Store</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Order Details</h2>
        <div class="order-detail">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
            <p><strong>ZIP:</strong> <?php echo htmlspecialchars($order['zip']); ?></p>
            <p><strong>Total Amount:</strong> $<?php echo number_format($order['total'], 2); ?></p>
            <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order['date'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        </div>
        <a href="admin_orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5" style="background-color: #007bff; color: white; padding: 10px;">
        <p class="mb-0">© 2024 Beautymania Store. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
