<?php

include_once 'server/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])&& isset($_GET['rating'])&& isset($_SESSION['user_id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_GET['rating'];
    if($rating < 1 || $rating > 5){
        header("Location: product_description.php?id=$product_id&review=failed");
        exit();
    }
    $sql = "SELECT * FROM ratings WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        header("Location: product_description.php?id=$product_id&review=failed");
        exit();
    }
    

    $sql = "INSERT INTO ratings (product_id, user_id, rating_value) VALUES ('$product_id', '$user_id', '$rating')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: product_description.php?id=$product_id&review=success");
    } else {
        header("Location: product_description.php?id=$product_id&review=failed");
        
    }
}else{
    echo "Invalid request";
    exit();
}