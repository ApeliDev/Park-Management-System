<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Visit - Amboseli National Park</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/booking.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <header class="booking-header">
        <h1>Book Your Visit to Amboseli National Park</h1>
        <p class="lead">Secure your visit by confirming your payment below!</p>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="payment-details">
                    <h3>Payment Details</h3>
                    <p>Please make your payment before booking. Below are the rates:</p>
                    <ul>
                        <li><strong>Adults (Kenyan Citizens):</strong> KES 500</li>
                        <li><strong>Children (Kenyan Citizens):</strong> KES 250</li>
                        <li><strong>Adults (Foreigners):</strong> USD 20</li>
                        <li><strong>Children (Foreigners):</strong> USD 10</li>
                        <li><strong>Vehicle Entry Fee:</strong> KES 300</li>
                    </ul>
                    <p><strong>Payment Methods:</strong></p>
                    <ul>
                        <li><strong>Mpesa Paybill:</strong> 123456 (Account Name: Amboseli)</li>
                        <li><strong>Bank Transfer:</strong> Amboseli National Park, ABC Bank, Account No. 987654321</li>
                    </ul>
                    <p>After making the payment, keep the transaction code for verification during the booking process.</p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="booking-form-container">
                    <form action="process_booking.php" method="POST">
                        <div class="mb-4">
                            <h4>Personal Information</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                </div>
                            </div>
                        </div>
            
                        <div class="mb-4">
                            <h4>Contact Information</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid Email address" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+254754497441" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>Visit Details</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="visit_date" class="form-label">Date of Visit</label>
                                    <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="number_of_people" class="form-label">Number of People</label>
                                    <input type="number" class="form-control" id="number_of_people" name="number_of_people" min="1" placeholder="Enter number of people" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>Payment Confirmation</h4>
                            <label for="transaction_code" class="form-label">Transaction Code</label>
                            <input type="text" class="form-control" id="transaction_code" name="transaction_code" placeholder="Enter your payment transaction code" required>
                        </div>

                        <button type="submit" class="btn btn-custom w-100">Submit Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <?php include('includes/loader.php'); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
