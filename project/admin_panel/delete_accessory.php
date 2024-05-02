<?php
include '../server/connection.php'; // Include your database connection file

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $_SESSION['product_deleted'] = true;
    header("Location: accessories.php");
    exit();
} else {
    header("Location: accessories.php?error=sql_error");
    exit();
}
?>