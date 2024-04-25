<?php
session_start(); // Start the session (if not already started)
include '../server/connection.php'; // Include your database connection file

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit(); // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Accessories (type, brand, model, price, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $type, $brand, $model, $price, $description);
    if ($stmt->execute()) {
        header("Location: accessories.php?added=true");
        exit();
    } else {
        header("Location: add_accessory.php?error=sql_error");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Accessory</title>
    <!-- Include your CSS stylesheets here -->
</head>
<body>
    <!-- Include your navigation bar or header here -->

    <div class="container">
        <h1>Add Accessory</h1>
        <!-- Display error messages here (if any) -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>
            </div>
            <div>
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" required>
            </div>
            <div>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <!-- Add input field for image upload (if needed) -->

            <button type="submit">Add Accessory</button>
        </form>
    </div>

    <!-- Include your footer here -->
</body>
</html>
