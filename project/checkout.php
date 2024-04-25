<?php
include_once 'server/connection.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    die('User not logged in');
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = $conn->prepare("SELECT * FROM Products WHERE Product_id = ?");
    $query->bind_param("i", $product_id);
    $query->execute();
    $product = $query->get_result()->fetch_assoc();
} else {
    die('Product not found');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script>
    function calculateTotalPrice() {
        var price = parseFloat(document.getElementById('price').value);
        var quantity = document.getElementById('quantity').value;
        var total_price = price * quantity;
        document.getElementById('total_price').value = total_price.toFixed(2);
    }
    </script>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .display_items {
            margin: auto;
           align-items: last baseline;
        }
    </style>
</head>
<body onload="calculateTotalPrice()">
    <?php include 'navbar.php'; ?>
    <div id="display_items">
        <h1>Checkout</h1>
        <h2><?php echo $product['brand']; ?></h2> 
        <h2><?php echo $product['model']; ?></h2>
        <h2><?php echo $product['processor']; ?></h2>
        <h2><?php echo $product['ram']; ?></h2>
        <h2><?php echo $product['storage_capacity']; ?></h2>
        <h2><?php echo $product['graphics_card']; ?></h2>
        <h2><?php echo $product['display_size']; ?></h2>
        <h2><?php echo $product['resolution']; ?></h2>

        <?php
            $imageData = $product['product_image'];
            $encodedImage = base64_encode($imageData);
        ?>
        <img src="data:image/jpeg;base64,<?php echo $encodedImage; ?>" width="200" height="200">      
    </div>   
    <br>
    <div>
        <form method="post" action="checkout_process.php">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" oninput="calculateTotalPrice()" required>
            <input type="hidden" id="price" value="<?php echo $product['price']; ?>">
            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" readonly>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Esewa">Esewa</option>
                <option value="khalti">khalti</option>
            </select>
            <label for="shipping_address">Shipping Address:</label>
            <input type="text" id="shipping_address" name="shipping_address" required>
            <input type="submit" name="checkout" value="Checkout">
        </form>
    </div>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>