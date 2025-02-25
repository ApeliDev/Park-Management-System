<?php
require_once 'includes/auth.php'; 
require_once '../includes/db_connection.php'; 

// Fetch all bookings from the database
$sql = "SELECT * FROM bookings ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli Park Admin Panel</title>
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
            <h1 class="mb-4">Manage Bookings</h1>

            <!-- Display Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Visit Date</th>
                        <th>No. of People</th>
                        <th>Ticket Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['first_name']; ?></td>
                            <td><?= $row['last_name']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td><?= $row['visit_date']; ?></td>
                            <td><?= $row['number_of_people']; ?></td>
                            <td><?= $row['ticket_number']; ?></td>
                            <td>
                                <!-- Delete Form -->
                                <form action="delete_booking.php" method="POST" class="d-inline">
                                    <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                                <!-- Add other actions like View/Edit if necessary -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
