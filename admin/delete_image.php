<?php
require_once 'includes/auth.php';
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];

    // Fetch the image path
    $sql = "SELECT image_path FROM park_gallery WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();

    if ($image) {
        $image_path = $image['image_path'];

        // Delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the image record from the database
        $sql = "DELETE FROM park_gallery WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $image_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Image deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete image from the database.";
        }
    } else {
        $_SESSION['error'] = "Image not found.";
    }
    header("Location: gallery.php");
    exit();
}
?>
