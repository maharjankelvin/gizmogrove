<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Comparison</title>
    <link rel="stylesheet" href="assets/css/compare.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <style>
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .comparison-table th, .comparison-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .comparison-table th {
            background-color: #f2f2f2;
        }

        .comparison-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .comparison-table tr:hover {
            background-color: #f2f2f2;
        }

        .comparison-table td:first-child {
            width: 40%;
        }

        .comparison-table td {
            width: 30%;
        }

        .comparison-table td:nth-child(2) {
            text-align: center;
        }

        .comparison-table td:last-child {
            text-align: right;
        }

        .comparison-table td img {
            max-width: 100px; /* Adjust the max-width as needed */
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .comparison-table td.details {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .comparison-table hr {
            border: none;
            border-top: 1px solid #ddd;
        }

        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
<?php include 'server/connection.php'; ?>
    <?php include('navbar.php'); ?>

    <h1>Compare Laptops</h1>
    <main>
        <section class="laptop-selection">
            <h2>Select Laptops to Compare</h2>
            <form action="#" method="post">
                <select name="laptop1">
                    <option value="">Select Laptop 1</option>
                    <?php
                    $sql = "SELECT product_id, brand, model, product_image FROM products where product_type='laptop'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['product_id']."'>".$row['brand']." ".$row['model']."</option>";
                        }
                    }
                    ?>
                </select>
                <select name="laptop2">
                    <option value="">Select Laptop 2</option>
                    <?php
                    $result->data_seek(0);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['product_id']."'>".$row['brand']." ".$row['model']."</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit">Compare</button>
            </form>
        </section>
        <section class="comparison-results">
            <h2>Comparison Results</h2>     
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['laptop1']) && !empty($_POST['laptop2'])) {
                    $laptop1_id = $_POST['laptop1'];
                    $laptop2_id = $_POST['laptop2'];
                    $sql = "SELECT * FROM products WHERE product_id IN ($laptop1_id, $laptop2_id)";
                    $result = $conn->query($sql);
                    if ($result->num_rows == 2) {
                        echo "<div class='comparison-table'>";
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Title</th>";
                        while($row = $result->fetch_assoc()) {
                            echo "<th>";
                            echo "<img src='data:image/jpeg;base64,".base64_encode($row['product_image'])."' alt='Product Image' style='max-width: 300px;'>"; // Adjust the max-width as needed
                            echo "<br> ".$row['brand']." ".$row['model'];
                            echo "</th>";
                        }
                        echo "</tr>";
                        
                        // Iterate over each laptop detail
                        $details = array(
                            "Processor" => "processor",
                            "RAM" => "ram",
                            "Storage Capacity" => "storage_capacity",
                            "Graphics Card" => "graphics_card",
                            "Display Size" => "display_size",
                            "Resolution" => "resolution",
                            "Price" => "price"
                        );
                        foreach ($details as $label => $key) {
                            echo "<tr>";
                            echo "<th>$label</th>";
                            $result->data_seek(0);
                            while($row = $result->fetch_assoc()) {
                                echo "<td>".$row[$key]."</td>";
                            }

                            echo "</tr>";
                        }
                        
                        echo "<tr>";
                        echo "<th></th>";
                        $result->data_seek(0);
                        while($row = $result->fetch_assoc()) {
                            
                            echo "<td>";
                            echo "<button onclick=\"location.href='checkout.php?product_id=".$row['product_id']."'\">Buy Now</button>";
                            echo "<button onclick=\"location.href='add_to_cart.php?id=".$row['product_id']."&source=compare'\">Add to Cart</button>";
                            echo "</td>";
                            
                        }
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<p class='error'>Please select two laptops for comparison.</p>";
                    }
                } else {
                    echo "<p class='error'>Please select two laptops for comparison.</p>";
                }
            }
            ?>
        </section>
    </main>
    <br>
    <?php include('footer.php'); ?>

</body>
</html>
