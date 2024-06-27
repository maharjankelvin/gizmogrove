<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Products</title>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
        }
        .product img {
            width: 100%;
            height: auto;
        }
        .product button {
            display: block;
            width: 100%;
            padding: 5px 10px;
            margin-top: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .product button:hover {
            background-color: #555;
        }
    </style>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <?php include_once 'server/connection.php'; ?>
<div class="header">
    <?php include('navbar.php'); ?>
</div>
<div class="container-products">
    <h1>Laptop Products</h1>
    <form action="#" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    
    <form action="#" method="GET" class="filter-form">
        <select name="brand">
            <option value="">Filter by Brand</option>
            <?php
            $brand_result = $conn->query("SELECT DISTINCT brand FROM products where product_type='laptop'");
            if ($brand_result->num_rows > 0) {
                while($row = $brand_result->fetch_assoc()) {
                    echo '<option value="'.$row['brand'].'">'.$row['brand'].'</option>';
                }
            }
            ?>
        </select>
        <select name="type">
            <option value="">Filter by Type</option>
            <?php
            $type_result = $conn->query("SELECT DISTINCT type FROM products where product_type='laptop'");
            if ($type_result->num_rows > 0) {
                while($row = $type_result->fetch_assoc()) {
                    echo '<option value="'.$row['type'].'">'.$row['type'].'</option>';
                }
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>
    <form action="#" method="GET">
        <button type="submit">Clear Filter</button>
    </form>
</div>

<div class="content">
    <?php
    include_once 'server/connection.php';

    $sql = "SELECT * FROM products WHERE product_type='laptop'";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $sql .= " AND (model LIKE '%$search%' OR brand LIKE '%$search%')";
    }
    if (isset($_GET['brand']) && !empty($_GET['brand'])) {
        $brand = $_GET['brand'];
        $sql .= " AND brand = '$brand'";
    }
    if (isset($_GET['type']) && !empty($_GET['type'])) {
        $type = $_GET['type'];
        $sql .= " AND type = '$type'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
    <a href="product_description.php?id=<?php echo $row["product_id"]; ?>">
            <div class="product">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row["product_image"]); ?>" alt="<?php echo $row["brand"] . " " . $row["model"]; ?>" />
                <h3><?php echo $row["brand"] . " " . $row["model"]; ?></h3>
                <p> rs <?php echo $row["price"]; ?></p>
                <a href="add_to_cart.php?id=<?php echo $row["product_id"]; ?>&source=laptops" class="btn-add-to-cart"><button>Add to cart</button></a>
                <a href="product_description.php?id=<?php echo $row["product_id"]; ?>"><button>View Details</button></a>
            </div>
    </a>
    <?php
        }
    } else {
        echo "No products available.";
    }

    $conn->close();
    ?>
</div>
<?php include('footer.php'); ?>

</body>
</html>