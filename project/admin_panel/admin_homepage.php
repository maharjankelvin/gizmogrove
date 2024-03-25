<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<?php include('admin_nav_bar.php'); ?>
    <main>
        <div class="cointainer">
        <h2>Product Management</h2><br>
        <!-- Display products in a table -->
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                <?php
                include_once '../server/connection.php';
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["product_id"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["stock"] . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["product_image"]) . "' width='200' height='200' /></td>";
                        echo "<td><a href='update_product.php?id=" . $row["product_id"] . "'>Edit</a> | <a href='delete_product.php?id=" . $row["product_id"] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found.</td></tr>";
                }
                ?>
            </table>
        </div>
        </div>
    </main>
    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
