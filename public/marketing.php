<?php
require_once '../config.php';
require_once '../functions.php';
require_login();
$role = current_user_role($conn);
$company_id = current_user_company($conn);
if ($role === 'owner' && isset($_GET['company'])) {
    $company_id = intval($_GET['company']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $url = trim($_POST['url']);
    $stmt = $conn->prepare('INSERT INTO marketing_items(company_id,user_id,name,url) VALUES(?,?,?,?)');
    $stmt->bind_param('iiss', $company_id, $_SESSION['user_id'], $name, $url);
    $stmt->execute();
    $id = $stmt->insert_id;
    header('Location: marketing_item.php?id='.$id);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Marketing Item</title></head>
<body>
<h1>Create Marketing Item</h1>
<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required><br>
    <label>URL:</label>
    <input type="text" name="url" required><br>
    <button type="submit">Create</button>
</form>
<p><a href="index.php">Home</a></p>
</body>
</html>
