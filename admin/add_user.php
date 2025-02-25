<?php

require_once 'includes/auth.php';
require_once '../includes/db_connection.php';
//library to send email
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Initialize error and success messages
$add_success = '';
$add_error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $phone_number = trim($_POST['phone_number']);

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $add_error = "All fields are required.";
    } else {
        // Check if the email is already in use
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $add_error = "Email is already in use.";
            $stmt->close();
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, phone_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $role, $phone_number);

            if ($stmt->execute()) {
                // Success
                $add_success = "User added successfully.";

                // Send email notification
                $subject = "Your New Account Details";
                $message = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                    <h1 style='color: #2c3e50; font-size: 20px; text-align: center;'>Welcome to Amboseli National Park!</h1>
                    <p>Dear <strong>{$username}</strong>,</p>
                    <p>Your account has been successfully created. Here are your login details:</p>
                    <ul style='list-style: none; padding: 0;'>
                        <li style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; margin-bottom: 10px;'>
                            <strong>Email:</strong> {$email}
                        </li>
                        <li style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; margin-bottom: 10px;'>
                            <strong>Role:</strong> {$role}
                        </li>
                        <li style='padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;'>
                            <strong>Password:</strong> {$password}
                        </li>
                    </ul>
                    <p>Please <a href='https://localhost/amboseli/login-area.php' style='color: #1a73e8; text-decoration: none;'>log in</a> to the system at your earliest convenience.</p>
                    <p>We're thrilled to have you on board and look forward to working with you!</p>
                    <p style='margin-top: 20px; text-align: center; font-size: 14px; color: #555;'>
                        Best regards,<br>
                        <strong>Amboseli National Park</strong>
                    </p>
                </div>";

                
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
                    $mail->addAddress($email, $username); 

                    // Content
                    $mail->isHTML(true);  
                    $mail->Subject = $subject;
                    $mail->Body    = $message;

                    // Send email
                    $mail->send();
                    $add_success .= " An email with your login details has been sent to $email.";
                } catch (Exception $e) {
                    // Error sending email
                    $add_error = "Failed to send the email to $email. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                // Error inserting user
                $add_error = "Failed to add user.";
            }

            $stmt->close();
        }
    }
}

if ($add_success) {
    header("Location: manage-users.php?success=" . urlencode($add_success));
} elseif ($add_error) {
    header("Location: manage-users.php?error=" . urlencode($add_error));
}
exit;


?>