<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';


//library to send email
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Handle Form Submission for Support Inquiry
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_inquiry'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert Inquiry Data into Database
    $sql = "INSERT INTO support_inquiries (user_name, user_email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_name, $user_email, $subject, $message);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Your inquiry has been submitted successfully!";
        header("Location: support.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Failed to submit your inquiry. Please try again.";
    }
}

// Handle Admin's Response to Inquiry
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_inquiry'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $admin_reply = $_POST['admin_reply'];
    $status = $_POST['status'];

    // Fetch the user's email address to send a reply
    $sql = "SELECT user_email, user_name FROM support_inquiries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $inquiry = $result->fetch_assoc();

    if ($inquiry) {
        $user_email = $inquiry['user_email'];
        $user_name = $inquiry['user_name'];

        // Update the Inquiry with Admin's Response and Status
        $sql = "UPDATE support_inquiries SET reply = ?, status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $admin_reply, $status, $inquiry_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your reply has been submitted successfully!";

            // Send email to user using PHPMailer
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
                $mail->setFrom('tonnytrevix@gmail.com', 'Amboseli Natonal Park');
                $mail->addAddress($user_email, $user_name); 
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Response from Support';
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                        <p style='font-size: 18px; margin-bottom: 20px;'>Hello <strong style='color: #0056b3;'>$user_name</strong>,</p>
                        
                        <p style='font-size: 16px; margin-bottom: 15px;'>
                            We have received your inquiry, and our team has responded with the following message:
                        </p>
                        
                        <div style='padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;'>
                            <p style='font-size: 16px; margin: 0;'>
                                <strong style='color: #0056b3;'>Message:</strong><br>
                                <em>$admin_reply</em>
                            </p>
                        </div>
                        
                        <p style='font-size: 16px; margin-top: 20px;'>
                            <strong>Status:</strong> <span style='color: #28a745; font-weight: bold;'>$status</span>
                        </p>
                        
                        <p style='font-size: 16px; margin-top: 30px;'>
                            Thank you for contacting us!
                        </p>
                        
                        <hr style='border: 0; border-top: 1px solid #ddd; margin: 30px 0;'>
                        
                        <footer style='font-size: 14px; text-align: center; color: #888;'>
                            <p>&copy; " . date("Y") . " Amboseli National Park. All rights reserved.</p>
                        </footer>
                    </div>
                ";


                // Send email
                $mail->send();

                $_SESSION['success'] = "Your reply has been sent successfully, and the user has been notified via email.";
            } catch (Exception $e) {
                $_SESSION['error'] = "There was an error sending the email: {$mail->ErrorInfo}";
            }

            header("Location: support.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to submit your reply. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Inquiry not found.";
    }
}

// Fetch All Support Inquiries (Admin side)
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM support_inquiries ORDER BY created_at DESC";
    $result = $conn->query($sql);
}

// Fetch Inquiry Details for Reply
if (isset($_GET['inquiry_id'])) {
    $inquiry_id = $_GET['inquiry_id'];
    $sql = "SELECT * FROM support_inquiries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiry_id);
    $stmt->execute();
    $inquiry = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dsh.css">
</head>
<body>
   <!-- Include Sidebar -->
   <?php include('includes/side-nav.php'); ?>
   <!-- Header -->
   <?php include('includes/header.php'); ?>

   <!-- Main Content -->
   <div class="main-content">
        <div class="container mt-5">
            <h1>Support System</h1>
            
            <!-- Display Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <!-- Display All Inquiries for Admin -->
                <h3 class="mb-4">All Inquiries</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['user_name']; ?></td>
                                <td><?= $row['user_email']; ?></td>
                                <td><?= $row['subject']; ?></td>
                                <td><?= $row['status']; ?></td>
                                <td><?= $row['created_at']; ?></td>
                                <td>
                                    <a href="support.php?inquiry_id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Reply</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (isset($inquiry)): ?>
                <!-- Reply to Inquiry -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Reply to Inquiry: <?= $inquiry['subject']; ?></h5>
                    </div>
                    <div class="card-body">
                        <h6>From: <?= $inquiry['user_name']; ?> (<?= $inquiry['user_email']; ?>)</h6>
                        <p><strong>Message:</strong></p>
                        <p><?= nl2br($inquiry['message']); ?></p>

                        <form action="support.php" method="POST">
                            <input type="hidden" name="inquiry_id" value="<?= $inquiry['id']; ?>">
                            <div class="mb-3">
                                <label for="admin_reply" class="form-label">Your Reply</label>
                                <textarea name="admin_reply" id="admin_reply" rows="4" class="form-control" placeholder="Enter your reply here" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Replied">Replied</option>
                                    <option value="Resolved">Resolved</option>
                                </select>
                            </div>
                            <button type="submit" name="reply_inquiry" class="btn btn-primary">Send Reply</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
