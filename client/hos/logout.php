<?php
// Start the session
session_start();

// Destroy the session (log out)
session_destroy();

// Redirect the user to the login page or any other page you prefer
header("Location: staff_login.php");
exit();
?>
