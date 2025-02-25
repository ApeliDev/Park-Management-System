<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';
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
            <h1 class="mb-4 text-center">Manage Tours</h1>

            <!-- Session Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Button to trigger Add Tour Modal -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTourModal">Add New Tour</button>

            <!-- Tours Table -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price (USD)</th>
                        <th>Capacity</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM tours";
                    $result = $conn->query($query);

                    while ($tour = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($tour['name']) ?></td>
                            <td><?= htmlspecialchars($tour['description']) ?></td>
                            <td><?= $tour['date'] ?></td>
                            <td><?= $tour['time'] ?></td>
                            <td><?= number_format($tour['price'], 2) ?></td>
                            <td><?= $tour['capacity'] ?></td>
                            <td>
                                <?php if (!empty($tour['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($tour['image_path']) ?>" alt="Tour Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTourModal<?= $tour['tour_id'] ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="delete_tour.php" method="POST" class="d-inline">
                                    <input type="hidden" name="tour_id" value="<?php echo $tour['tour_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this tour?');" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Tour Modal -->
                        <div class="modal fade" id="editTourModal<?= $tour['tour_id'] ?>" tabindex="-1" aria-labelledby="editTourLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="edit_tour.php" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTourLabel">Edit Tour</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="tour_id" value="<?= $tour['tour_id'] ?>">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($tour['name']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" required><?= htmlspecialchars($tour['description']) ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="date" class="form-label">Date</label>
                                                <input type="date" class="form-control" name="date" value="<?= $tour['date'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="time" class="form-label">Time</label>
                                                <input type="time" class="form-control" name="time" value="<?= $tour['time'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="<?= $tour['price'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="capacity" class="form-label">Capacity</label>
                                                <input type="number" class="form-control" name="capacity" value="<?= $tour['capacity'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image">
                                                <?php if (!empty($tour['image_path'])): ?>
                                                    <p class="mt-2">Current Image:</p>
                                                    <img src="<?= htmlspecialchars($tour['image_path']) ?>" alt="Current Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                                <?php endif; ?>
                                                
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
                    <?php endwhile; ?>
                </tbody>
            </table>


            <!-- Add Tour Modal -->
            <div class="modal fade" id="addTourModal" tabindex="-1" aria-labelledby="addTourLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="add_tour.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTourLabel">Add New Tour</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description"  placeholder="Enter Description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="time" class="form-control" name="time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" class="form-control" name="price"  placeholder="Enter price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" name="capacity"  placeholder="Enter capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Tour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
