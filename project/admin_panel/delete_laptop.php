<?php
include_once '../server/connection.php';

$product_id = $_GET['id']; 

$stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: admin_homepage.php");
exit();

?>
