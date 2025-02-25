<?php
require_once 'includes/db_connection.php';
session_start();

// PHPMailer libraries
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Validate email
    if (empty($email)) {
        $_SESSION['error'] = 'Please enter your email.';
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $stmt->close();

            // Generate reset token
            $reset_token = bin2hex(random_bytes(32));
            $reset_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store reset token and expiration in the password_resets table
            $stmt = $conn->prepare("INSERT INTO password_resets (user_id, reset_token, reset_expires) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE reset_token = ?, reset_expires = ?");
            $stmt->bind_param("issss", $user_id, $reset_token, $reset_expires, $reset_token, $reset_expires);
            $stmt->execute();
            $stmt->close();
            
            // Send reset email
            $reset_link = "http://localhost/amboseli/reset-password.php?token=$reset_token";
            $subject = "Password Reset Request";
            $message = "Hello,\n\nYou requested a password reset. Click the link below to reset your password:\n\n$reset_link\n\nIf you did not request this, please ignore this email.\n\nBest regards,\nAmboseli National Park Team";

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
                $mail->addAddress($email);

                $mail->isHTML(false);
                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();
                $_SESSION['success'] = "A password reset link has been sent to your email.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to send the email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = "Email not found.";
        }
    }
    header("Location: forgot-password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Amboseli National Park</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #00b4d8, #90e0ef);
            color: #333;
        }

        .container {
            max-width: 500px;
            margin-top: 100px;
        }

        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #00b4d8;
            color: white;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #00b4d8;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #0095b6;
            box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.5);
        }

        .btn-primary {
            background-color: #00b4d8;
            border-color: #00b4d8;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0095b6;
            border-color: #0095b6;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: 500;
        }

        .alert {
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            position: absolute;
            bottom: 20px;
            width: 100%;
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Forgot Password</h4>
            </div><br>
            <!-- Display error or success message -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php elseif (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Forgot Password Form -->
            <form action="forgot-password.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
            
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Amboseli National Park. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
