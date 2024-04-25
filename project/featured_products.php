<?php

$sql = "SELECT product_id, brand, model, price, product_image
 FROM Products
WHERE type = 'product'
 ORDER BY RAND() 
 LIMIT 4";
$all_product = $conn->query($sql);
?>
<style>
    .btn-buy,
    .btn-add-to-cart {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 10px;
        background-color: #007bff;
        /* Blue color */
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-buy:hover,
    .btn-add-to-cart:hover {
        background-color: #0056b3;
        /* Darker blue color on hover */
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        /* Red color */
        color: white;
        margin-bottom: 15px;
    }

    /* The close button */
    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    /* When moving the mouse over the close button */
    .closebtn:hover {
        color: black;
    }
</style>
<script>
    // JavaScript code to display alert messages
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('added_to_cart') && params.get('added_to_cart') === 'true') {
            alert('Product added to cart successfully!');
        } else if (params.has('error')) {
            const error = params.get('error');
            if (error === 'product_not_found') {
                alert('Error: Product not found!');
            } else if (error === 'missing_product_id') {
                alert('Error: Missing product ID!');
            }
        }
    });
</script>

<div class="small-container">
    <h2 class="feature-title">Featured Products</h2>
    <?php
    // Check if the product was added to cart successfully and display an alert
    if (isset($_GET['added_to_cart']) && $_GET['added_to_cart'] == 'true') {
        echo '<div class="alert">';
        echo 'Product added to cart successfully!';
        echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
        echo '</div>';
    } elseif (isset($_GET['error'])) {
        // Handle errors here if needed
        $error = $_GET['error'];
        // Display appropriate error message based on error code
        echo '<div class="alert">';
        if ($error == 'product_not_found') {
            echo 'Error: Product not found!';
        } elseif ($error == 'missing_product_id') {
            echo 'Error: Missing product ID!';
        }
        echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
        echo '</div>';
    }
    ?>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($all_product)) { ?>
            <div class="col-4">
                <?php
                // Convert image data to base64
                $image_data = base64_encode($row["product_image"]);
                $image_src = 'data:image/jpeg;base64,' . $image_data;
                ?>
                <a href="product_description.php?id=<?php echo $row["product_id"]; ?>">
                    <img src="<?php echo $image_src; ?>" width="100%" height="200px">
                    <h4><?php echo $row["brand"] . ' ' . $row["model"]; ?></h4>
                    <p>rs <?php echo $row["price"]; ?></p>
                </a>
                <div>
                    <a href="add_to_cart.php?id=<?php echo $row["product_id"]; ?>&source=index" class="btn-add-to-cart">Add to Cart</a>
                    <a href="checkout.php?product_id=<?php echo $row["product_id"]; ?>" class="btn-buy">Buy Now</a>                </div>
            </div>
        <?php } ?>
    </div>

</div>