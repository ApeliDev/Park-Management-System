<?php
require_once 'includes/auth.php'; 
require_once '../includes/db_connection.php';
//library to send email
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Search for ticket number if provided
$ticket_number = isset($_GET['ticket_number']) ? $_GET['ticket_number'] : '';

// Prepare the SQL query to get checked-in visitors
$query = "SELECT * FROM visitors WHERE status = 'checked_in' AND ticket_number LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%$ticket_number%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all visitors
$checked_in_visitors = [];
while ($visitor = $result->fetch_assoc()) {
    $checked_in_visitors[] = $visitor;
}

// If a visitor is checked out
if (isset($_POST['check_out'])) {
    $visitor_id = $_POST['visitor_id'];

    // Fetch visitor details
    $visitor_query = "SELECT * FROM visitors WHERE visitor_id = ?";
    $visitor_stmt = $conn->prepare($visitor_query);
    $visitor_stmt->bind_param("i", $visitor_id);
    $visitor_stmt->execute();
    $visitor_result = $visitor_stmt->get_result();
    $visitor = $visitor_result->fetch_assoc();

    if ($visitor) {
        $email = $visitor['email'];
        $first_name = $visitor['first_name'];
        $last_name = $visitor['last_name'];
        $ticket_number = $visitor['ticket_number'];
        $checked_in_at = $visitor['checked_in_at'];

        // Update visitor status to 'checked_out'
        $update_query = "UPDATE visitors SET status = 'checked_out', checked_out_at = NOW() WHERE visitor_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $visitor_id);

        if ($update_stmt->execute()) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'tonnytrevix@gmail.com'; 
                $mail->Password = 'evuy iiew zyse yblf'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('tonnytrevix@gmail.com', 'Amboseli National Park');
                $mail->addAddress($email, $first_name . ' ' . $last_name);
                $mail->isHTML(true);
                $mail->Subject = 'Checkout Confirmation';
                    $mail->Body = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                        <h1 style='color: #2c3e50; text-align: center; font-size: 24px;'>Checkout Confirmation</h1>
                        <p>Dear <strong>{$first_name} {$last_name}</strong>,</p>
                        <p>We hope you had a memorable experience during your visit! Here are the details of your checkout:</p>
                        <ul style='padding: 0; list-style: none;'>
                            <li style='padding: 10px; background-color: #ffffff; border: 1px solid #ddd; margin-bottom: 10px;'>
                                <strong>Check-in Time:</strong> {$checked_in_at}
                            </li>
                            <li style='padding: 10px; background-color: #ffffff; border: 1px solid #ddd; margin-bottom: 10px;'>
                                <strong>Checkout Time:</strong> " . date('Y-m-d H:i:s') . "
                            </li>
                        </ul>
                        <p style='margin-top: 20px;'>We truly value your presence and hope that you enjoyed everything we have to offer. It was an honor to host you, and we’re grateful to have been part of your journey.</p>
                        <p>We would love to welcome you again in the future. Whether it’s another peaceful retreat or a chance to explore new adventures, we’ll be here to make your next visit just as special.</p>
                        <p style='margin-top: 20px;'>Thank you for choosing us, and we hope to see you again soon!</p>
                        <p style='margin-top: 20px; text-align: right;'>Warm regards,<br><strong>Amboseli National Park</strong></p>
                    </div>
                ";
                // Send email
                $mail->send();
                $_SESSION['message'] = "Visitor checked out successfully! An email has been sent to {$email}.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Visitor checked out, but email could not be sent. Error: {$mail->ErrorInfo}";
            }

            header("Location: checked-in-visitors.php"); 
            exit();
        } else {
            $_SESSION['error'] = "Failed to check out visitor.";
        }
    } else {
        $_SESSION['error'] = "Visitor not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checked-In Visitors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dash.css">
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <?php include('includes/header.php'); ?>
    <div class="main-content">
        <div class="container">
        <h1>Checked-In Visitors</h1>
        <form action="checked-in-visitors.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="ticket_number" class="form-control" placeholder="Search by Ticket Number" value="<?= htmlspecialchars($ticket_number) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Ticket Number</th>
                    <th>Check-In Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checked_in_visitors as $visitor): ?>
                    <tr>
                        <td><?= $visitor['first_name'] . ' ' . $visitor['last_name']; ?></td>
                        <td><?= $visitor['email']; ?></td>
                        <td><?= $visitor['phone']; ?></td>
                        <td><?= $visitor['ticket_number']; ?></td>
                        <td><?= $visitor['checked_in_at']; ?></td>
                        <td>
                            <form action="checked-in-visitors.php" method="POST">
                                <input type="hidden" name="visitor_id" value="<?= $visitor['visitor_id']; ?>">
                                <button type="submit" name="check_out" class="btn btn-danger">Check Out</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
     <?php include('../includes/loader.php'); ?>               
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
