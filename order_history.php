<?php
require('db_connection_mysqli.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$userId = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id = '$userId' ORDER BY date DESC";
$result = mysqli_query($dbc, $query);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order.css">
</head>
<?php include('header.php'); ?>
<main class="main-body">
    <!-- Your content here -->
    <div class="container mt-5">
        <h2 class="mb-4">Your Order History</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($row['total'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="order_details.php?order_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm pink ">View Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no past orders.</p>
        <?php endif; ?>
    </div>
</main>
<?php include('footer.php'); ?>

