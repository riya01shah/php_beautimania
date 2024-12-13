<!-- <?php include('header.php'); ?> -->
 <?php 
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
    <title>Order Details - Order #<?php echo htmlspecialchars($orderId); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/order.css">
</head>
<?php include('header.php'); ?>
<main class="main-body">

    <div class="diffSection" id="contactus_section">
        <b>
            <center><p class="white txt contact-us" style="font-size: 30px;">Shopping Cart</p></center>
        </b>
        <div class="cart-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Cart items will be dynamically added here -->
                </tbody>
            </table>
            <div class="cart-summary text-end mb25">
                <h4>Total: $<span id="cart-total">0.00</span></h4>
                <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
                <button class="btn btn-primary pink" id="checkout">Checkout</button>
            </div>
        </div>
    </div>
</main>
<?php include('footer.php'); ?> 

<script>
// Load cart items from localStorage
function loadCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    let total = 0;

    cartItemsContainer.innerHTML = ''; // Clear existing items

    cart.forEach((item, index) => {
        const subtotal = item.price * item.quantity;
        total += subtotal;

        cartItemsContainer.innerHTML += `
            <tr>
                <td><img src="images/${item.image}" alt="${item.name}" style="height: 50px; width: 50px; object-fit: cover;"></td>
                <td>${item.name}</td>
                <td>$${parseFloat(item.price).toFixed(2)}</td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" class="cart-quantity" data-index="${index}">
                </td>
                <td>$${subtotal.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm remove-item" data-index="${index}">Remove</button></td>
            </tr>
        `;
    });

    cartTotalElement.textContent = total.toFixed(2);

    // Attach event listeners for quantity changes and remove buttons
    attachEventListeners();
}

// Attach event listeners to dynamically created elements
function attachEventListeners() {
    const quantityInputs = document.querySelectorAll('.cart-quantity');
    const removeButtons = document.querySelectorAll('.remove-item');

    quantityInputs.forEach(input => {
        input.addEventListener('change', updateQuantity);
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', removeItem);
    });
}

// Update item quantity
function updateQuantity(e) {
    const index = e.target.getAttribute('data-index');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const newQuantity = parseInt(e.target.value);

    if (newQuantity > 0) {
        cart[index].quantity = newQuantity;
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
    } else {
        alert('Quantity must be at least 1.');
        e.target.value = cart[index].quantity;
    }
}

// Remove item from cart
function removeItem(e) {
    const index = e.target.getAttribute('data-index');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}

// Clear the cart
document.getElementById('clear-cart').addEventListener('click', () => {
    if (confirm('Are you sure you want to clear the cart?')) {
        localStorage.removeItem('cart');
        loadCart();
    }
});

// Handle the checkout button click
// Handle the checkout button click
document.getElementById('checkout').addEventListener('click', () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        alert('Your cart is empty. Add items before proceeding to checkout.');
    } else {
        // Send cart data to the server to store in the session
        fetch('store_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(cart)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'checkout.php'; // Redirect to checkout page
                localStorage.removeItem('cart');
            } else {
                alert('Failed to send cart data to server.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending cart data to the server.');
        });
    }
});

// Load the cart when the page loads
document.addEventListener('DOMContentLoaded', loadCart);
</script>
