<?php

require_once 'includes/db_connection.php';
  
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (empty($user_name) || empty($user_email) || empty($message)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: contact.php"); 
        exit();
    }

    // Insert into the support_inquiries table
    $sql = "INSERT INTO support_inquiries (user_name, user_email, subject, message, status, created_at, updated_at) 
            VALUES (?, ?, ?, ?, 'Pending', NOW(), NOW())";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssss", $user_name, $user_email, $subject, $message);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "Your inquiry has been sent successfully.";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare the query.";
    }

    header("Location: contact.php");
    exit();
}
?>
