<?php
session_start();
include('db_connection_mysqli.php');

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($dbc, $query);
?>

<?php include('header.php'); ?>
<link rel="stylesheet" href="css/product.css">

<main class="main-body">
    <div class="diffSection" id="contactus_section">
        <b><center><p class="white txt contact-us" style="font-size: 30px;">OUR PRODUCTS</p></center></b>
        
        <div class="product-grid">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <div class="product-details">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">$<?php echo $product['price']; ?></p>
                    <p class="additional-info"><?php echo $product['stock']; ?> in stock</p>
                    
                    <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>
<script src="js/product.js"></script>
