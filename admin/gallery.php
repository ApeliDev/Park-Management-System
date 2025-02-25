<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';

// Handle Image Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_image'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image type is allowed
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($image_type, $allowed_types)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $caption = $_POST['caption'];

                // Insert image info into the database
                $sql = "INSERT INTO park_gallery (image_path, caption) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $target_file, $caption);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Image uploaded successfully!";
                } else {
                    $_SESSION['error'] = "Failed to save image to the database.";
                }
            } else {
                $_SESSION['error'] = "Failed to upload image. Please try again.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $_SESSION['error'] = "No image selected or an error occurred.";
    }
}

// Fetch All Images for Display
$sql = "SELECT * FROM park_gallery ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
$images = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dsh.css">
    <style>
        .card {
            display: flex;
            flex-direction: column;
        }

        .equal-image {
            height: 200px; 
            object-fit: cover;
        }

        .card-body {
            display: flex;
            flex-direction: column;
        }

    </style>
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <?php include('includes/header.php'); ?>

    <div class="main-content">
        <div class="container">
            <h2 class="mt-4">Park Gallery</h2>

            <!-- Display Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- Button to Open Modal -->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i> Upload New Image
            </button>

            <!-- Image Upload Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload New Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Select Image</label>
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="caption" class="form-label">Caption (optional)</label>
                                    <input type="text" name="caption" id="caption" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="upload_image" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display Images -->
            <div class="row">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="<?php echo $image['image_path']; ?>" class="card-img-top equal-image" alt="Gallery Image">
                                <div class="card-body d-flex flex-column">
                                    <p class="card-text"><?php echo htmlspecialchars($image['caption']); ?></p>
                                    <form action="delete_image.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                        <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm mt-auto">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No images available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
