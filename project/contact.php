<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/css/general_styles.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/contact.css">
</head>
<body>
    <?php include('server/connection.php'); ?>
    <?php include('navbar.php'); ?>
    

    <div class="container-contact">
        <h1>Contact Us</h1>
        <p>Have a question or feedback? Feel free to get in touch with us.</p>
        <div class="contact-form">
            <form action="submit_contact.php" method="POST">
                <input type="text" name="name" placeholder="Your Name" required><br>
                <input type="email" name="email" placeholder="Your Email" required><br>
                <textarea name="message" placeholder="Your Message" rows="4" required></textarea><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
