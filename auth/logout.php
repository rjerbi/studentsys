<?php
session_start();              // Start the session to access session data
session_destroy();            // Destroy all session data (logs the user out)
header("Location: login.php"); // Redirect the user to the login page
exit();                       // Stop further execution (good practice after header)
?>