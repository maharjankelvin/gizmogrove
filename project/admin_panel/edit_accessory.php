<?php
include '../server/connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $product_image = $_POST['product_image'];
    $description = $_POST['description'];

    if ($_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $product_image = $_FILES["image"]["name"];
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $sql = "UPDATE products SET type=?, brand=?, model=?, price=?, description=?, product_image=? WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $type, $brand, $model, $price, $description, $product_image, $product_id);
    if ($stmt->execute()) {
        $_SESSION['product_updated'] = true;
        header("Location: edit_accessory.php?product_id=".$product_id);
        exit();
    } else {
        header("Location: edit_accessory.php?product_id=".$product_id."&error=sql_error");
        exit();
    }
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
} else {
    echo "Product ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Accessory</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include('admin_nav_bar.php'); ?>

    <div class="container">
        <h1>Edit Accessory</h1>
        <br>

        <?php
        if (isset($_SESSION['product_updated']) && $_SESSION['product_updated'] === true) {
            echo '<script>alert("Product updated successfully.");</script>';
            unset($_SESSION['product_updated']);
        }
        ?>

        <form action="edit_accessory.php?id=<?php echo isset($product['id']) ? $product['id'] : ''; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">            <label for="type">Type:</label>
            <input type="text" name="type" value="<?php echo $product['type']; ?>"><br><br>
            <label for="brand">Brand:</label>
            <input type="text" name="brand" value="<?php echo $product['brand']; ?>"><br><br>
            <label for="model">Model:</label>
            <input type="text" name="model" value="<?php echo $product['model']; ?>"><br><br>
            <label for="price">Price:</label>
            <input type="text" name="price" value="<?php echo $product['price']; ?>"><br><br>
            <label for="description">Description:</label>
            <textarea name="description"><?php echo $product['description']; ?></textarea><br><br>
            <label for="image">Current Image:</label>
            <?php 
                $imageData = $product['product_image'];
                $encodedImage = base64_encode($imageData);
            ?>
            <img src="data:image/jpeg;base64,<?php echo $encodedImage; ?>" alt="Product Image" style="width: 100px;"><br><br>            <label for="image">Upload New Image:</label>
            <input type="file" name="image"><br><br>
            <button type="submit">Update Accessory</button>
        </form>
    </div>

</body>
</html>