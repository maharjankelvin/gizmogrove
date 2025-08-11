<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "ShopEase";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format.');";
    echo "window.history.back();</script>";
    exit;
  }

  if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match.');";
    echo "window.history.back();</script>";
    exit;
  }

  if (strlen($password) < 8) {
    echo "<script>alert('Password must be at least 8 characters long.');";
    echo "window.history.back();</script>";
    exit;
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO user_details (name, email, username, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $username, $hashed_password);

  if ($stmt->execute()) {
    echo "<script>alert('Registered successfully.\\n You can now login.');";
    echo "window.location='login.php';</script>";
  } else {
    echo "Error: " . $stmt->error; 
  }

  $stmt->close(); 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="assets/css/registration.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
</head>

<body>

  <?php include('navbar.php'); ?>

  <div class="registration-container">
    <h2>User Registration</h2>
    <form action="#" method="post">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Sign in</a></p>
  </div>
</body>

</html>