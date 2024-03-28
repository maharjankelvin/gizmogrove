<?php
session_start();
include_once 'server/connection.php';

// Check if form is submitted for adding items to cart
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['source'])) {
    $product_id = $_GET['id'];
    $source = $_GET['source'];

    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $price = $row['price'];
        $quantity = 1; 

        if(isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $price,
                'quantity' => $quantity
            );
        }

        // Redirect to appropriate page after adding to cart
        if($source === 'index') {
            header('Location: index.php?added_to_cart=true');
        } elseif($source === 'product_description') {
            header('Location: product_description.php?id=' . $product_id . '&added_to_cart=true');
        } else {
            header('Location: index.php?added_to_cart=true');
        }
        exit();
    } else {
        // Redirect with error message if product not found
        if($source === 'index') {
            header('Location: index.php?error=product_not_found');
        } elseif($source === 'product_description') {
            header('Location: product_description.php?id=' . $product_id . '&error=product_not_found');
        } else {
            header('Location: index.php?error=product_not_found');
        }
        exit();
    }
} else {
    // Redirect with error message if required parameters are missing
    header('Location: index.php?error=missing_parameters');
    exit();
}

$conn->close();
?>
