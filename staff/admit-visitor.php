<?php
require_once 'includes/auth.php'; 
require_once '../includes/db_connection.php';

if (isset($_SESSION['visitor_info'])) {
    $ticket_number = $_SESSION['visitor_info']['ticket_number'];

    // Check if the visitor has already been admitted
    $query = "SELECT * FROM visitors WHERE ticket_number = ? AND status = 'checked_in'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ticket_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "This visitor has already been admitted.";
        header("Location: visitors.php");
        exit();
    }

    // If not already admitted, proceed to admit the visitor
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['ticket_number'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $ticket_number = $_POST['ticket_number'];

        // Insert visitor as checked-in
        $insert_query = "INSERT INTO visitors (first_name, last_name, email, phone, ticket_number, status, checked_in_at) VALUES (?, ?, ?, ?, ?, 'checked_in', NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $ticket_number);

        if ($insert_stmt->execute()) {
            $_SESSION['message'] = "Visitor admitted successfully!";
            unset($_SESSION['visitor_info']); 
            header("Location: visitors.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to admit visitor. Please try again.";
        }
    }
}
?>

