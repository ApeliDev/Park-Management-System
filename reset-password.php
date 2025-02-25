<?php
require_once 'includes/db_connection.php';
session_start();

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $reset_token = urldecode($_GET['token'] ?? '');

    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['error'] = 'Invalid CSRF token.';
        header("Location: reset-password.php?token=" . urlencode($reset_token));
        exit;
    }

    // Validate inputs
    if (empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = 'Please fill in all fields.';
    } elseif (strlen($new_password) < 8 || !preg_match('/[A-Za-z]/', $new_password) || !preg_match('/\d/', $new_password) || !preg_match('/[@$!%*?&]/', $new_password)) {
        $_SESSION['error'] = 'Password must be at least 8 characters long, contain letters, numbers, and special characters.';
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
    } else {
        // Check the reset token in the database without checking expiration
        $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE reset_token = ?");
        if (!$stmt) {
            $_SESSION['error'] = 'Database error. Please try again.';
            header("Location: reset-password.php?token=" . urlencode($reset_token));
            exit;
        }

        $stmt->bind_param("s", $reset_token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $stmt->close();

            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the users table
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Remove the reset token
            $delete_stmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $delete_stmt->bind_param("i", $user_id);
            $delete_stmt->execute();
            $delete_stmt->close();

            $_SESSION['success'] = 'Your password has been updated successfully. Please log in.';
            header("Location: login-area.php");
            exit;
        } else {
            $_SESSION['error'] = 'Invalid reset token.';
        }
    }
    header("Location: reset-password.php?token=" . urlencode($reset_token));
    exit;
}

// Verify the token when the page loads
$reset_token = urldecode($_GET['token'] ?? '');
if (empty($reset_token)) {
    $_SESSION['error'] = 'Invalid reset token.';
    header("Location: forgot-password.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h4>Reset Password</h4>
            </div>
            <br>
            <!-- Display messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Reset Password Form -->
            <form action="reset-password.php?token=<?= htmlspecialchars($reset_token) ?>" method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</body>

</html>
