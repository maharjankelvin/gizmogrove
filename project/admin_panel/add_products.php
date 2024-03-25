<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include_once '../server/connection.php';

    // Retrieve form data
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $description = $_POST['description']; // New field
    
    // Process image upload
    $image = $_FILES['image'];
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
    $stmt = $conn->prepare("INSERT INTO products (product_name, price, stock, category, description, product_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsdss", $product_name, $price, $stock, $category, $description, $image_data);
    
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
</head>
<body>
<?php include('admin_nav_bar.php'); ?>
<main>
<div class="container">
<h2>Add Product</h2>
    <form action="add_products.php" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" required><br>
        
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br>

        <label for="stock">Stock:</label><br>
        <input type="number" id="stock" name="stock" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br>

        <label for="category">Category:</label><br>
        <select id="category" name="category">
            <option value="laptop">Laptop</option>
            <option value="accessories">Accessories</option>
        </select><br>

        

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br>
        <br>
        <input type="submit" value="Add Product">
    </form>
</div>
</main>
</body>
</html>
