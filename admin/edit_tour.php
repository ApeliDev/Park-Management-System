<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $tour_id = intval($_POST['tour_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $price = floatval(trim($_POST['price']));
    $capacity = intval(trim($_POST['capacity']));

    // Handle image upload
    $image = null;  // Default to no image

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Validate image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($image_extension), $allowed_extensions)) {
            $_SESSION['error'] = 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.';
            header('Location: manage_tours.php');
            exit;
        }

        // Check file size (optional, example: max 2MB)
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = 'Image size exceeds the maximum limit of 2MB.';
            header('Location: manage_tours.php');
            exit;
        }

        // If new image is uploaded, delete the old image
        $old_image = $_POST['current_image'];
        if ($old_image && file_exists($old_image)) {
            unlink($old_image);  // Delete the old image
        }

        // Move image to the desired directory
        $image = 'uploads/tours/' . time() . '_' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            $_SESSION['error'] = 'Failed to upload the image. Please try again.';
            header('Location: manage_tours.php');
            exit;
        }
    } else {
        // If no new image is uploaded, keep the current image
        $image = $_POST['current_image'];
    }

    // Validation
    if (empty($name) || empty($description) || empty($date) || empty($time) || empty($price) || empty($capacity)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: manage_tours.php');
        exit;
    }

    if ($price <= 0) {
        $_SESSION['error'] = 'Price must be a positive number.';
        header('Location: manage_tours.php');
        exit;
    }

    if ($capacity <= 0) {
        $_SESSION['error'] = 'Capacity must be a positive number.';
        header('Location: manage_tours.php');
        exit;
    }

    // Update query
    $stmt = $conn->prepare("UPDATE tours SET name = ?, description = ?, date = ?, time = ?, price = ?, capacity = ?, image_path = ? WHERE tour_id = ?");
    $stmt->bind_param("ssssdiis", $name, $description, $date, $time, $price, $capacity, $image, $tour_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Tour updated successfully!';
    } else {
        $_SESSION['error'] = 'Failed to update the tour. Please try again.';
    }

    $stmt->close();
    $conn->close();

    // Redirect back to manage tours page
    header('Location: manage_tours.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: manage_tours.php');
    exit;
}
?>
