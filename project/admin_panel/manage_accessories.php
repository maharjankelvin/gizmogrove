<?php
require_once('../server/connection.php'); 

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: add_accessories.php");
    exit();
}
// select all accessories from the database
$sql = "SELECT * FROM products where product_type='accessory'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accessories</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .accessories_table {
            margin: 20px;
        }

        .accessories_table h1 {
            text-align: center;
        }

        .accessories_table table {
            width: 100%;
            border-collapse: collapse;
        }

        .accessories_table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .accessories_table th,
        .accessories_table td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        .accessories_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .accessories_table tr:hover {
            background-color: #f2f2f2;
        }

        .accessories_table td a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php include('admin_nav_bar.php'); ?>
    <div class="accessories_table">
    <h1>Manage Accessories</h1>
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
                        echo "<img src='data:image/jpeg;base64,{$encodedImage}' alt='Accessory Image' width='100' height='100'>";
                    ?>
                </td>
                <td>
                    <a href="edit_accessory.php?id=<?php echo $row['product_id']; ?>"> Edit </a>
                    <a href="delete_accessory.php?id=<?php echo $row['product_id']; ?>"> Delete </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    </div>
</body>

</html>

<?php $conn->close(); ?>