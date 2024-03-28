<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "gizmogrove";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    $stmt = $conn->prepare("SELECT user_id, user_type, Password FROM user_details WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION["username"] = $username; 

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

    $stmt->close();
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
        <h2>User Login</h2>
        <form action="#" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="registration.php">Sign up</a></p>
    </div>
</body>
</html>
