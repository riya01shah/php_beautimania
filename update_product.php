<?php
session_start();
include('db_connection_mysqli.php');

// Initialize variables and error messages
$name = $description = $price = $stock = $image = "";
$nameErr = $descriptionErr = $priceErr = $stockErr = $imageErr = "";

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details from the database
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($dbc, $query);

    // Check if the product exists
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);

        // Prepopulate the form fields with the existing product data
        $name = $product['name'];
        $description = $product['description'];
        $price = $product['price'];
        $stock = $product['stock'];
        $image = $product['image'];
    } else {
        $_SESSION['message'] = "Product not found!";
        header("Location: manage_products.php");
        exit();
    }
}

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate Product Name
    if (empty($_POST['name'])) {
        $nameErr = "Product Name is required";
    } else {
        $name = mysqli_real_escape_string($dbc, $_POST['name']);
    }

    // Validate Description
    if (empty($_POST['description'])) {
        $descriptionErr = "Description is required";
    } else {
        $description = mysqli_real_escape_string($dbc, $_POST['description']);
    }

    // Validate Price (must be a positive number)
    if (empty($_POST['price'])) {
        $priceErr = "Price is required";
    } else {
        $price = mysqli_real_escape_string($dbc, $_POST['price']);
        if (!is_numeric($price) || $price <= 0) {
            $priceErr = "Price must be a positive number";
        }
    }

    // Validate Stock Quantity (must be a positive integer)
    if (empty($_POST['stock'])) {
        $stockErr = "Stock quantity is required";
    } else {
        $stock = mysqli_real_escape_string($dbc, $_POST['stock']);
        if (!is_numeric($stock) || $stock < 1) {
            $stockErr = "Stock must be a positive integer";
        }
    }

    // Handle Image Upload
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "images/" . $image;

        // Allow certain file formats (e.g., jpg, png, gif)
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if (!in_array($image_extension, $allowed_extensions)) {
            $imageErr = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Move the uploaded file to the images directory
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Image uploaded successfully
            } else {
                $imageErr = "Failed to upload the image.";
            }
        }
    }

    // If no errors, update the product in the database
    if (empty($nameErr) && empty($descriptionErr) && empty($priceErr) && empty($stockErr) && empty($imageErr)) {
        // Prepare the query to update the product
        $query = "UPDATE products 
                  SET name = '$name', description = '$description', price = '$price', stock = '$stock', image = '$image' 
                  WHERE id = $id";

        if (mysqli_query($dbc, $query)) {
            $_SESSION['message'] = "Product updated successfully!";
            header("Location: manage_product.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($dbc);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            width: 600px;
            margin-top: 50px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }
        .text-danger {
            font-size: 14px;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: #fff;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Beautymania Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add_product.php">Add Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="admin_orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Update Product</h2>
        <form action="update_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                <span class="text-danger"><?php echo $nameErr; ?></span>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $description; ?></textarea>
                <span class="text-danger"><?php echo $descriptionErr; ?></span>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
                <span class="text-danger"><?php echo $priceErr; ?></span>
            </div>

            <!-- Stock Quantity -->
            <div class="mb-3">
                <label for="stock" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>" required>
                <span class="text-danger"><?php echo $stockErr; ?></span>
            </div>

            <!-- Product Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <span class="text-danger"><?php echo $imageErr; ?></span>
                <p>Current image: <img src="images/<?php echo $image; ?>" alt="Product Image" width="100"></p>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Product</button>
        </form>
    </div>

    <footer class="text-center text-lg-start mt-5" style="background-color: #007bff; color: #fff; padding: 10px;">
        <div class="text-center p-3">
            © 2024 Beautymania Store. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
