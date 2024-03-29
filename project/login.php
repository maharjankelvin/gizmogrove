<?php
session_start(); // Start the session to persist user login state

$servername = "localhost";
$username = "root";
$password = ""; // Replace with a secure way to store credentials
$database = "gizmogrove";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the form submission is for login
  if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user details from the database
    $stmt = $conn->prepare("SELECT * FROM user_details WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['Password'])) {

        // Password is correct, set session variables and redirect to dashboard
        if ($row['user_type'] == 'user') {
            header("Location: index.php");  
            exit();
          } elseif ($row['user_type'] == 'admin') {
            header("Location: admin_panel/admin_homepage.php"); 
            exit();
          }
        } else {
          echo "Invalid username or password";
        }
      } else {
        echo "Invalid username or password";
      }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div>
    <h2>Login</h2>
    <form action="./login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login" name="login">
    </form>
    <?php if(isset($login_error)) { ?>
      <p><?php echo $login_error; ?></p>
    <?php } ?>
    <p>Don't have an account? <a href="registration.php">Register</a></p>
    </div>
</body>
</html>