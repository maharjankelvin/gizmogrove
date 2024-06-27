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
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_details WHERE Username = '$username' AND status = 'active'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['Password'])) {

        if ($row['user_type'] == 'user') {
          $_SESSION['logged_in'] = true;
          $_SESSION['user_id'] = $row['User_id'];
          $_SESSION['username'] = $row['Username'];
          $_SESSION['real_name'] = $row['real_name']; 
          $_SESSION['user_type'] = $row['user_type'];

          header("Location: index.php");
          exit();
        } elseif ($row['user_type'] == 'admin') {
          $_SESSION['logged_in'] = true;
          $_SESSION['user_id'] = $row['User_id'];
          $_SESSION['username'] = $row['Username'];
          $_SESSION['real_name'] = $row['real_name']; 
          $_SESSION['user_type'] = $row['user_type'];

          header("Location: admin_panel/admin_homepage.php");
          exit();
        }
      } else {
        $login_error = "Invalid username or password or account is suspended ";
      }
    } else {
      $login_error = "Invalid username or password or account is suspended";
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
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (isset($login_error)) { ?>
      <p><?php echo $login_error; ?></p>
    <?php } ?>
    <form class="login-form" action="./login.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <input type="submit" value="Login" name="login">
    </form>
    <p>Don't have an account? <a href="registration.php">Register</a></p>
  </div>

  <?php 
  if(isset($_SESSION['alert'])) {
    echo "<script>alert('".$_SESSION['alert']."');</script>";
    unset($_SESSION['alert']); 
  }
  ?>

</body>

</html>