<?php
require_once('includes/auth.php');
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $price = trim($_POST['price']);
    $capacity = trim($_POST['capacity']);
    $imagePath = null;

    // Validation
    if (empty($name) || empty($description) || empty($date) || empty($time) || empty($price) || empty($capacity)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: manage_tours.php');
        exit;
    }

    if (!is_numeric($price) || $price <= 0) {
        $_SESSION['error'] = 'Price must be a positive number.';
        header('Location: manage_tours.php');
        exit;
    }

    if (!is_numeric($capacity) || $capacity <= 0) {
        $_SESSION['error'] = 'Capacity must be a positive number.';
        header('Location: manage_tours.php');
        exit;
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/tours/'; 
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); 
        }

        $fileName = basename($_FILES['image']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileType), $allowedTypes)) {
            $newFileName = uniqid('amboseli_', true) . '.' . $fileType;
            $targetFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath; // Store the file path
            } else {
                $_SESSION['error'] = 'Failed to upload the image.';
                header('Location: manage_tours.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.';
            header('Location: manage_tours.php');
            exit;
        }
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO tours (name, description, date, time, price, capacity, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdis", $name, $description, $date, $time, $price, $capacity, $imagePath);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Tour added successfully!';
    } else {
        $_SESSION['error'] = 'Failed to add the tour. Please try again.';
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