<?php
session_start(); // Start the session

// Destroy all session data
$_SESSION = array(); // Clear session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: login.php");
exit();
?>
