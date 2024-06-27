<?php
include_once '../server/connection.php';
include_once 'sendmessage.php'; 

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $conn->prepare("UPDATE checkoutdetails SET OrderStatus = ? WHERE Checkout_id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("SELECT User_id FROM checkoutdetails WHERE Checkout_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $userId = $order['User_id'];

        if ($status == 'Cancelled') {
            sendMessage($userId, 'order_cancelled', 'additional_info');
        } elseif ($status == 'Confirmed') { 
            sendMessage($userId, 'order_confirmed', 'additional_info');
        } elseif ($status == 'Shipped') {
            sendMessage($userId, 'order_shipped', 'additional_info');
        } elseif ($status == 'Delivered') {
            sendMessage($userId, 'order_delivered', 'additional_info');
        }

        header('Location: orders.php?success=order_updated');
    } else {
        header('Location: orders.php?error=update_failed');
    }
} else {
    header('Location: orders.php?error=missing_parameters');
}