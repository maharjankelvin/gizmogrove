<?php
require_once('server/connection.php'); 

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
  if ($_SESSION["user_type"] == 'user') {
    header("Location: index.php");
    exit();
  } elseif ($_SESSION["user_type"] == 'admin') {
    header("Location: admin_panel/admin_homepage.php");
    exit();
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the form submission is for login
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user details from the database
    $sql = "SELECT * FROM user_details WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['Password'])) {

        // Password is correct, set session variables and redirect to dashboard
        if ($row['user_type'] == 'user') {
          $_SESSION['logged_in'] = true;
          $_SESSION['user_id'] = $row['User_id'];
          $_SESSION['username'] = $row['Username'];
          $_SESSION['real_name'] = $row['real_name']; // Store the real name in the session
          $_SESSION['user_type'] = $row['user_type'];

          header("Location: index.php");
          exit();
        } elseif ($row['user_type'] == 'admin') {
          $_SESSION['logged_in'] = true;
          $_SESSION['user_id'] = $row['User_id'];
          $_SESSION['username'] = $row['Username'];
          $_SESSION['real_name'] = $row['real_name']; // Store the real name in the session
          $_SESSION['user_type'] = $row['user_type'];

          header("Location: admin_panel/admin_homepage.php");
          exit();
        }
      } else {
        $login_error = "Invalid username or password";
      }
    } else {
      $login_error = "Invalid username or password";
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
    <?php if (isset($login_error)) { ?>
      <p><?php echo $login_error; ?></p>
    <?php } ?>
    <form action="./login.php" method="post">
      <label for="username">Username:</label><br>
      <input type="text" id="username" name="username" required><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br>
      <input type="submit" value="Login" name="login">
    </form>
    <p>Don't have an account? <a href="registration.php">Register</a></p>
  </div>

  <?php 
  if(isset($_SESSION['alert'])) {
    echo "<script>alert('".$_SESSION['alert']."');</script>";
    unset($_SESSION['alert']); // remove the alert message from the session
  }
  ?>

</body>

</html>