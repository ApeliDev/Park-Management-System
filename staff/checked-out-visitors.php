<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php'; 
$query = "SELECT * FROM visitors WHERE status = 'checked_out'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli Park Workers Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dash.css">
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <?php include('includes/header.php'); ?>
    <div class="main-content">
        <div class="container">
        <h1>Checked-Out Visitors</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Ticket Number</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($visitor = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $visitor['first_name'] . ' ' . $visitor['last_name']; ?></td>
                            <td><?= $visitor['email']; ?></td>
                            <td><?= $visitor['phone']; ?></td>
                            <td><?= $visitor['ticket_number']; ?></td>
                            <td><?= $visitor['checked_in_at']; ?></td>
                            <td><?= $visitor['checked_out_at']; ?></td>
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
