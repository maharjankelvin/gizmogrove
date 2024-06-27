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
    <?php 
    include('server/connection.php'); 
    include('navbar.php'); 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_SESSION['user_id'])) { 
            $_SESSION['alert'] = "Please login to continue.";
            header('Location: login.php');
            exit();
        }
        $_user_id = $_SESSION['user_id'];

        $message = $_POST['message'];

        $stmt = $conn->prepare("INSERT INTO contact_messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $_user_id, $message);
        
        if ($stmt->execute()) {
            echo "Message sent successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); 
    }
    ?>
    
    <div class="container-contact">
        <h1>Contact Us</h1>
        <p>Have a question or feedback? Feel free to get in touch with us.</p>
        <div class="contact-form">
            <form action="contact.php" method="POST">
                <textarea name="message" placeholder="Your Message" rows="4" required></textarea><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>