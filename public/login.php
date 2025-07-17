<?php
require_once '../config.php';
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $otp = generate_otp();
        $expires = date('Y-m-d H:i:s', time() + 300); // 5 minutes
        $stmt = $conn->prepare('INSERT INTO otps(user_id, otp_code, expires_at) VALUES(?,?,?)');
        $stmt->bind_param('iss', $user_id, $otp, $expires);
        $stmt->execute();
        send_otp_email($email, $otp);
        $_SESSION['otp_user'] = $user_id;
        header('Location: verify.php');
        exit();
    } else {
        $error = 'Email not found. Please register.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login with OTP</title>
</head>
<body>
    <h1>OTP Login</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>".escape($error)."</p>"; ?>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send OTP</button>
    </form>
    <p><a href="index.php">Back</a></p>
</body>
</html>
