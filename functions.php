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
?>
