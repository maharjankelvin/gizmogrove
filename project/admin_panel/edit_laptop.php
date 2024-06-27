<?php
include_once '../server/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, price=?, stock=?, category=?, description=? WHERE product_id=?");
    $stmt->bind_param("sdisss", $product_name, $price, $stock, $category, $description, $product_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: admin_homepage.php");
    exit();
}

$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id=$product_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
<?php include('admin_nav_bar.php'); ?>
<main>
<div class="container">
    <h2>Update Product</h2>
    <form action="update_product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>" required><br>
        
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>" required><br>

        <label for="stock">Stock:</label><br>
        <input type="number" id="stock" name="stock" value="<?php echo $row['stock']; ?>" required><br>

        <label for="category">Category:</label><br>
        <select id="category" name="category">
            <option value="laptop" <?php if ($row['category'] == 'laptop') echo 'selected'; ?>>Laptop</option>
            <option value="accessories" <?php if ($row['category'] == 'accessories') echo 'selected'; ?>>Accessories</option>
        </select><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required><?php echo $row['description']; ?></textarea><br>
        
        <input type="submit" value="Update Product">
    </form>
</div>
</main>
</body>
</html>
