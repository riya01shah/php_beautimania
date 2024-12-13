<?php
require('db_connection_mysqli.php'); // Ensure the DB connection is working

// Fetch all orders from the database
$query = "SELECT * FROM orders ORDER BY date DESC";
$result = mysqli_query($dbc, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($dbc));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
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
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
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
        <h2>Order Management</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td>$<?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo date('F j, Y, g:i a', strtotime($order['date'])); ?></td>
                        <td>
                            <form action="edit_order_status.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="Pending" <?php if ($order['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Completed" <?php if ($order['status'] === 'Completed') echo 'selected'; ?>>Completed</option>
                                    <option value="Cancelled" <?php if ($order['status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                        <a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">View</a>

                       </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5" style="background-color: #007bff; color: white; padding: 10px;">
        <p class="mb-0">© 2024 Beautymania Store. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>