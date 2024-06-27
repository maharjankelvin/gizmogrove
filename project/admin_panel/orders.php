<?php
require_once('../server/connection.php');

$result = $conn->query("SELECT checkoutdetails.*, products.price FROM checkoutdetails INNER JOIN products ON checkoutdetails.Product_id = products.product_id");

$orders = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">

</head>

<body>
    <?php include('admin_nav_bar.php'); ?>

    <h1>Manage Orders</h1>
    <main>
        <script>
            <?php if (isset($_GET['success'])) : ?>
                alert("Order status updated successfully");
            <?php elseif (isset($_GET['error'])) : ?>
                alert("Failed to update order status");
            <?php endif; ?>
        </script>

        <table>
            <tr>
                <th>Checkout ID</th>
                <th>User ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Payment Method</th>
                <th>Payment Number</th>
                <th>Shipping Address</th>
                <th>Order Date</th>
                <th>Total</th>
                <th>Order Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo $order['Checkout_id']; ?></td>
                    <td><?php echo $order['User_id']; ?></td>
                    <td><?php echo $order['Product_id']; ?></td>
                    <td><?php echo $order['Quantity']; ?></td>
                    <td><?php echo $order['PaymentMethod']; ?></td>
                    <td><?php echo $order['payment_number']; ?></td>
                    <td><?php echo $order['ShippingAddress']; ?></td>
                    <td><?php echo $order['OrderDate']; ?></td>

                    <td><?php echo $order['Quantity'] * $order['price']; ?></td>
                    <td><?php echo $order['OrderStatus']; ?></td>

                    <td>
                        <?php if ($order['OrderStatus'] == 'Pending') : ?>
                            <a href="update_order.php?id=<?php echo $order['Checkout_id']; ?>&status=Delivered">Delivered</a>
                            <a href="update_order.php?id=<?php echo $order['Checkout_id']; ?>&status=Cancelled">Cancelled</a>
                            <a href="update_order.php?id=<?php echo $order['Checkout_id']; ?>&status=Shipped">Shipped</a>
                            <a href="update_order.php?id=<?php echo $order['Checkout_id']; ?>&status=Confirmed">Confirmed</a>
                        <?php else : ?>
                            <a href="update_order.php?id=<?php echo $order['Checkout_id']; ?>&status=Pending">Pending</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>

</html>