<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include the database connection file
    include '../utils/db.php';

    // Define validation function
    function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate username/email
    $username = validateInput($_POST["username"]);
    // Validate password
    $password = validateInput($_POST["password"]);

    // Query to check user credentials
    $query = "SELECT * FROM users_details WHERE (username='$username' OR email='$username')";
    $result = $mysqli->query($query);

    if ($result) {
        if ($result->num_rows == 1) {
            // User found, verify password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect to dashboard or desired page
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                // Redirect to dashboard or desired page
                header("Location: /HamroYatayat/index.php");
                exit();
            } else {
                // Password is incorrect
                $error_message = "Incorrect password";
            }
        } else {
            // User not found
            $error_message = "User not found";
        }
    } else {
        // Error executing query
        $error_message = "Error executing the query: " . $mysqli->error;
    }

    // Close database connection
    $mysqli->close();

    // Redirect back to login page with error message
    header("Location: /HamroYatayat/login.php?message=" . urlencode($error_message));
    exit();
}
?>
