<?php
require_once('../server/connection.php'); 

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: add_laptops.php");
    exit();
}
$sql = "SELECT * FROM products where product_type='laptop'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Laptops</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">

    <style>
        .laptops_table {
            margin: 20px;
        }

        .laptops_table h1 {
            text-align: center;
        }

        .laptops_table table {
            width: 100%;
            border-collapse: collapse;
        }

        .laptops_table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .laptops_table th,
        .laptops_table td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        .laptops_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .laptops_table tr:hover {
            background-color: #f2f2f2;
        }

        .laptops_table td a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php include('admin_nav_bar.php'); ?>
    <div class="laptops_table">
    <h1>Manage Laptops</h1>
    <table>
        <tr>
            <th>product_ID</th>
            <th>Type</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Price</th>
            <th>Description</th>
            <th>image</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['brand']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <?php 
                        $imageData = $row['product_image'];
                        $encodedImage = base64_encode($imageData);
                        echo "<img src='data:image/jpeg;base64,{$encodedImage}' alt='Laptop Image' width='100' height='100'>";
                    ?>
                </td>
                <td>
                    <a href="edit_laptop.php?id=<?php echo $row['product_id']; ?>"> Edit </a>
                    <a href="delete_laptop.php?id=<?php echo $row['product_id']; ?>"> Delete </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    </div>
</body>

</html>

<?php $conn->close(); ?>