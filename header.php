<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautimania</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        <img class="banner" src="img/banner.jpg" alt="Beautimania Banner">
        <div class="banner-quote-wrap">
            <h1>Elevate Your Beauty Experience</h1>
        </div>
    </header>
    <div class="navigation-body">
        <div class="nav-img-wrp">
            <img class="nav-logo" src="img/logo.png" width="230" height="230" alt="Beautimania Logo">
        </div>
        <nav>
            <ul>
                <li><a href="home.php">HOME</a></li>
                <li><a href="product_listing.php">PRODUCTS</a></li>
                <li><a href="order_history.php">ORDER</a></li>
                <li><a href="cart.php">CART</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">LOGOUT</a></li>
                <?php else: ?>
                    <li><a href="login.php">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
