<?php

include_once('server/connection.php');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM user_messages WHERE user_id = ? ORDER BY date_sent DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Notifications</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/notification.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
</head>
<body>
    <?php include('navbar.php'); ?>
        <h1>Your Notifications</h1><br>
        <?php if (empty($messages)): ?>
            <p>You have no notifications.</p>
        <?php else: ?>
            <ul class="notification-list">
                <?php foreach ($messages as $message): ?>
                    <li>
                        <p><?php echo htmlspecialchars($message['date_sent']); ?></p>
                        <p><?php echo htmlspecialchars($message['message']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php include('footer.php'); ?>
</body>
</html>