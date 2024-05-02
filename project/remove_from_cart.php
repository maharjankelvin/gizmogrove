<?php
include 'server/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
    $stmt->execute();
    header('Location: cart.php?removed=true');
    exit();
}
?>