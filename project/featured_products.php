<?php
include 'server/connection.php';

$sql = "SELECT * FROM Products ORDER BY RAND() LIMIT 4";
$all_product = $conn->query($sql); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="small-container">
    <h2 class="feature-title">Featured Products</h2>
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($all_product)) { ?> 
        <div class="col-4">
            <?php 
            // Convert image data to base64
            $image_data = base64_encode($row["product_image"]); 
            $image_src = 'data:image/jpeg;base64,' . $image_data;
            ?>
            <img src="<?php echo $image_src; ?>" width="100%" height="200px">
            <h4><?php echo $row["product_name"];?></h4>
            <p><?php echo $row["price"];?></p>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
