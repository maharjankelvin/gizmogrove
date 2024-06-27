<?php
include_once 'server/connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $rating = "SELECT AVG(rating_value) as rating FROM ratings WHERE product_id = $product_id";
    $rating = $conn->query($rating);

    $review = "SELECT * FROM reviews WHERE product_id = $product_id ORDER BY review_id DESC";
    $review = $conn->query($review);

    $product = "SELECT * FROM products WHERE product_id = $product_id";
    $product = $conn->query($product);

    if ($product->num_rows > 0) {
    $row = $product->fetch_assoc();

    $brand = $row['brand'];
    $model = $row['model'];
    $price = $row['price'];
    $image = $row['product_image'];
    $product_type = $row['product_type'];
    $description = $row['description'];

    if ($product_type == 'laptop') {
        $processor = $row['processor'];
        $ram = $row['ram'];
        $storage_capacity = $row['storage_capacity'];
        $graphics_card = $row['graphics_card'];
        $display_size = $row['display_size'];
        $resolution = $row['resolution'];
    }
} else {
    echo "Product not found.";
    exit();
}
} else {
    echo "Product ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($product_name) ? $product_name : "Product Description"; ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .product-info {
            margin-bottom: 20px;
        }

        .product-info img {
            width: 300px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .product-info h2 {
            margin-bottom: 10px;
        }

        .product-info p {
            margin-bottom: 10px;
        }

        .buttons {
            text-align: center;
        }

        .buttons button {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buttons button:hover {
            background-color: #555;
        }
        </style>

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body>
    <div class="container">
        <?php include('navbar.php'); ?>
        <div class="product-info">
            <?php if (isset($image)) : ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="<?php echo isset($product_name) ? $product_name : "Product Image"; ?>">
            <?php endif; ?>
            <div>
            <p>
                <strong>
                    Rating:
                    <?php if ($rating->num_rows > 0) : ?>
                        <?php $row = $rating->fetch_assoc(); ?>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if ($i <= round($row['rating'])) : ?>
                                <a href="rate_product.php?id=<?= $product_id ?>&rating=<?= $i ?>">&#9733;</a>
                            <?php else : ?>
                                <a href="rate_product.php?id=<?= $product_id ?>&rating=<?= $i ?>">&#9734;</a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php else : ?>
                        <p>No ratings found.</p>
                    <?php endif; ?>
                </strong>
                <a href="add_to_wishlist.php?id=<?= $product_id ?>&source=product_description" class="heart"></a>
            </p>
            <?php            
                if(isset($product_id)) {
                    if(isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
            
                        $check_stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
                        $check_stmt->bind_param("ii", $user_id, $product_id);
                        $check_stmt->execute();
                        $check_result = $check_stmt->get_result();
            
                        if($check_result->num_rows > 0) {
                            echo "<i class='fas fa-heart' style='color:red' onclick=\"window.location.href='remove_from_wishlist.php?id=$product_id'\"></i>";
                        } else {
                            echo "<i class='far fa-heart' onclick=\"window.location.href='add_to_wishlist.php?id=$product_id'\"></i>";
                        }
            
                        $check_stmt->close();
                    } else {
                        echo "<i class='far fa-heart' onclick=\"window.location.href='login.php'\"></i>";
                    }
                } else {
                    echo "Product ID is not set.";
                }
            ?>
            <br>
                <h2><?php echo isset($brand) ? $brand : "Brand"; ?> <?php echo isset($model) ? $model : "Model"; ?></h2>
        <?php if ($product_type == 'laptop') : ?>
            <p><strong>Processor:</strong> <?php echo isset($processor) ? $processor : "Processor"; ?></p>
            <p><strong>RAM:</strong> <?php echo isset($ram) ? $ram : "RAM"; ?></p>
            <p><strong>Storage Capacity:</strong> <?php echo isset($storage_capacity) ? $storage_capacity : "Storage Capacity"; ?></p>
            <p><strong>Graphics Card:</strong> <?php echo isset($graphics_card) ? $graphics_card : "Graphics Card"; ?></p>
            <p><strong>Display Size:</strong> <?php echo isset($display_size) ? $display_size : "Display Size"; ?></p>
            <p><strong>Resolution:</strong> <?php echo isset($resolution) ? $resolution : "Resolution"; ?></p>
        <?php endif; ?>
        <p><strong>Price:</strong> Rs. <?php echo isset($price) ? $price : "Price"; ?></p>
        <p><strong>Description: </strong><?php echo isset($description) ? $description : "Description"; ?></p>

            <div class="buttons">
                <?php 
                if (!isset($product_id)) {
                    die('Product ID is not set');
                }

                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) : ?>
                    <button><a href="add_to_cart.php?id=<?= $product_id ?>&source=product_description" class="btn-add-to-cart">Add to Cart</a>
                    </button>
                <?php else : ?>
                    <p>Please <a href="login.php">login</a> to purchase this product.</p>
                <?php endif; ?>
            </div>

            <h3>Reviews</h3>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) : ?>
                <form action="add_review.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <label for="review">Review:</label>
                    <textarea name="review" id="review" cols="30" rows="10" required></textarea>
                    <input type="submit" name="submit" />
                </form>
            <?php else : ?>
                <p>Please <a href="login.php">login</a> to leave a review.</p>
            <?php endif; ?>

            <?php if ($review->num_rows > 0) : ?>
                <ul>
                    <?php while ($row = $review->fetch_assoc()) : ?>
                        <li>
                            <p><strong>Review:</strong> <?php echo $row['review_text']; ?></p>
                            <span> - <?php echo date('d M Y', strtotime($row['review_date'])); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else : ?>
                <p>No reviews found.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
<script>
    <?php if (isset($_GET['added_to_cart'])) : ?>
        alert('Product added to cart.');
    <?php endif; ?>
</script>

</html>