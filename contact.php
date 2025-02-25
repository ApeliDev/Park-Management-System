<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Amboseli National Park</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/booking.css">
</head>
<body>

<?php include('includes/header.php'); ?>
    <!-- Header -->
    <header class="booking-header">
        <h1>Contact Amboseli National Park</h1>
        <p class="lead">We’d love to hear from you. Get in touch with us today!</p>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-6 mb-4">
                <h2>Send Us a Message</h2>
                <form action="submit_contact.php" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter Subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea id="message" name="message" rows="5" class="form-control"placeholder="Write your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="col-md-6 mb-4">
                <h2>Our Contact Information</h2>
                <ul class="list-unstyled mt-3">
                    <li><i class="bi bi-geo-alt-fill"></i> Address: Amboseli, Kenya</li>
                    <li><i class="bi bi-telephone-fill"></i> Phone: +254 700 123 456</li>
                    <li><i class="bi bi-envelope-fill"></i> Email: <a href="mailto:info@amboselinationalpark.co.ke">info@amboselinationalpark.co.ke</a></li>
                </ul>
                <h2>Follow Us</h2>
                <p>
                    <a href="https://facebook.com/amboseli" class="text-dark me-3"><i class="bi bi-facebook"></i></a>
                    <a href="https://twitter.com/amboseli" class="text-dark me-3"><i class="bi bi-twitter"></i></a>
                    <a href="https://instagram.com/amboseli" class="text-dark"><i class="bi bi-instagram"></i></a>
                </p>
            </div>
        </div>

        <!-- Map -->
        <div class="row">
            <div class="col-12">
                <h2>Find Us on the Map</h2>
                <div class="mt-3">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12697.35360352194!2d37.254574702198704!3d-2.6378393171867744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1841c6170b33f1a1%3A0xf0a1b1b83c59b894!2sAmboseli%20National%20Park!5e0!3m2!1sen!2ske!4v1695319586935!5m2!1sen!2ske" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

   <?php include('includes/footer.php'); ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
