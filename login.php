<?php
include('db_connection_mysqli.php');
session_start();

// Initialize variables and error messages
$email = $password = '';
$emailErr = $passwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize form data
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate form inputs
    if (empty($email)) {
        $emailErr = 'Email is required.';
    }
    if (empty($password)) {
        $passwordErr = 'Password is required.';
    }

    // If no errors, process the login
    if (empty($emailErr) && empty($passwordErr)) {
        $query = "SELECT id, password, role FROM users WHERE email = '$email'";
        $result = mysqli_query($dbc, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] == 'admin') {
                    header('Location: admin_dashboard.php');
                } else {
                    header('Location: home.php');
                }
                exit();
            } else {
                $passwordErr = 'Incorrect password.';
            }
        } else {
            $emailErr = 'No account found with that email.';
        }
    }
}
?>
<?php include('header.php'); ?>
<link rel="stylesheet" href="css/login.css">
<main class="main-body">
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="email">Email*</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="input-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <button type="submit" class="button">Login</button>
            <div class="link">
                <a href="signup.php">Don’t have an account? Sign up</a>
            </div>
        </form>
    </div>
</main>
<?php include('footer.php'); ?>
