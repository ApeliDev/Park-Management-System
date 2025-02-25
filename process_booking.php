<?php
include 'includes/db_connection.php';

//library to send email
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get form data
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$visitDate = $_POST['visit_date'];
$numPeople = $_POST['number_of_people'];
$transactionCode = $_POST['transaction_code'];

// Validate payment 
$query = $conn->prepare("SELECT * FROM transaction_codes WHERE transaction_code = ? LIMIT 1");
$query->bind_param("s", $transactionCode);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    // Transaction code found, process the booking
    $ticketNumber = 'AMNP-' . strtoupper(uniqid());

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (first_name, last_name, email, phone, visit_date, number_of_people, transaction_code, ticket_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $firstName, $lastName, $email, $phone, $visitDate, $numPeople, $transactionCode, $ticketNumber);
    $stmt->execute();

    $bookingId = $stmt->insert_id;
    // Send booking confirmation via email
    $mail = new PHPMailer(true); 

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'tonnytrevix@gmail.com'; 
        $mail->Password = 'evuy iiew zyse yblf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('tonnytrevix@gmail.com', 'Amboseli National Park');
        $mail->addAddress($email); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Booking Confirmation';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <h2 style='color: #2c3e50; text-align: center;'>Amboseli National Park Booking Confirmation</h2>
            <p>Dear $lastName,</p>
            <p>Thank you for booking your visit to Amboseli National Park. Here are your booking details:</p>
            <table style='width: 100%; max-width: 600px; margin: 20px auto; border-collapse: collapse;'>
                <tr>
                    <td style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;'><strong>Ticket Number:</strong></td>
                    <td style='padding: 10px; background-color: #fff; border: 1px solid #ddd;'><strong>$ticketNumber</strong></td>
                </tr>
                <tr>
                    <td style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;'><strong>Visit Date:</strong></td>
                    <td style='padding: 10px; background-color: #fff; border: 1px solid #ddd;'>$visitDate</td>
                </tr>
                <tr>
                    <td style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;'><strong>Number of People:</strong></td>
                    <td style='padding: 10px; background-color: #fff; border: 1px solid #ddd;'>$numPeople</td>
                </tr>
            </table>
            <p style='text-align: center; margin-top: 20px;'>We look forward to welcoming you!</p>
        </div>";

        // Send the email
        $mail->send();
        echo "<script type='text/javascript'>
            alert('Booking successful! Check your email for the ticket.');
            window.location.href = 'booking.php'; 
        </script>";
    } catch (Exception $e) {
        // Fetch booking details for troubleshooting
        $fetchQuery = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ?");
        $fetchQuery->bind_param("i", $bookingId);
        $fetchQuery->execute();
        $bookingResult = $fetchQuery->get_result()->fetch_assoc();

        // Log error or show user-friendly message
        echo "<script type='text/javascript'>
            alert('Booking successful, but there was an issue sending the confirmation email. Please contact support.');
        </script>";

        echo "<p>Details for support:</p>
        <ul>
            <li>Name: " . htmlspecialchars($bookingResult['first_name'] . ' ' . $bookingResult['last_name']) . "</li>
            <li>Email: " . htmlspecialchars($bookingResult['email']) . "</li>
            <li>Phone: " . htmlspecialchars($bookingResult['phone']) . "</li>
            <li>Ticket Number: " . htmlspecialchars($bookingResult['ticket_number']) . "</li>
        </ul>";
    }
} else {
    echo "<script type='text/javascript'>
        alert('Invalid transaction code. Please try again.');
        window.history.back();
    </script>";
}
?>
