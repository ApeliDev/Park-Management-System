<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    // Get and sanitize the booking ID
    $booking_id = intval($_POST['booking_id']);

    // Validate the booking ID
    if ($booking_id <= 0) {
        $_SESSION['error'] = 'Invalid booking ID.';
        header('Location: manage_bookings.php');
        exit;
    }

    // Prepare DELETE query
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id); 

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Booking deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete the booking. Please try again.';
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();

    header('Location: manage_bookings.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request or missing booking ID.';
    header('Location: manage_bookings.php');
    exit;
}
?>