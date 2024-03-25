<header>
<h1>Welcome to Admin Panel</h1>
        <p>Hello, <?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest"; ?></p>
        <nav>
            <ul>
                <li><a href="admin_homepage.php">Dashboard</a></li>
                <li><a href="users.php">manage users</a></li>
                <li><a href="add_products.php">Add Product</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        </header>