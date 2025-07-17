<?php
require_once '../config.php';
require_once '../functions.php';

if (is_logged_in()) {
    // redirect based on role
    $stmt = $conn->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $role = $result['role'];
    if ($role == 'admin') {
        header('Location: admin_dashboard.php');
    } elseif ($role == 'owner') {
        header('Location: owner_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>NFC & QR Marketing App</title>
</head>
<body>
    <h1>Welcome to the Marketing App</h1>
    <p><a href="register.php">Register</a> or <a href="login.php">Login with OTP</a></p>
</body>
</html>
