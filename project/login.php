<?php
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

    // Prepare and bind the statement
    $stmt = $conn->prepare("SELECT user_id, user_type, password FROM user_details WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Directly compare plaintext passwords
        if ($password === $row['password']) {
            // Start session and set user ID
            session_start();
            $_SESSION['user_id'] = $row['id'];

            // Check user type and redirect accordingly
            if ($row['user_type'] == 'user') {
                $_SESSION["username"]=$username;
                // Redirect user to user page
                header("Location: index.php");
                exit();
            } elseif ($row['user_type'] == 'admin') {
                $_SESSION["username"]=$username;
                // Redirect admin to admin panel
                header("Location: admin_panel.php");
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
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file for styling -->
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