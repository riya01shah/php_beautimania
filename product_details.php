<?php
session_start();
require('db_connection_mysqli.php');

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
        $price = number_format($row['price'], 2);
        $image = htmlspecialchars($row['image']);
        $stock = $row['stock'];
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    header("Location: product_listing.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/product.css"> <!-- Custom CSS -->
    <style>
        p.text-muted {
            color: white !important;
        }
        .btn {
            background-color: #f19898 !important
        }
        </style>
</head>
<?php include('header.php'); ?> <!-- Include Header -->
<body>
    <main class="main-body">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="images/<?php echo $image; ?>" class="img-fluid" alt="<?php echo $name; ?>">
                </div>
                <div class="col-md-6">
                    <h2><?php echo $name; ?></h2>
                    <p class="text-muted"><?php echo $description; ?></p>
                    <h4 class="price">Price: $<?php echo $price; ?></h4>
                    <p class="additional-info">Stock: <?php echo $stock > 0 ? $stock . " available" : "Out of stock"; ?></p>
                    
                    <!-- Add to Wishlist Button -->
                    <?php if ($stock > 0): ?> <!-- Only show the button if the product is in stock -->
                       
                    <?php else: ?>
                        <button class="btn btn-outline-secondary" disabled>Out of Stock</button>
                    <?php endif; ?>

                    <a href="product_listing.php" class="btn btn-secondary mt-3">Back to Listing</a>
                </div>
            </div>
        </div>
    </main>
</body>
<?php include('footer.php'); ?> <!-- Include Footer -->
</html>
