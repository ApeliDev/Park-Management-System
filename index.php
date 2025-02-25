<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboseli National Park</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <video autoplay muted loop>
            <source src="images/video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="content">
            <h1 class="hero-title">Welcome to Amboseli National Park</h1>
            <p class="hero-subtitle">Discover the beauty of nature and wildlife.</p>
            <a href="tours.php" class="btn btn-custom btn-lg mt-3">Explore Now</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container text-center">
            <h2 class="mb-5">What We Offer</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-paw fa-3x mb-3" style="color: #6a11cb;"></i>
                            <h5 class="card-title">Wildlife Tracking</h5>
                            <p class="card-text">Explore Amboseli's incredible wildlife, from elephants to lions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-map-marker-alt fa-3x mb-3" style="color: #2575fc;"></i>
                            <h5 class="card-title">Guided Tours</h5>
                            <p class="card-text">Join our expert guides for an unforgettable safari experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-tree fa-3x mb-3" style="color: #6a11cb;"></i>
                            <h5 class="card-title">Scenic Locations</h5>
                            <p class="card-text">Visit breathtaking locations within the park.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Explore Amboseli Section -->
    <section id="explore" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Explore Amboseli National Park</h2>
            <p class="mb-5 text-muted">
                Discover the stunning landscapes, rich biodiversity, and cultural heritage that make Amboseli one of Africa's top destinations.
            </p>
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                        <img src="images/elephants.jpg" class="card-img-top" alt="Elephants">
                        <div class="card-body">
                            <h5 class="card-title">Meet the Giants</h5>
                            <p class="card-text">
                                Witness herds of majestic elephants against the breathtaking backdrop of Mount Kilimanjaro.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                        <img src="images/animal1.jpg" class="card-img-top" alt="Lions">
                        <div class="card-body">
                            <h5 class="card-title">Big Cat Adventures</h5>
                            <p class="card-text">
                                Spot lions, cheetahs, and leopards as they roam freely in their natural habitat.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                        <img src="images/animal2.jpg" class="card-img-top" alt="Sunset">
                        <div class="card-body">
                            <h5 class="card-title">Scenic Sunsets</h5>
                            <p class="card-text">
                                Experience unforgettable sunsets that paint the Amboseli skies with vibrant hues.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
