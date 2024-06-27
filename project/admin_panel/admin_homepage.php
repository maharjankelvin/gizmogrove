<?php  
require_once('../server/connection.php'); 

$result = $conn->query("SELECT COUNT(*) AS total FROM user_details");
$row = $result->fetch_assoc();
$total_users = $row['total'];

$result = $conn->query("SELECT COUNT(*) AS total FROM products where product_type='laptop'");
$row = $result->fetch_assoc();
$total_laptops = $row['total'];

$result = $conn->query("SELECT COUNT(*) AS total FROM products where product_type='accessory'");
$row = $result->fetch_assoc();
$total_accessories = $row['total'];

$result = $conn->query("SELECT COUNT(*) AS total FROM checkoutdetails");
$row = $result->fetch_assoc();
$total_orders = $row['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">
    <style>
        .statistics {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }

        .statistic {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }
        .btn {
        display: inline-block;
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        margin-top: 10px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

.btn:hover {
    background-color: #0056b3;
}
      </style>  
</head>
<body>
<?php include('admin_nav_bar.php'); ?>
    <div class="container">
        <main>
            <div class="statistics">
                <div class="statistic">
                    <h2>Total Users</h2>
                    <p><?php echo $total_users; ?></p>
                    <a href="users.php" class="btn">Manage Users</a>
                </div>
                <div class="statistic">
                    <h2>Total laptops</h2>
                    <p><?php echo $total_laptops; ?></p>
                    <a href="manage_laptops.php" class="btn">Manage laptops</a>
                </div>
                <div class="statistic">
                    <h2>Total Accessories</h2>
                    <p><?php echo $total_accessories; ?></p>
                    <a href="manage_accessories.php" class="btn">Manage Accessories</a>
                </div>
                <div class="statistic">
                    <h2>Total Orders</h2>
                    <p><?php echo $total_orders; ?></p>
                    <a href="orders.php" class="btn">Manage Orders</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>