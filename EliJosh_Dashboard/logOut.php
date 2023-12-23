<?php
// Start the session
session_start();
ob_start();
// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to a page or perform any other actions as needed
header("Location: ../Client/index.php");
ob_end_flush();
exit; // Ensure no further code is executed after the header
?>