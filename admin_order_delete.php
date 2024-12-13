<?php
session_start();
require('db_connection_mysqli.php'); // Ensure the DB connection is working

// Check if the order ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the order from the database
    $query = "DELETE FROM orders WHERE id = $id";
    if (mysqli_query($dbc, $query)) {
        // Successfully deleted the order
        $_SESSION['message'] = "Order deleted successfully!";
    } else {
        // Failed to delete the order
        $_SESSION['message'] = "Error deleting order: " . mysqli_error($dbc);
    }
} else {
    // No ID provided in the URL
    $_SESSION['message'] = "Invalid order ID!";
}

// Redirect back to the order management page
header("Location: admin_orders.php");
exit();
