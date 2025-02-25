<?php
session_start();
require 'includes/db_connection.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if all fields are filled
    if (empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login-area.php");
        exit();
    }

    // Query the database for the user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] === 'staff') {
                header("Location: staff/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: login-area.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with the provided credentials.";
        header("Location: login-area.php");
        exit();
    }
} else {
    header("Location: login-area.php");
    exit();
}
?>
