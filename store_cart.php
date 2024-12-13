<?php
session_start();

// Get the cart data from the POST request
$cart = json_decode(file_get_contents('php://input'), true);

// Check if cart data is valid
if (is_array($cart)) {
    // Store the cart data in the session
    $_SESSION['cart'] = $cart;

    // Send a success response
    echo json_encode(['success' => true]);
} else {
    // Send an error response
    echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
}
?>
