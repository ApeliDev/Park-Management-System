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
        <div class="container py-4">
            <h1 id="dashboard" class="mb-4">Dashboard</h1>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Validate Visitor Ticket</h5>
                    <form action="validate-ticket.php" method="POST">
                        <div class="mb-3">
                            <label for="ticket_number" class="form-label">Ticket Number</label>
                            <input type="text" class="form-control" id="ticket_number" name="ticket_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Validate Ticket</button>
                    </form>
                    <?php if (isset($_SESSION['visitor_info'])): ?>
                        <div class="mt-4">
                            <h5>Visitor Information:</h5>
                            <p><strong>Name:</strong> <?= $_SESSION['visitor_info']['first_name'] . ' ' . $_SESSION['visitor_info']['last_name']; ?></p>
                            <p><strong>Email:</strong> <?= $_SESSION['visitor_info']['email']; ?></p>
                            <p><strong>Phone:</strong> <?= $_SESSION['visitor_info']['phone']; ?></p>
                            <p><strong>Ticket Number:</strong> <?= $_SESSION['visitor_info']['ticket_number']; ?></p>
                            <form action="admit-visitor.php" method="POST">
                                <input type="hidden" name="first_name" value="<?= $_SESSION['visitor_info']['first_name']; ?>">
                                <input type="hidden" name="last_name" value="<?= $_SESSION['visitor_info']['last_name']; ?>">
                                <input type="hidden" name="email" value="<?= $_SESSION['visitor_info']['email']; ?>">
                                <input type="hidden" name="phone" value="<?= $_SESSION['visitor_info']['phone']; ?>">
                                <input type="hidden" name="ticket_number" value="<?= $_SESSION['visitor_info']['ticket_number']; ?>">
                                <button type="submit" class="btn btn-success mt-3">Admit Visitor</button>
                            </form>
                        </div>
                    <?php elseif (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger mt-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add New Visitor Manually</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitorModal">
                        Add Visitor
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addVisitorModal" tabindex="-1" aria-labelledby="addVisitorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVisitorModalLabel">Add New Visitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="generate-ticket.php" method="POST">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="visit_date" class="form-label">Visit Date</label>
                            <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="number_of_people" class="form-label">Number of People</label>
                            <input type="number" class="form-control" id="number_of_people" name="number_of_people" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Generate Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
