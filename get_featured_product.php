<?php
include('connection.php');

$conn->prepare("select * from products limit 4");

$stmt->execute();

$featured_products = $stmt-> get_result();