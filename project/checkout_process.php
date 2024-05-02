<?php
include_once 'server/connection.php';

if (isset($_POST['checkout'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $shipping_address = $_POST['shipping_address'];

    do {
        $checkout_id = rand(1000, 9999);
        $stmt = $conn->prepare("SELECT * FROM checkoutdetails WHERE Checkout_id = ?");
        $stmt->bind_param("i", $checkout_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);

    $checkout = $conn->prepare("INSERT INTO checkoutdetails (Checkout_id, User_id, Product_id, Quantity, TotalPrice, PaymentMethod, ShippingAddress, OrderStatus, OrderDate) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
    $checkout->bind_param("iiidsss", $checkout_id, $user_id, $product_id, $quantity, $total_price, $payment_method, $shipping_address);

    if ($checkout->execute()) {
        // Remove item from cart
        $remove_from_cart = $conn->prepare("DELETE FROM cart WHERE User_id = ? AND Product_id = ?");
        $remove_from_cart->bind_param("ii", $user_id, $product_id);
        $remove_from_cart->execute();

        echo "<script>alert('Order placed successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    if (strpos($_SERVER['HTTP_REFERER'], 'product_description.php') !== false) {
        echo "<script>window.location.href='product_description.php?id=$product_id';</script>";
    } else if (strpos($_SERVER['HTTP_REFERER'], 'cart.php') !== false) {
        echo "<script>window.location.href='cart.php';</script>";
    } else {
        echo "<script>window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    }
}
?>