<?php
include 'server/connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

$total = 0; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <script>
        function updateQuantity(productId, quantity) {
            document.getElementById('quantity-' + productId).value = quantity;
        }
            function updateQuantity(productId, quantity) {
                var price = document.querySelector('input[name="quantity[' + productId + ']"]').getAttribute('data-price');
                var total = document.querySelector('.total');
                total.innerHTML = 'Total: rs ' + (price * quantity);
            }
    </script>
</head>
<body>
    <?php 
        include 'navbar.php'; 
    ?>
    <div class="container">
        <h1>Shopping Cart</h1>
        <form action="checkout.php" method="post">
            <?php
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();

            if ($cart_result->num_rows > 0) {
                while ($item = $cart_result->fetch_assoc()) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];

                    $stmt = $conn->prepare("SELECT brand, model, price, product_image FROM products WHERE product_id = ?");
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $price = floatval($row['price']) * intval($quantity);
                        $total += $price;
            ?>
                        <div class="cart-item">
                            <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['product_image']); ?>" width="200px" alt="Product Image">
                            <div class="cart-item-details">
                                <h3><?php echo $row['brand'] . ' ' . $row['model']; ?></h3>
                                <p class="price">Price: rs <?php echo $price; ?></p>
                                <div class="quantity-container">
                                    <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="1" data-price="<?php echo $row['price']; ?>" onchange="updateQuantity(<?php echo $product_id; ?>, this.value)">                                </div>
                            </div>
                           <button><a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>">Remove from Cart</a></button>
                        </div>
            <?php
                    }
                    $stmt->close(); 
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
            <div class="total">
                Total: rs <?php echo $total; ?>
            </div>
            <div class="actions">
                <button type="submit" name="proceed_to_checkout">Proceed to Checkout</button>
            </div>
        </form>
    </div>
    <br>

    <?php include 'footer.php'; ?>

</body>
</html>