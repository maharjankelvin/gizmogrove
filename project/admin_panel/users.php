<?php
include_once '../server/connection.php';

$sql = "SELECT * FROM user_details WHERE User_id <> ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">
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
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Status</th>
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
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["user_type"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>
                            <a href='update_user_status.php?id=" . $row["User_id"] . "&status=" . ($row["status"] == 'active' ? 'suspended' : 'active') . "'>" . ($row["status"] == 'active' ? 'Suspend' : 'Activate') . "</a>

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
