<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    
    // Prevent deletion of critical accounts
    if ($user_id === 1) {
        $delete_error = "Cannot delete this user.";
        header("Location: manage-users.php?error=" . urlencode($delete_error));
        exit;
    }

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    if (!$stmt) {
        $delete_error = "Failed to prepare delete query.";
        header("Location: manage-users.php?error=" . urlencode($delete_error));
        exit;
    }
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $delete_success = "User deleted successfully."; 
        header("Location: manage-users.php?success=" . urlencode($delete_success));
    } else {
        $delete_error = "Failed to delete user."; 
        header("Location: manage-users.php?error=" . urlencode($delete_error));
    }
    $stmt->close();
} else {
    // Redirect for invalid access
    $delete_error = "Invalid request method.";
    header("Location: manage-users.php?error=" . urlencode($delete_error));
}
exit;
