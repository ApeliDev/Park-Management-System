<?php
require_once 'includes/auth.php'; 
require_once '../includes/db_connection.php'; 

// Handle Form Submission for Adding Wildlife
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_wildlife'])) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $habitat = $_POST['habitat'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle Image Upload
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . '_' . $_FILES['image']['name']; 
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($image_name);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            // Image uploaded successfully
        } else {
            $_SESSION['error'] = "Image upload failed.";
            header("Location: wildlife_management.php"); 
            exit();
        }
    }

    // Insert Data into Database
    $sql = "INSERT INTO wildlife (name, species, habitat, status, title, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $species, $habitat, $status, $title, $description, $image_name);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Wildlife added successfully!";
        header("Location: wildlife_management.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Failed to add wildlife.";
    }
}

// Handle Deletion of Wildlife
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM wildlife WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Wildlife deleted successfully!";
        header("Location: wildlife_management.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Failed to delete wildlife.";
    }
}

// Fetch all wildlife from the database
$sql = "SELECT * FROM wildlife ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wildlife Management</title>
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
            <h1 class="mb-4">Manage Wildlife</h1>

            <!-- Display Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- Button to Open Modal -->
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addWildlifeModal">
                Add New Wildlife
            </button>

            <!-- Display Wildlife Table -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Habitat</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['species']; ?></td>
                            <td><?= $row['habitat']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['title']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td>
                                <?php if ($row['image']): ?>
                                    <img src="uploads/<?= $row['image']; ?>" alt="Wildlife Image" width="100">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="wildlife_management.php?delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this wildlife?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Wildlife Modal -->
    <div class="modal fade" id="addWildlifeModal" tabindex="-1" aria-labelledby="addWildlifeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWildlifeModalLabel">Add New Wildlife</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="wildlife_management.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" name="species" id="species" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="habitat" class="form-label">Habitat</label>
                            <select name="habitat" id="habitat" class="form-control" required>
                                <option value="">Select Habitat</option>
                                <option value="Forest">Forest</option>
                                <option value="Savanna">Savanna</option>
                                <option value="Desert">Desert</option>
                                <option value="Wetland">Wetland</option>
                                <option value="Grassland">Grassland</option>
                                <option value="Mountain">Mountain</option>
                                <option value="Ocean">Ocean</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="Endangered">Endangered</option>
                                <option value="Vulnerable">Vulnerable</option>
                                <option value="Least Concern">Least Concern</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" name="add_wildlife" class="btn btn-primary">Add Wildlife</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
