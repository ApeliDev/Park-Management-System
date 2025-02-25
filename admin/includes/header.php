<div class="header">
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        echo '<h5>Welcome, ' . htmlspecialchars($_SESSION['username']) . '</h5>';
    } else {
        echo '<h5>Welcome, Guest</h5>';
    }
    ?>
    <a href="../includes/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
