<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with a secure way to store credentials
$database = "gizmogrove";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Hash the password with salting (using PASSWORD_ARGON2I)
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare and bind the statement
  $stmt = $conn->prepare("INSERT INTO user_details (name, email, username, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $username, $hashed_password);

  if ($stmt->execute()) {
    echo "<script>alert('Registered successfully.\\n You can now login.');";
    echo "window.location='login.php';</script>";
  } else {
    echo "Error: " . $stmt->error; // Display error message for debugging
  }

  $stmt->close(); // Close the statement
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
</head>
<body>
    <div>
    <h2>User Registration</h2>
    <form action="#" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Sign in</a></p>
    </div>
</body>
</html>
