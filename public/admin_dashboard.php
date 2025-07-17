<?php
require_once '../config.php';
require_once '../functions.php';
require_login();

$stmt = $conn->prepare('SELECT role FROM users WHERE id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$role = $stmt->get_result()->fetch_assoc()['role'];
if ($role !== 'admin') {
    echo 'Access denied';
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h1>Admin Dashboard</h1>
<p>Administrative actions here.</p>
<p><a href="marketing_list.php">View All Items</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
