<?php
include_once 'server/connection.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['source'])) {
    $product_id = $_GET['id'];
    $source = $_GET['source'];

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $quantity = 1;
        $user_id = $_SESSION['user_id'];

        // Assuming you have a logged in user with id $user_id
        $sql = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
        $cart_result = $stmt->get_result();

        if ($cart_result->num_rows > 0) {
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product_id, $user_id);
        } else {
            $sql = "INSERT INTO cart (product_id, user_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $product_id, $user_id, $quantity);
        }
        $stmt->execute();

        if($source === 'index') {
            header('Location: index.php?added_to_cart=true');
        } elseif($source === 'product_description') {
            header('Location: product_description.php?id=' . $product_id . '&added_to_cart=true');
        } elseif($source === 'compare') {
            header('Location: compare.php?added_to_cart=true');
        } else {
            header('Location: index.php?added_to_cart=true');
        }
        exit();
    } else {
        if($source === 'index') {
            header('Location: index.php?error=product_not_found');
        } elseif($source === 'product_description') {
            header('Location: product_description.php?id=' . $product_id . '&error=product_not_found');
        } elseif($source === 'compare') {
            header('Location: compare.php?error=product_not_found');
        } else {
            header('Location: index.php?error=product_not_found');
        }
        exit();
    }
} else {
    header('Location: index.php?error=missing_parameters');
    exit();
}