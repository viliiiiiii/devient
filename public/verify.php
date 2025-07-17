<?php
require_once '../config.php';
require_once '../functions.php';

if (!isset($_SESSION['otp_user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['otp']);
    $user_id = $_SESSION['otp_user'];
    $stmt = $conn->prepare('SELECT id, expires_at FROM otps WHERE user_id = ? AND otp_code = ? ORDER BY id DESC LIMIT 1');
    $stmt->bind_param('is', $user_id, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (strtotime($row['expires_at']) >= time()) {
            $_SESSION['user_id'] = $user_id;
            // cleanup
            $conn->query("DELETE FROM otps WHERE id=".$row['id']);
            unset($_SESSION['otp_user']);
            header('Location: index.php');
            exit();
        } else {
            $error = 'OTP expired.';
        }
    } else {
        $error = 'Invalid OTP.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>
    <h1>Enter OTP</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>OTP Code:</label>
        <input type="text" name="otp" required>
        <button type="submit">Verify</button>
    </form>
    <p><a href="login.php">Back</a></p>
</body>
</html>
