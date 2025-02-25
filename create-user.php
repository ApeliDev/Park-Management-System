<?php
session_start();

// Include database connection
include 'includes/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($role) || empty($email) || empty($phone_number)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: create-user-form.php");
        exit;
    }

    // Hash the password before inserting
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL query
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, email, phone_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hashed_password, $role, $email, $phone_number);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = "User created successfully.";
            header("Location: create-user.php"); // Redirect to form page after success
        } else {
            $_SESSION['error'] = "Error: Could not create user.";
            header("Location: create-user.php");
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: create-user.php");
    }

    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin/Staff User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Create Admin/Staff User</h2>
            
            <!-- Display error message -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Form for creating Admin or Staff -->
            <form action="create-user.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create User</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
