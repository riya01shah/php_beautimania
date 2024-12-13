<?php
require('db_connection_mysqli.php');
session_start();

// Ensure user is logged in
// if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
//     header("Location: login.php");
//     exit();
// }

$user_id = $_SESSION['id'];
$username = $_SESSION['email'];

// Fetch the latest order for the logged-in user
$query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY date DESC LIMIT 1";
$order_result = mysqli_query($dbc, $query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order = mysqli_fetch_assoc($order_result);
    $order_id = $order['order_id'];
    $totalAmount = $order['total'];
    $order_date = $order['date'];
    $order_status = $order['status'];
} else {
    echo "No recent orders found.";
    exit();
}

// Fetch order items for this order
$items_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
$items_result = mysqli_query($dbc, $items_query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Order Confirmation</h3>
        <p><strong>Thank you for your order, <?php echo htmlspecialchars($username); ?>!</strong></p>
        
        <h4>Order Details</h4>
        <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order_status); ?></p>
        <p><strong>Total Amount:</strong> $<?php echo number_format($totalAmount, 2); ?></p>
        <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order_date)); ?></p>

        <h4 class="mt-4">Products Ordered</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($items_result) > 0) {
                    while ($item = mysqli_fetch_assoc($items_result)) {
                        $subtotal = $item['price'] * $item['quantity'];
                        echo "<tr>
                                <td>" . htmlspecialchars($item['product_name']) . "</td>
                                <td>$" . number_format($item['price'], 2) . "</td>
                                <td>" . htmlspecialchars($item['quantity']) . "</td>
                                <td>$" . number_format($subtotal, 2) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No products found for this order.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="order_history.php" class="btn btn-primary mt-3">View Order History</a>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
    </div>
</body>
</html>
