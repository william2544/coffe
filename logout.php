<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Reset the welcome message session variable
unset($_SESSION['welcome_message_shown']);

// Redirect to the home page or login page
header("Location: index.php");
exit();
?>
