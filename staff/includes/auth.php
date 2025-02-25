<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    $_SESSION['error'] = "You must log in to access this page.";
    header("Location: ../login-area.php");
    exit();
}

// Restrict access by role ( staff-only pages)
// Example usage:
// if ($_SESSION['role'] !== 'staff') {
//     $_SESSION['error'] = "Unauthorized access.";
//     header("Location: ../login-area.php");
//     exit();
// }
?>
