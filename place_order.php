<?php
require('db_connection_mysqli.php');
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to place an order.']);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and decode the JSON input
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);  // Decode JSON to associative array

    // Validate required fields
    if (!isset($input['name'], $input['address'], $input['city'], $input['zip'], $input['total'], $input['items'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    // Sanitize input data
    $userId = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($dbc, $input['name']);
    $address = mysqli_real_escape_string($dbc, $input['address']);
    $city = mysqli_real_escape_string($dbc, $input['city']);
    $zip = mysqli_real_escape_string($dbc, $input['zip']);
    $total = mysqli_real_escape_string($dbc, $input['total']);
    $date = date('Y-m-d H:i:s');

    // Insert order into the database
    $query = "INSERT INTO orders (user_id, name, address, city, zip, total, date, status) 
              VALUES ('$userId', '$name', '$address', '$city', '$zip', '$total', '$date', 'Pending')";

    if (mysqli_query($dbc, $query)) {
        $orderId = mysqli_insert_id($dbc);
        echo json_encode(['success' => true, 'orderId' => $orderId]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($dbc)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
