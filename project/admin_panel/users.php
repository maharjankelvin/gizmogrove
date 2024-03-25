<?php
include_once '../server/connection.php';

$sql = "SELECT * FROM user_details";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<?php include('admin_nav_bar.php'); ?>
<br>
<main>
<div class="cointainer">
    <h2>User Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["User_id"] . "</td>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>
                            <a href='edit_user.php?id=" . $row["User_id"] . "'>Edit</a> | 
                            <a href='delete_user.php?id=" . $row["User_id"] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</main>
</body>
</html>
