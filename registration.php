<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "website_registration";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "INSERT INTO registration (username, password) VALUES ('$username','$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered successfully.\\nYou can now login.');";
        echo "window.location='login.html';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
