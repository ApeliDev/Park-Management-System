<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php'; 

// Query the database to get the count of active tours
$toursQuery = "SELECT COUNT(*) AS tour_count FROM tours";
$toursResult = mysqli_query($conn, $toursQuery);
$toursCount = mysqli_fetch_assoc($toursResult)['tour_count'];

// Query the database to get the count of recent bookings
$bookingsQuery = "SELECT COUNT(*) AS booking_count FROM bookings WHERE visit_date >= CURDATE()";
$bookingsResult = mysqli_query($conn, $bookingsQuery);
$bookingsCount = mysqli_fetch_assoc($bookingsResult)['booking_count'];

// Query the database to get the count of tracked wildlife species
$wildlifeQuery = "SELECT COUNT(*) AS wildlife_count FROM park_gallery"; 
$wildlifeResult = mysqli_query($conn, $wildlifeQuery);
$wildlifeCount = mysqli_fetch_assoc($wildlifeResult)['wildlife_count'];

// Query the database to get the count of active staff members (adjusted)
$staffQuery = "SELECT COUNT(*) AS staff_count FROM users WHERE role != 'inactive'";  // Adjust this line if needed based on your data model
$staffResult = mysqli_query($conn, $staffQuery);
$staffCount = mysqli_fetch_assoc($staffResult)['staff_count'];
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
    <?php include('includes/side-nav.php'); ?>
    <!-- Header -->
    <?php include('includes/header.php'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 id="dashboard" class="mb-4">Dashboard</h1>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <div class="card-icon"><i class="fas fa-safari"></i></div>
                            <h5 class="card-title mt-3">Tours</h5>
                            <p class="card-text"><?= $toursCount ?> Active Tours</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                            <h5 class="card-title mt-3">Bookings</h5>
                            <p class="card-text"><?= $bookingsCount ?> Recent Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <div class="card-icon"><i class="fas fa-paw"></i></div>
                            <h5 class="card-title mt-3">Wildlife</h5>
                            <p class="card-text"><?= $wildlifeCount ?> Species Tracked</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <div class="card-icon"><i class="fas fa-users"></i></div>
                            <h5 class="card-title mt-3">Staff</h5>
                            <p class="card-text"><?= $staffCount ?> Active Staff Members</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
