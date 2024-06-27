<?php
function sendMessage($userId, $notification_Type, $product_id, $brand = '', $model = '') {
    global $conn;

    switch ($notification_Type) {
        case 'order_placed':
            $message = "Your order for {$brand} {$model} has been placed!";
            break;
        case 'order_confirmed':
            $message = "Your order for {$brand} {$model} has been confirmed.";
            break;
        case 'order_cancelled':
            $message = "Your order for {$brand} {$model} has been cancelled.";
            break;
        case 'order_shipped':
            $message = "Your order for {$brand} {$model} has been shipped.";
            break;
        case 'order_delivered':
            $message = "Your order for {$brand} {$model} has been delivered.";
            break;
        default:
            $message = "Unknown notification type.";
            break;
    }

    $stmt = $conn->prepare("INSERT INTO user_messages (user_id, message, notification_type, product_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $userId, $message, $notification_Type, $product_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>