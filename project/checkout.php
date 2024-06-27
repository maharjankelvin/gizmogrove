<?php
include_once 'server/connection.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    die('User not logged in');
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
} else {
    die('No products in cart');
}

$products = [];
foreach ($product_ids as $product_id) {
    $query = $conn->prepare("SELECT * FROM Products WHERE Product_id = ?");
    $query->bind_param("i", $product_id);

    if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product['quantity'] = array_key_exists($product_id, $quantities) ? $quantities[$product_id] : 0;
            $products[] = $product;
        } else {
            die('No product found with id ' . $product_id);
        }
    } else {
        die('Query failed: ' . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .display_items {
            margin: auto;
           align-items: last baseline;
        }
        .product {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
    </style>

    
</head>
<body onload="calculateTotalPrice()">
    <?php include 'navbar.php'; ?>
    <div id="display_items">
        <h1>Checkout</h1>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo $product['brand']; ?></h2> 
                <h2><?php echo $product['model']; ?></h2>
                <h2><?php echo $product['processor']; ?></h2>
                <h2><?php echo $product['ram']; ?></h2>
                <h2><?php echo $product['storage_capacity']; ?></h2>
                <h2><?php echo $product['graphics_card']; ?></h2>
                <h2><?php echo $product['display_size']; ?></h2>
                <h2><?php echo $product['resolution']; ?></h2>
                <h2><?php echo $product['price']; ?></h2>

                <?php
                    $imageData = $product['product_image'];
                    $encodedImage = base64_encode($imageData);
                ?>
                <img src="data:image/jpeg;base64,<?php echo $encodedImage; ?>" width="200" height="200">
                <h2>Quantity: <?php echo $product['quantity']; ?></h2>
            </div>
        <?php endforeach; ?>
    </div>   
    <br>
    <div>
        <form method="post" action="checkout_process.php">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <?php foreach ($products as $product): ?>
                <input type="hidden" name="product_id[]" value="<?php echo isset($product['product_id']) ? $product['product_id'] : ''; ?>">
                <input type="hidden" class="quantity" name="quantity[<?php echo isset($product['product_id']) ? $product['product_id'] : ''; ?>]" value="<?php echo isset($product['quantity']) ? $product['quantity'] : 0; ?>">
                <input type="hidden" class="price" value="<?php echo $product['price']; ?>">
            <?php endforeach; ?>
            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" readonly><br><br>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">Not Selected</option>
                <option value="Esewa">Esewa</option>
                <option value="khalti">khalti</option>
            </select>
            <br><br>
            <div id="payment_form" style="display: none; ">
                <label for="payment_number">Payment Number:</label>
                <input type="phone" id="payment_number" name="payment_number" required><br><br>
            </div>
            <img id="payment_image" style="display: none;">
            <label for="shipping_address">Shipping Address:</label>
            <input type="text" id="shipping_address" name="shipping_address" required>
            <input type="submit" name="checkout" value="Checkout">
        </form>
    </div>
    <br>
    <?php include 'footer.php'; ?>
    <script>
        window.onload = function() {
            var form = document.querySelector('form');
            var paymentMethod = document.querySelector('#payment_method');
            var shippingAddress = document.querySelector('#shipping_address');
            var paymentForm = document.querySelector('#payment_form');
            var paymentImage = document.querySelector('#payment_image');

            form.addEventListener('submit', function(event) {
                if (paymentMethod.value === '') {
                    alert('Please select a payment method.');
                    event.preventDefault();
                }

                if (shippingAddress.value.trim() === '') {
                    alert('Please enter a shipping address.');
                    event.preventDefault();
                }
            });

            paymentMethod.addEventListener('change', function() {
                switch(paymentMethod.value) {
                    case 'Esewa':
                        paymentImage.src = 'assets/images/esewa.JPG';
                        break;
                    case 'khalti':
                        paymentImage.src = 'assets/images/khalti.PNG';
                        break;
                    default:
                        paymentImage.src = '';
                }

                if (paymentMethod.value !== '') {
                    paymentForm.style.display = 'block';
                    paymentImage.style.display = 'block';
                    paymentImage.style.width = '100px';
                    paymentImage.style.height = '100px'; 
                } else {
                    paymentForm.style.display = 'none';
                    paymentImage.style.display = 'none';
                }
            });

            calculateTotalPrice();
        };

        function calculateTotalPrice() {
            var total_price = 0;
            var prices = document.getElementsByClassName('price');
            var quantities = document.getElementsByClassName('quantity');
            for (var i = 0; i < prices.length; i++) {
                total_price += parseFloat(prices[i].value) * quantities[i].value;
            }
            document.getElementById('total_price').value = total_price.toFixed(2);
        }

        calculateTotalPrice();
</script>
</body>
</html>