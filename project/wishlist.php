<?php
include_once 'server/connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location: login.php');
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = $conn->prepare("SELECT * FROM Products WHERE Product_id = ?");
    $query->bind_param("i", $product_id);
    $query->execute();
    $product = $query->get_result()->fetch_assoc();

    if ($product) {
        $query = $conn->prepare("SELECT * FROM wishlist WHERE User_id = ? AND Product_id = ?");
        $query->bind_param("ii", $user_id, $product_id);
        $query->execute();
        $wishlist_item = $query->get_result()->fetch_assoc();

        if ($wishlist_item) {
            echo "This product is already in your wishlist.";
        } else {
            $query = $conn->prepare("INSERT INTO wishlist (User_id, Product_id, DateAdded) VALUES (?, ?, NOW())");
            $query->bind_param("ii", $user_id, $product_id);
            $query->execute();

            if ($query->affected_rows > 0) {
                echo "Product added to wishlist.";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product not specified.";
}
?>