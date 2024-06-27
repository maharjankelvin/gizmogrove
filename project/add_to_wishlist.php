<?php
    include('server/connection.php');

    if(isset($_GET['id'])) {
        $product_id = $_GET['id'];

        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $check_stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
            $check_stmt->bind_param("ii", $user_id, $product_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if($check_result->num_rows > 0) {
                echo "<script>alert('This product is already in your wishlist.'); window.location.href='product_description.php?id=$product_id';</script>";
            } else {
                $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $product_id);

                if($stmt->execute()) {
                    echo "<script>alert('Product added to wishlist successfully.'); window.location.href='product_description.php?id=$product_id';</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            }

            $check_stmt->close();
            $conn->close();
        } else {
            echo "You must be logged in to add items to your wishlist.";
        }
    } else {
        echo "Product ID is not set.";
    }
?>