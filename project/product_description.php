<?php
include_once 'server/connection.php';

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $price = $row['price'];
        $description = $row['description']; // Assuming you have a 'description' column in your database
        $image = $row['product_image']; // Assuming your image column is named 'product_image'
        // Other product details you want to display
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
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
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
        width: 300px; /* Set the desired fixed width */
        height: auto;
        display: block;
        margin: 0 auto; /* Center the image */
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


</head>
<body>
<div class="container">
<?php include('navbar.php'); ?>
    <div class="product-info">
        <?php if(isset($image)) : ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="<?php echo isset($product_name) ? $product_name : "Product Image"; ?>">
        <?php endif; ?>
        <?php if(isset($product_name)) : ?>
            <h2><?php echo $product_name; ?></h2>
        <?php endif; ?>
        <?php if(isset($price)) : ?>
            <p><strong>Price:</strong> $<?php echo $price; ?></p>
        <?php endif; ?>
        <?php if(isset($description)) : ?>
            <p><strong>Description:</strong> <?php echo $description; ?></p>
        <?php endif; ?>
        <div class="buttons">
            <button><a href="admin_panel/add_to_cart.php?id=<?php echo $row["product_id"]; ?>&source=product_description" class="btn-add-to-cart">Add to Cart</a>
</button>
            <button>Buy Now</button>
        </div>
    </div>
</div>
</body>
</html>
