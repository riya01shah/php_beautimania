<?php
require('db_connection_mysqli.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/product.css">
</head>
<?php include('header.php'); ?>
<body>
    <main class="main-body">
        <div class="diffSection" id="product_section">
            <b><center><p class="white txt contact-us" style="font-size: 30px;">OUR PRODUCTS</p></center></b>
            
            <div class="product-grid">
                <?php
                // Fetch products from the database
                $query = "SELECT id, name, price, image FROM products";
                $result = mysqli_query($dbc, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="product-card">
                            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height: 200px; object-fit: cover;">
                           
                            <div class="product-details">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                                <a href="product_details.php?id=<?php echo $row['id']; ?>" class="add-to-cart">View Details</a>
                                <button class="btn btn-success" onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['image']; ?>')">Add to Cart</button>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No products available.</p>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
<?php include('footer.php'); ?>

<script src="js/product.js"></script>

<script>
// Function to add product to cart
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Check if the item already exists in the cart
    const existingProductIndex = cart.findIndex(product => product.id === id);

    if (existingProductIndex > -1) {
        // If item exists, increase the quantity
        cart[existingProductIndex].quantity += 1;
    } else {
        // Add new item to cart
        cart.push({
            id: id,
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
    }

    // Save the updated cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Product added to cart!');
}
</script>
