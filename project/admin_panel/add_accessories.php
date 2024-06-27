<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../server/connection.php';

    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $product_type = 'accessory';

    $image = $_FILES['product_image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];

    if ($image_size > 0) {
        $image_data = file_get_contents($image_tmp_name); 
    } else {
        echo "Error: Image not uploaded.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO products (type, product_type, brand, model, price, description, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $type, $product_type, $brand, $model, $price, $description, $image_data);

    if ($stmt->execute()) {
        echo "Accessory added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
    $conn->close(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Accessory</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">

    <script>
        function validateNumberInput(inputId) {
            var input = document.getElementById(inputId);
            if (parseInt(input.value) < 0) {
                input.value = 0; 
            }
        }
    </script>
</head>
<body>
    <?php include('admin_nav_bar.php'); ?>
    <main>
        <div class="container">
            <h2>Add Accessory</h2>
            <?php
            if (isset($_SESSION['product_added']) && $_SESSION['product_added'] === true) {
                echo '<script>alert("Accessory added successfully.");</script>';
                unset($_SESSION['product_added']);  // Unset the variable so the alert won't show again
            }
            ?>
            <form action="add_accessories.php" method="post" enctype="multipart/form-data">
                <label for="type">Type:</label><br>
                <input type="text" id="type" name="type" required><br>

                <label for="brand">Brand:</label><br>
                <input type="text" id="brand" name="brand" required><br>

                <label for="model">Model:</label><br>
                <input type="text" id="model" name="model" required><br>

                <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" min="0" required oninput="validateNumberInput('price')"><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required></textarea><br>
                
                <label for="product_image">Product Image:</label><br>
                <input type="file" id="product_image" name="product_image" accept="image/*" required><br>
                <br>
                <input type="submit" value="Add Accessory">
            </form>
        </div>
    </main>
</body>
</html>