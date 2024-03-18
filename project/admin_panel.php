<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_panelt</title>
</head>
<body>
    <h1>welcome to admin login</h1><?php echo $_SESSION["username"] ?>
    <a href="logout.php">LogOut</a>
</body>
</html>