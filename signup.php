<?php
include('db_connection_mysqli.php');

$firstName = $lastName = $email = $password = $confirmPassword = '';
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $confirmPasswordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $firstName = prepare_string($dbc, $_POST['firstName']);
    $lastName = prepare_string($dbc, $_POST['lastName']);
    $email = prepare_string($dbc, $_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['cnfpassword'];

    // Validate form inputs
    if (empty($firstName)) { $firstNameErr = 'First name is required.'; }
    if (empty($lastName)) { $lastNameErr = 'Last name is required.'; }
    if (empty($email)) { $emailErr = 'Email is required.'; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $emailErr = 'Invalid email format.'; }
    if (empty($password)) { $passwordErr = 'Password is required.'; }
    elseif (strlen($password) < 6) { $passwordErr = 'Password must be at least 6 characters.'; }
    if ($password !== $confirmPassword) { $confirmPasswordErr = 'Passwords do not match.'; }

    // If no errors, process the signup
    if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $query = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) > 0) {
            $emailErr = 'Email is already registered.';
        } else {
            // Insert new user into the database
            $query = "INSERT INTO users (first_name, last_name, email, password) 
                      VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
            if (mysqli_query($dbc, $query)) {
                header("Location: login.php?signup=success");
                exit();
            } else {
                echo 'Error: ' . mysqli_error($dbc);
            }
        }
    }
}
?>

<?php include('header.php'); ?>
<link rel="stylesheet" href="css/signup.css">
<main class="main-body">
    <div class="container">
        <h2>Sign Up</h2>
        <form method="POST" action="signup.php" id="signupForm">
            <div class="input-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                <span class="error text-danger"><?php echo $firstNameErr; ?></span>
            </div>
            <div class="input-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
                <span class="error text-danger"><?php echo $lastNameErr; ?></span>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="error text-danger"><?php echo $emailErr; ?></span>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error text-danger"><?php echo $passwordErr; ?></span>
            </div>
            <div class="input-group">
                <label for="cnfpassword">Confirm Password</label>
                <input type="password" id="cnfpassword" name="cnfpassword" required>
                <span class="error text-danger"><?php echo $confirmPasswordErr; ?></span>
            </div>
            <button type="submit" class="button">Sign Up</button>
            <div class="link">
                <a href="login.php">Already have an account? Log in</a>
            </div>
        </form>
    </div>
</main>
<?php include('footer.php'); ?>
