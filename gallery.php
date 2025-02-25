<?php
require_once 'includes/db_connection.php'; // Include database connection

// Fetch gallery images from the `park_gallery` table
$sql = "SELECT * FROM park_gallery ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

// Define the folder where images are stored
$imageFolder = 'admin/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli National Park - Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <!-- Hero Section -->
    <section class="gallery-hero" style="background-color: #6a11cb; color: white; height: 15vh; display: flex; align-items: center; justify-content: center; text-align: center;">
        <h1>Gallery</h1>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="text-center mb-5">Discover the Beauty of Amboseli National Park</h2>
            <div class="row g-4">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="gallery-item">
                                <img src="<?php echo $imageFolder . htmlspecialchars($image['image_path']); ?>" 
                                     class="img-fluid rounded" 
                                     alt="<?php echo htmlspecialchars($image['caption'] ?? 'Gallery Image'); ?>">
                                <?php if (!empty($image['caption'])): ?>
                                    <p class="text-center mt-2"><?php echo htmlspecialchars($image['caption']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No images available in the gallery.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
