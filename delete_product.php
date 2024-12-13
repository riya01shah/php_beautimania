<?php
session_start();
include('db_connection_mysqli.php');

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details to get the image before deleting
    $query = "SELECT image FROM products WHERE id = $id";
    $result = mysqli_query($dbc, $query);

    // Check if the product exists
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
        $image = $product['image'];
        
        // Delete the product from the database
        $query = "DELETE FROM products WHERE id = $id";
        if (mysqli_query($dbc, $query)) {
            // If image exists and is not empty, delete the image file
            if (!empty($image)) {
                $image_path = "images/" . $image;
                if (file_exists($image_path)) {
                    unlink($image_path); // Delete the image from the server
                }
            }

            $_SESSION['message'] = "Product deleted successfully!";
            header("Location: manage_product.php");
            exit();
        } else {
            $_SESSION['message'] = "Error deleting product: " . mysqli_error($dbc);
        }
    } else {
        $_SESSION['message'] = "Product not found!";
    }
} else {
    $_SESSION['message'] = "Invalid product ID!";
}

header("Location: manage_product.php");
exit();
