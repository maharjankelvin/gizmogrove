<?php include_once 'server/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Selling Website</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="header">
        <div class="container">
        <?php include('navbar.php'); ?>
            <div class="row">
                <div class="col-2">
                    <h1>Find the best laptop <br>and spoil your self.</h1>
                    <p>buy your dream laptop at an unbeattable prices</p>
                    <a href="laptops.php" class="button">Shop Now! &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="assets/images/no_bg_laptop.png">
                </div>
            </div>
        </div>
    </div>


    <?php include('featured_catagory.php'); ?>
    
    <?php include('featured_products.php'); ?>
    
    <br>

<?php include 'footer.php'; ?>
</body>
</html>
