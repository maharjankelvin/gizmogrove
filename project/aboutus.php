<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="assets/css/general_styles.css">
    <link rel="stylesheet" href="assets/css/aboutus.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <br>
    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to our website! We are dedicated to providing you with the best products and services.</p>
        <p>Our mission is to <span class="highlight">deliver high-quality</span> products to our customers while ensuring their <span class="highlight">complete satisfaction</span>.</p>
        <p>At <span class="highlight">Our Company</span>, we value <span class="highlight">integrity</span>, <span class="highlight">innovation</span>, and <span class="highlight">customer service</span>.</p>
        <p>Feel free to browse our website and <span class="highlight">contact us</span> if you have any questions or inquiries.</p>
        <div class="quote">
            <p>"The only way to do great work is to love what you do." - Steve Jobs</p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
