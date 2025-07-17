<?php
require_once '../config.php';
require_once '../functions.php';
require_login();

$stmt = $conn->prepare('SELECT role FROM users WHERE id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$role = $stmt->get_result()->fetch_assoc()['role'];
if ($role !== 'owner' && $role !== 'admin') {
    echo 'Access denied';
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Owner Dashboard</title></head>
<body>
<h1>Owner Dashboard</h1>
<p>Manage your marketing items.</p>
<p><a href="marketing_list.php">View Items</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
