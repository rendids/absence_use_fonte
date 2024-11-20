<?php
session_start();

// Destroy session variables and redirect to login page
session_unset();
session_destroy();

header("Location: login.php"); // Redirect to login
exit();
?>
