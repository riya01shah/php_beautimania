<?php
require('db_connection_mysqli.php');

// Initialize variables
$message = '';
$orderId = 0;

// Fetch the order ID
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $orderId = intval($_POST['order_id']);
    } else {
        die('Invalid order ID.');
    }
} elseif (isset($_GET['id'])) {
    $orderId = intval($_GET['id']);
} else {
    die('Invalid order ID.');
}

// Fetch order details
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, 'i', $orderId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    die('Order not found.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validStatuses = ['Pending', 'Completed', 'Cancelled'];
    $status = mysqli_real_escape_string($dbc, $_POST['status']);

    if (in_array($status, $validStatuses)) {
        $updateQuery = "UPDATE orders SET status = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($dbc, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'si', $status, $orderId);

        if (mysqli_stmt_execute($updateStmt)) {
            // Redirect to admin_orders.php after successful update
            header("Location: admin_orders.php");
            exit;
        } else {
            $message = '<div class="alert alert-danger">Error updating status: ' . mysqli_error($dbc) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Invalid status selected.</div>';
    }
}
?>
