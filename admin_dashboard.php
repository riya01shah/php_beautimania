<?php
session_start();
include('db_connection_mysqli.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch admin's information
$user_id = intval($_SESSION['user_id']); // Sanitize input
$query = "SELECT first_name, last_name FROM users WHERE id = $user_id";
$result = mysqli_query($dbc, $query);
if ($result && mysqli_num_rows($result) == 1) {
    $admin = mysqli_fetch_assoc($result);
    $adminName = htmlspecialchars($admin['first_name']) . ' ' . htmlspecialchars($admin['last_name']);
} else {
    die('Admin details could not be retrieved.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .nav-link:hover {
            color: #f8f9fa !important;
        }
        h2 {
            color: #007bff;
        }
        .admin-options ul {
            list-style: none;
            padding: 0;
        }
        .admin-options li {
            margin-bottom: 10px;
        }
        .admin-options a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .admin-options a:hover {
            text-decoration: underline;
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
                        <a class="nav-link" href="manage_product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add_product.php">Add Products</a>
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
        <h2>Welcome, <?php echo $adminName; ?>!</h2>
        <p class="mb-4">You are logged in as an admin. Below are some admin-specific options and data:</p>

        <div class="row">
            <div class="col-md-6">
                <div class="admin-options">
                    <h3>Admin Options</h3>
                    <ul>
                        <li><a href="manage_users.php">Manage Users</a></li>
                        <li><a href="manage_product.php">Manage Products</a></li>
                        <li><a href="admin_orders.php">View Orders</a></li>
                       
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="admin-data">
                    <h3>Data Overview</h3>
                    <p>Total Registered Users: <?php
                        $userCountQuery = "SELECT COUNT(*) as total_users FROM users WHERE role='customer'";
                        $userCountResult = mysqli_query($dbc, $userCountQuery);
                        $userCountRow = mysqli_fetch_assoc($userCountResult);
                        echo $userCountRow['total_users'];
                    ?></p>
                    <p>Total Products: <?php
                        $productCountQuery = "SELECT COUNT(*) as total_products FROM products";
                        $productCountResult = mysqli_query($dbc, $productCountQuery);
                        $productCountRow = mysqli_fetch_assoc($productCountResult);
                        echo $productCountRow['total_products'];
                    ?></p>
                    <p>Total Orders: <?php
                        $orderCountQuery = "SELECT COUNT(*) as total_orders FROM orders";
                        $orderCountResult = mysqli_query($dbc, $orderCountQuery);
                        $orderCountRow = mysqli_fetch_assoc($orderCountResult);
                        echo $orderCountRow['total_orders'];
                    ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5" style="background-color: #007bff; color: white; padding: 10px;">
        <p class="mb-0">© 2024 Beautymania Store. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
