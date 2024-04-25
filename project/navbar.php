<div class="navbar">
    <div class="logo">
        <img src="assets/images/Gizmo.jpg" width="125" alt="laptop image" />
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="laptops.php">Laptops</a></li>
            <li><a href="accessories.php">Accessories</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="compare.php">Compare</a></li>
            <!-- Dynamic Login/Logout -->

            <?php if (isset($_SESSION['logged_in'])) { ?>
                <li><a href="view_wishlist.php">wishlist</a></li>
                <li><a href="logout.php">Logout</a></li>
                <a href="cart.php">
                    <img src="assets/images/cart.png" alt="cart" width="30px">
                </a>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>

        </ul>

    </nav>
</div>