<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Products</title>
    <style>
        /* Add your CSS styles here */
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
        <select name="filter">
            <option value="">Filter by Category</option>
            <option value="laptop">Laptop</option>
            <option value="accessories">Accessories</option>
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

    $sql = "SELECT * FROM products";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $sql .= " WHERE product_name LIKE '%$search%'";
    }

    if (isset($_GET['filter']) && !empty($_GET['filter'])) {
        $category = $_GET['filter'];
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND category = '$category'";
        } else {
            $sql .= " WHERE category = '$category'";
        }
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row["product_image"]) . "' alt='" . $row["product_name"] . "' />";
            echo "<h3>" . $row["product_name"] . "</h3>";
            echo "<p>Price: $" . $row["price"] . "</p>";
            // Add button with link to product description page
            echo "<a href='product_description.php?id=" . $row["product_id"] . "'><button>buy now </button></a>";
            echo "</div>";
        }
    } else {
        echo "No products available.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
