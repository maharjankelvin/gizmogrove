<?php
    include('server/connection.php');
    
    if(isset($_GET['id'])) {
        $product_id = $_GET['id'];

        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Remove product from wishlist
            $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);

            if($stmt->execute()) {
                echo "<script>alert('Product removed from wishlist successfully.'); window.location.href='product_description.php?id=$product_id';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();

            $conn->close();
        } else {
            echo "You must be logged in to remove items from your wishlist.";
        }
    } else {
        echo "Product ID is not set.";
    }
?>