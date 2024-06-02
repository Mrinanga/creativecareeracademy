<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Clear the session
session_unset();
session_destroy();

// Redirect to the login page
header('Location: loginpage.html');
exit();