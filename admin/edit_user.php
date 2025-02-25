<?php
require_once('includes/auth.php'); 
require_once '../includes/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $user_id = intval($_POST['user_id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $phone_number = trim($_POST['phone_number']);

    // Input validation
    if (empty($user_id) || empty($username) || empty($email) || empty($role)) {
        $_SESSION['error'] = 'All required fields must be filled.';
        header("Location: manage-users.php"); 
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address.';
        header("Location: manage-users.php");
        exit;
    }

    // Prepare the SQL statement for updating the user
    $stmt = $conn->prepare("
        UPDATE users
        SET username = ?, email = ?, role = ?, phone_number = ?
        WHERE user_id = ?
    ");

    if (!$stmt) {
        $_SESSION['error'] = 'Database error. Please try again.';
        header("Location: manage-users.php");
        exit;
    }

    // Bind the parameters and execute the query
    $stmt->bind_param("ssssi", $username, $email, $role, $phone_number, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'User details updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update user details. Please try again.';
    }

    $stmt->close();
    header("Location: manage-users.php");
    exit;
} else {
    // If accessed directly without form submission
    $_SESSION['error'] = 'Invalid request method.';
    header("Location: manage-users.php");
    exit;
}
