<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';

// Fetch all users
$query = "SELECT * FROM users";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Include header and navigation
include('includes/side-nav.php');
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Amboseli Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dsh.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1 class="my-4">Manage Users</h1>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>


            <!-- Add User Button -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>

            <!-- Users Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['phone_number']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['user_id'] ?>">Edit</button>
                            <form action="delete_user.php" method="POST" class="d-inline">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="edit_user.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" name="role" required>
                                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="staff" <?= $user['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="add_user.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
