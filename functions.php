<?php
function generate_otp() {
    return rand(100000, 999999);
}

function send_otp_email($email, $otp) {
    $subject = 'Your OTP Code';
    $message = "Your login OTP is: $otp";
    // In production, configure proper mail headers
    return mail($email, $subject, $message);
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function current_user_role($conn) {
    if (!is_logged_in()) return null;
    $stmt = $conn->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['role'] ?? null;
}

function current_user_company($conn) {
    if (!is_logged_in()) return null;
    $stmt = $conn->prepare('SELECT company_id FROM users WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['company_id'] ?? null;
}
?>
