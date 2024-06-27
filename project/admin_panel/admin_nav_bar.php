<?php
?>
<header>
    <h1>Welcome to Admin Panel</h1>
    <p>Hello, <?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest"; ?></p>
    <nav>
        <ul>
            <li><a href="admin_homepage.php">Dashboard</a></li>
            <li><a href="users.php">Manage Users</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Products</a>
                <div class="dropdown-content">
                    <a href="add_laptops.php">Add Laptops</a>
                    <a href="add_accessories.php">Add Accessories</a>
                    <a href="manage_accessories.php">Manage Accessories</a>
                    <a href="manage_laptops.php">Manage Laptops</a>
                </div>
            </li>
            <li><a href="orders.php">Manage Orders</a></li>
            <li><a href="contact_message_check.php">Contact Messages</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>