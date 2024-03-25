<?php

include_once 'server/connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error deleting user.";
    }
} else {
    echo "User ID not provided.";
}
?>
