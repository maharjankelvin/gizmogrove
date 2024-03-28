<div class="navbar">
    <div class="logo">
                <img src="assets/images/Gizmo.jpg" width="125" alt="laptop image"/>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="laptops.php">Laptops</a></li>
                    <li><a href="accessories.php">Accessories</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <!-- Dynamic Login/Logout -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <!-- Cart Icon -->
            <a href="cart.php">
    <img src="assets/images/cart.png" alt="cart" width="30px">
</a>
</div>