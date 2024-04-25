<?php
 
include_once 'server/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    $review = $_POST['review'];
    
    $sql = "INSERT INTO reviews (product_id, user_id, review_text) VALUES ('$product_id', '$user_id', '$review')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: product_description.php?id=$product_id&review=success");
    } else {
        header("Location: product_description.php?id=$product_id&review=failed");
    }
}
