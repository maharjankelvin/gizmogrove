<?php
include_once 'server/connection.php';
include_once 'admin_panel/sendmessage.php';

if (isset($_POST['checkout'])) {
    $user_id = $_POST['user_id'];
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $payment_number = $_POST['payment_number'];
    $shipping_address = $_POST['shipping_address'];

    $orderPlaced = false; 

    $checkout = $conn->prepare("INSERT INTO checkoutdetails (User_id, Product_id, Quantity, PaymentMethod, payment_number, ShippingAddress, OrderStatus) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $remove_from_cart = $conn->prepare("DELETE FROM cart WHERE User_id = ? AND Product_id = ?");
    $check_product = $conn->prepare("SELECT * FROM products WHERE product_id = ?");

    foreach ($product_ids as $product_id) {
        $quantity = $quantities[$product_id];

        $check_product->bind_param("i", $product_id);
        $check_product->execute();
        $product_result = $check_product->get_result();

        if ($product_result->num_rows > 0) {
            $productRow = $product_result->fetch_assoc();
            $brand = $productRow['brand'];
            $model = $productRow['model'];

            $checkout->bind_param("iiisis", $user_id, $product_id, $quantity, $payment_method, $payment_number, $shipping_address);
            if ($checkout->execute()) {
                $remove_from_cart->bind_param("ii", $user_id, $product_id);
                $remove_from_cart->execute();

                if (sendMessage($user_id, 'order_placed', $product_id, $brand, $model)) {
                    $_SESSION['success_message'] = "Order for {$brand} {$model} placed successfully!";
                    $orderPlaced = true; 
                } else {
                    $_SESSION['failure_message'] = "Order was not placed!";
                }
            } else {
                $_SESSION['error_message'] = "Checkout failed for one or more items.";
                break; 
            }
        } else {
            $_SESSION['error_message'] = "Product not found.";
            break; 
        }
    }

    if ($orderPlaced) {
        header('Location: cart.php');
        exit();
    } else {
        header('Location: cart.php?error=' . urlencode($_SESSION['error_message']));
        exit();
    }
}