<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amboseli National Park</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
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

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #00b4d8;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus,
        .form-select:focus {
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

        .forgot-password-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #00b4d8;
            text-decoration: none;
        }

        .forgot-password-link:hover {
            color: #0095b6;
            text-decoration: underline;
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
                <h4>Login</h4>
            </div><br>
            <!-- Display error message -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="process-login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <!-- Forgot Password Link -->
                <a href="forgot-password.php" class="forgot-password-link">Forgot Password?</a>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Amboseli National Park. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
