<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';
//library to send email
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $visit_date = $_POST['visit_date'];
    $number_of_people = $_POST['number_of_people'];

    // Generate a unique ticket number
    $ticket_number = 'AMNP-' . strtoupper(uniqid());
    $check_in_time = date('Y-m-d H:i:s');

    // Insert into the visitors table
    $query = "INSERT INTO visitors (first_name, last_name, email, phone, ticket_number, status, checked_in_at) 
              VALUES (?, ?, ?, ?, ?, 'checked_in', ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $ticket_number, $check_in_time);
        if ($stmt->execute()) {
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
                $mail->Subject = 'Your Ticket Details';
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                        <h1 style='color: #2c3e50; text-align: center; font-size: 24px;'>Ticket Confirmation</h1>
                        <p>Dear <strong>{$first_name} {$last_name}</strong>,</p>
                        <p>Thank you for registering your visit. Here are your ticket details:</p>
                        <ul style='list-style-type: none; padding: 0;'>
                            <li style='padding: 10px; background-color: #ffffff; border: 1px solid #ddd; margin-bottom: 5px;'>
                                <strong>Ticket Number:</strong> {$ticket_number}
                            </li>
                            <li style='padding: 10px; background-color: #ffffff; border: 1px solid #ddd; margin-bottom: 5px;'>
                                <strong>Check-in Date:</strong> {$check_in_time}
                            </li>
                            <li style='padding: 10px; background-color: #ffffff; border: 1px solid #ddd; margin-bottom: 5px;'>
                                <strong>Visit Date:</strong> {$visit_date}
                            </li>
                        </ul>
                        <p style='margin-top: 20px;'>We look forward to welcoming you!</p>
                        <p style='margin-top: 20px;'>Best regards,<br><strong>Amboseli National park</strong></p>
                    </div>
                ";
                $mail->send();
                $_SESSION['message'] = "Visitor added successfully! Ticket Number: {$ticket_number}. An email has been sent to {$email}.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Visitor added, but email could not be sent. Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = "Failed to add visitor. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare query. Please try again.";
    }
    header('Location: visitors.php');
    exit;
}
?>
