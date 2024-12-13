<?php
require('db_connection_mysqli.php');  // Ensure your database connection file is correct

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    $query = "SELECT * FROM products WHERE id = $productId LIMIT 1";
    $result = mysqli_query($dbc, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid product ID']);
}
?>
