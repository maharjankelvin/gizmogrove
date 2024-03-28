<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php 
        include 'navbar.php';
    ?>
    <div class="container">
        <h1>Shopping Cart</h1>
        <form method="post">
            <div class="cart">
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $item) {
                        // Fetch product details from the database
                        $sql = "SELECT * FROM products WHERE product_id = $product_id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $price = floatval($row['price']) * intval($item['quantity']);
                            $total += $price;
                            echo "<div class='cart-item'>";
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['product_image']) . "' width='200px' alt='Product Image'>";
                            echo "<div class='cart-item-details'>";
                            echo "<h3>" . $row['product_name'] . "</h3>";
                            echo "<p class='price'>Price: $" . $price . "</p>";
                            echo "<div class='quantity-container'>";
                            echo "<input type='number' name='quantity[$product_id]' value='" . $item['quantity'] . "' min='1'>";
                            echo "</div>";
                            echo "<input type='checkbox' name='remove[$product_id]' class='remove-checkbox'><label>Remove</label>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>
            <div class="total">
                Total: $<?php echo isset($total) ? $total : 0; ?>
            </div>
            <div class="actions">
                <button type="submit" name="remove_from_cart">Remove Selected Items</button>
                <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
            </div>
        </form>
    </div>
</body>
</html>
