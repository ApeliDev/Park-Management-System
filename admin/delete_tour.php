<?php
require_once 'includes/auth.php'; 
require_once '../includes/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tour_id'])) {
    $tour_id = intval($_POST['tour_id']);
    
    // Validate the tour_id
    if ($tour_id <= 0) {
        $_SESSION['error'] = 'Invalid tour ID.';
        header('Location: manage_tours.php');
        exit;
    }

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM tours WHERE tour_id = ?");
    $stmt->bind_param("i", $tour_id); 

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Tour deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete the tour. Please try again.';
    }

    // Close the prepared statement and the connection
    $stmt->close();
    $conn->close();

    // Redirect back to manage tours page
    header('Location: manage_tours.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request or missing tour ID.';
    header('Location: manage_tours.php');
    exit;
}
?>
