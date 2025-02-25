<?php
include('includes/db_connection.php');

// Fetch tours from the database
$sql = "SELECT * FROM tours";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli National Park - Tours</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/tour.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- Hero Section -->
    <section class="tours-hero text-light text-center py-5 position-relative" style="background: url('images/park.jpg') no-repeat center center/cover; height: 400px;">
        <!-- Overlay -->
        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);"></div>
        <!-- Content -->
        <div class="position-relative z-index-1">
            <h1>Explore Our Exclusive Tours</h1>
            <p>Discover the wonders of Amboseli National Park with our tailored adventures.</p>
        </div>
    </section>

    <!-- Tours Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Choose Your Adventure</h2>
            <div class="row g-4">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($tour = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card tour-card shadow-sm">
                                <img src="<?php echo 'admin/' . htmlspecialchars($tour['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($tour['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($tour['description']); ?></p>
                                    <a href="booking.php" class="btn btn-primary"><i class="fas fa-ticket-alt"></i> Book Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No tours available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
