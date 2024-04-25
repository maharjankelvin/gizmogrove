<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include_once '../server/connection.php';

    // Retrieve form data
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $processor = $_POST['processor'];
    $ram = $_POST['ram'];
    $storage_capacity = $_POST['storage_capacity'];
    $graphics_card = $_POST['graphics_card'];
    $display_size = $_POST['display_size'];
    $resolution = $_POST['resolution'];
    $price = $_POST['price'];

    // Process image upload
    $image = $_FILES['product_image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];

    // Check if image is uploaded successfully
    if ($image_size > 0) {
        $image_data = file_get_contents($image_tmp_name); // Read image data
    } else {
        echo "Error: Image not uploaded.";
        exit();
    }

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO products (brand, model, processor, ram, storage_capacity, graphics_card, display_size, resolution, price, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssds", $brand, $model, $processor, $ram, $storage_capacity, $graphics_card, $display_size, $resolution, $price, $image_data);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script>
        function validateNumberInput(inputId) {
            var input = document.getElementById(inputId);
            if (parseInt(input.value) < 0) {
                input.value = 0; // Reset to 0 if negative value entered
            }
        }
    </script>
</head>
<body>
    <?php include('admin_nav_bar.php'); ?>
    <main>
        <div class="container">
            <h2>Add Product</h2>
            <form action="add_products.php" method="post" enctype="multipart/form-data">
                <label for="brand">Brand:</label><br>
                <input type="text" id="brand" name="brand" required><br>

                <label for="model">Model:</label><br>
                <input type="text" id="model" name="model" required><br>

                <label for="processor">Processor:</label><br>
                <input type="text" id="processor" name="processor" required><br>

                <label for="ram">RAM:</label><br>
                <input type="text" id="ram" name="ram" required><br>

                <label for="storage_capacity">Storage Capacity:</label><br>
                <input type="text" id="storage_capacity" name="storage_capacity" required><br>

                <label for="graphics_card">Graphics Card:</label><br>
                <input type="text" id="graphics_card" name="graphics_card" required><br>

                <label for="display_size">Display Size:</label><br>
                <input type="text" id="display_size" name="display_size" required><br>

                <label for="resolution">Resolution:</label><br>
                <input type="text" id="resolution" name="resolution" required><br>

                <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" min="0" required oninput="validateNumberInput('price')"><br>

                <label for="product_image">Product Image:</label><br>
                <input type="file" id="product_image" name="product_image" accept="image/*" required><br>
                <br>
                <input type="submit" value="Add Product">
            </form>
        </div>
    </main>
</body>
</html>
