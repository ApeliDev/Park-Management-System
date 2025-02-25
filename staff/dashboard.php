
<?php
require_once 'includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli Park Workers Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dash.css">
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <?php include('includes/header.php'); ?>
    <div class="main-content">
        <div class="container">
            <h1 id="dashboard" class="mb-4">Dashboard</h1>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Tasks</h5>
                            <p class="task-status">You have <strong>5 tasks</strong> in progress.</p>
                            <a href="#tasks" class="btn btn-primary">View Tasks</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming Shifts</h5>
                            <p class="task-status">Next shift: <strong>3:00 PM - 6:00 PM</strong></p>
                            <a href="#schedule" class="btn btn-primary">View Schedule</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Notices</h5>
                            <p class="task-status">2 new notices from management.</p>
                            <a href="#notices" class="btn btn-primary">View Notices</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
