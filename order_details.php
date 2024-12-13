<?php
require('db_connection_mysqli.php'); // Include your database connection file

// Start the session to access user info
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view order details.";
    exit;
}

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "Invalid order ID.";
    exit;
}

$orderId = intval($_GET['order_id']);  // Sanitize order ID input
$userId = $_SESSION['user_id'];  // Get the logged-in user's ID

// Fetch the order to ensure it belongs to the logged-in user
$orderQuery = "SELECT * FROM orders WHERE id = '$orderId' AND user_id = '$userId'";
$orderResult = mysqli_query($dbc, $orderQuery);

if (mysqli_num_rows($orderResult) == 0) {
    echo "Order not found or you do not have permission to view this order.";
    exit;
}

// Fetch order details
$order = mysqli_fetch_assoc($orderResult);

// Fetch order items
$itemsQuery = "SELECT * FROM order_items WHERE order_id = '$orderId'";
$itemsResult = mysqli_query($dbc, $itemsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details - Order #<?php echo htmlspecialchars($orderId); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/order.css">
</head>
<?php include('header.php'); ?>
<main class="main-body">

    <div class="container mt-5">
        <h2>Order Details - Order #<?php echo htmlspecialchars($orderId); ?></h2>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($order['date']); ?></p>
        <p><strong>Total:</strong> $<?php echo htmlspecialchars(number_format($order['total'], 2)); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>

        <h4 class="mt-4">Items in this Order:</h4>
        <?php if (mysqli_num_rows($itemsResult) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($itemsResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
        
        <a href="order_history.php" class="btn btn-primary mt-3 pink mb25">Back to Order History</a>
    </div>
    <?php include('footer.php'); ?>
