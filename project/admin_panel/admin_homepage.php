<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script>
        function confirmDelete(productId) {
            var confirmDelete = confirm("Are you sure you want to delete this product?");
            if (confirmDelete) {
                window.location.href = "delete_laptop.php?id=" + productId;
            }
        }
    </script>
</head>
<body>
<?php include('admin_nav_bar.php'); ?>
<main>
    <div class="container">
        <h2>laptop Management</h2><br>
        <!-- Display products in a table -->
        <div class="table-container">
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>Storage Capacity</th>
                    <th>Graphics Card</th>
                    <th>Display Size</th>
                    <th>Resolution</th>
                    <th>Price</th>
                    <th>Product Image</th>
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
                        echo "<td>" . $row["brand"] . "</td>";
                        echo "<td>" . $row["model"] . "</td>";
                        echo "<td>" . $row["processor"] . "</td>";
                        echo "<td>" . $row["ram"] . "</td>";
                        echo "<td>" . $row["storage_capacity"] . "</td>";
                        echo "<td>" . $row["graphics_card"] . "</td>";
                        echo "<td>" . $row["display_size"] . "</td>";
                        echo "<td>" . $row["resolution"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["product_image"]) . "' width='200' height='200' /></td>";
                        echo "<td><a href='edit_laptop.php?id=" . $row["product_id"] . "'>Edit</a> | <a href='#' onclick='confirmDelete(" . $row["product_id"] . ")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No products found.</td></tr>";
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
