<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php'; 
$visitor_info = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_number = $_POST['ticket_number'];

    // Query the database to fetch visitor information based on ticket number
    $sql = "SELECT * FROM bookings WHERE ticket_number = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $ticket_number); 
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any record was found
        if ($result->num_rows > 0) {
            $visitor_info = $result->fetch_assoc();
            $_SESSION['visitor_info'] = $visitor_info;
        } else {
            $_SESSION['error_message'] = "No visitor found with the given ticket number.";
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "There was an error processing your request.";
    }
    header("Location: visitors.php");
    exit;
}
?>
