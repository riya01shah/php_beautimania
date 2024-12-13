<?php
require('db_connection_mysqli.php');
session_start();

// Check if user is logged in (optional)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Assume 0 if not logged in

// Fetch cart items from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Handle POST request to place the order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract shipping information from the form submission
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    $address = mysqli_real_escape_string($dbc, $_POST['address']);
    $city = mysqli_real_escape_string($dbc, $_POST['city']);
    $zip = mysqli_real_escape_string($dbc, $_POST['zip']);
    
    if (empty($name) || empty($address) || empty($city) || empty($zip) || empty($cart)) {
        echo "<script>alert('All fields are required and the cart must have items.');</script>";
    } else {
        // Insert the order into the 'orders' table
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        $query = "INSERT INTO orders (user_id, name, address, city, zip, total, date, status) 
                  VALUES ('$user_id', '$name', '$address', '$city', '$zip', '$totalAmount', NOW(), 'Pending')";
        
        if (mysqli_query($dbc, $query)) {
            // Get the order ID of the newly inserted order
            $order_id = mysqli_insert_id($dbc);

            // Insert order items into the 'order_items' table
            foreach ($cart as $item) {
                $product_name = mysqli_real_escape_string($dbc, $item['name']);
                $price = $item['price'];
                $quantity = $item['quantity'];
                $subtotal = $price * $quantity;

                $item_query = "INSERT INTO order_items (order_id, product_name, price, quantity, subtotal)
                               VALUES ('$order_id', '$product_name', '$price', '$quantity', '$subtotal')";

                mysqli_query($dbc, $item_query);
            }

            // Clear the cart after placing the order
            unset($_SESSION['cart']);
            
            // Redirect to the order confirmation page
            echo "<script>alert('Order placed successfully!'); window.location.href = 'order_history.php';</script>";
        } else {
            echo "<script>alert('Error placing the order. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="main-body">
    <div class="diffSection" id="checkout_section">
        <center><p class="white txt contact-us" style="font-size: 30px;">Checkout</p></center>
        <div class="container mt-5">
            <h3>Order Summary</h3>
            <table class="table" id="checkoutTable">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($cart)) {
                        echo "<tr><td colspan='4' class='text-center'>Your cart is empty.</td></tr>";
                    } else {
                        $totalAmount = 0;
                        foreach ($cart as $item) {
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalAmount += $subtotal;
                            echo "<tr>
                                    <td>{$item['name']}</td>
                                    <td>\${$item['price']}</td>
                                    <td>{$item['quantity']}</td>
                                    <td>\${$subtotal}</td>
                                  </tr>";
                        }
                        echo "<tr>
                                <td colspan='3' class='text-right'><strong>Total:</strong></td>
                                <td><strong>\${$totalAmount}</strong></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="mt-4">
                <h4>Shipping Information</h4>
                <form method="POST" id="checkoutForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">ZIP Code</label>
                        <input type="text" id="zip" name="zip" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Place Order</button>
                </form>
            </div>

        </div>
    </div>
</main>
</body>
</html>
