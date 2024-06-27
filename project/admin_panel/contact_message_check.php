<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Contact Messages</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/admin_navbar.css">
    <style>
        #title {
            margin-top: 10px;
            text-align: center;
        }
        .message {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .filter-options {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        button, .mark-read-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
    }
    </style>
</head>
<body>
    <?php include('admin_nav_bar.php'); ?>
    <h1 id="title">Contact Messages</h1>
    <div class="filter-options">
        <form action="contact_message_check.php" method="get">
            <button type="submit" name="filter" value="all">All</button>
            <button type="submit" name="filter" value="read">Read</button>
            <button type="submit" name="filter" value="unread">Unread</button>
        </form>
    </div>
    <?php 
    include('../server/connection.php'); 

    if (isset($_GET['mark_read']) && isset($_GET['message_id'])) {
        $message_id = $_GET['message_id'];
        $updateSql = "UPDATE contact_messages SET is_read = 1 WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $message_id);
        $stmt->execute();
        header("Location: contact_message_check.php"); 
        exit();
    }

    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    switch ($filter) {
        case 'read':
            $sql = "SELECT cm.id, cm.message, cm.created_at, cm.user_id, cm.is_read, ud.Username, ud.Email 
                    FROM contact_messages cm 
                    JOIN user_details ud ON cm.user_id = ud.User_id 
                    WHERE cm.is_read = 1 
                    ORDER BY cm.created_at DESC";
            break;
        case 'unread':
            $sql = "SELECT cm.id, cm.message, cm.created_at, cm.user_id, cm.is_read, ud.Username, ud.Email 
                    FROM contact_messages cm 
                    JOIN user_details ud ON cm.user_id = ud.User_id 
                    WHERE cm.is_read = 0 
                    ORDER BY cm.created_at DESC";
            break;
        default:
            $sql = "SELECT cm.id, cm.message, cm.created_at, cm.user_id, cm.is_read, ud.Username, ud.Email 
                    FROM contact_messages cm 
                    JOIN user_details ud ON cm.user_id = ud.User_id 
                    ORDER BY cm.created_at DESC";
            break;
    }
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='message'>";
            echo "<h2>Username: " . $row["Username"]. "</h2>"; 
            echo "<p><strong>Message ID:</strong> " . $row["id"]. "</p>"; 
            echo "<p><strong>Email:</strong> " . $row["Email"]. "</p>"; 
            echo "<p><strong>Message:</strong> " . $row["message"]. "</p>"; 
            echo "<p><strong>Sent On:</strong> " . $row["created_at"]. "</p>";
            if (!$row['is_read']) {
                echo "<form action='contact_message_check.php' method='get'>";
                echo "<input type='hidden' name='mark_read' value='true'>";
                echo "<input type='hidden' name='message_id' value='" . $row["id"] . "'>";
                echo "<button type='submit' class='mark-read-btn'>Mark as Read</button>";
                echo "</form>";
            }
            echo "</div>";
        }
    } else {
        echo "No messages found.";
    }
    $conn->close();
    ?>
</body>
</html>