<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <style>
        .product-box {
            border: 1px solid #000;
            padding: 10px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <?php
include('server/connection.php'); ?>
    <?php include('navbar.php'); ?>
    <h1>Wishlist</h1>
    <?php
   

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT Products.* FROM products JOIN wishlist ON wishlist.Product_id = Products.Product_id WHERE wishlist.User_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            while($product = $result->fetch_assoc()) {
                echo "<div class='product-box'>";
                echo "<h2>" . htmlspecialchars($product['brand']) . "</h2>";
                echo "<h2>" . htmlspecialchars($product['model']) . "</h2>";
                echo "<p>" . htmlspecialchars($product['processor']) . "</p>";
                echo "<p>" . htmlspecialchars($product['ram']) . "</p>";
                echo "<p>" . htmlspecialchars($product['storage_capacity']) . "</p>";
                echo "<p>" . htmlspecialchars($product['graphics_card']) . "</p>";
                echo "<p>" . htmlspecialchars($product['display_size']) . "</p>";
                echo "<p>" . htmlspecialchars($product['resolution']) . "</p>";
                echo "<p>" . htmlspecialchars($product['price']) . "</p>";
                $image_data = base64_encode($product['product_image']);
                $image_src = 'data:image/jpeg;base64,' . $image_data;
                echo "<img src='" . htmlspecialchars($image_src) . "' width='200px' height='200px'>";
                echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                echo "<form action='remove_from_user_wishlist.php' method='post'>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($product['product_id']) . "'>";
                echo "<button type='submit'>Remove from wishlist</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "Your wishlist is empty.";
        }

        $stmt->close();
        $conn->close();
    } else {
        header('Location: login.php');
        exit();
    }
    ?>

    <?php include('footer.php'); ?>
</body>
</html>