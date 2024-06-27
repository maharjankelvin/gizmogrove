<?php
require_once('../server/connection.php'); 

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $conn->prepare("UPDATE user_details SET status = ? WHERE User_id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: users.php?success=1");
        exit();
    } else {
        header("Location: users.php?error=1");
        exit();
    }
} else {
    header("Location: users.php");
    exit();
}