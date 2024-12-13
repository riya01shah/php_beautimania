
<?php 

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('header.php'); 
include('db_connection_mysqli.php'); // Ensure this file has your DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstName']));
    $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastName']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
    $comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));

    // Simple validation
    $errors = [];
    if (empty($firstName)) { $errors['firstName'] = "First Name is required."; }
    if (empty($lastName)) { $errors['lastName'] = "Last Name is required."; }
    if (empty($email)) { $errors['email'] = "Email is required."; }
    if (empty($comment)) { $errors['comment'] = "Comment is required."; }

    // If no errors, insert data
    if (empty($errors)) {
        $query = "INSERT INTO contact (first_name, last_name, email, phone, comment) 
                  VALUES ('$firstName', '$lastName', '$email', '$phone', '$comment')";

        if (mysqli_query($dbc, $query)) {
            // Display an alert and redirect to home.php
            echo "<script>
                    alert('Thank you for contacting us! We will get back to you soon.');
                    window.location.href = 'home.php';
                  </script>";
            exit(); // Stop further script execution
        } else {
            echo "<script>alert('Error: Could not submit your request. Please try again later.');</script>";
        }
    }
}
?>

<link rel="stylesheet" href="css/contact.css">
<main class="main-body">
    <div class="diffSection" id="contactus_section">
        <center><p class="white txt contact-us" style="font-size: 30px;">CONTACT US</p></center>
        <div class="form-container">
            <h2>Contact Form</h2>
            <form action="contact.php" method="POST">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName ?? ''); ?>">
                <span class="error"><?php echo $errors['firstName'] ?? ''; ?></span>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName ?? ''); ?>">
                <span class="error"><?php echo $errors['lastName'] ?? ''; ?></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                <span class="error"><?php echo $errors['email'] ?? ''; ?></span>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"><?php echo htmlspecialchars($comment ?? ''); ?></textarea>
                <span class="error"><?php echo $errors['comment'] ?? ''; ?></span>

                <input type="submit" value="Submit" class= "button">
            </form>
        </div>
    </div>
</main>
<section class="map">
    <h2 class="txt">OUR LOCATION</h2>
    <iframe src="https://www.google.com/maps/embed?..."></iframe>
</section>
<?php include('footer.php'); ?>
