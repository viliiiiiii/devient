<?php
// Database configuration
$DB_HOST = 'localhost';
$DB_USER = 'dbuser';
$DB_PASS = 'dbpass';
$DB_NAME = 'marketing_app';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

session_start();
?>
