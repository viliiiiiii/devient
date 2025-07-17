<?php
require_once '../config.php';
require_once '../functions.php';
require_login();

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare('SELECT name,url FROM marketing_items WHERE id = ? AND user_id = ?');
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
if (!$item) {
    echo 'Item not found';
    exit();
}
$qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($item['url']);
?>
<!DOCTYPE html>
<html>
<head><title><?php echo htmlspecialchars($item['name']); ?></title></head>
<body>
<h1><?php echo htmlspecialchars($item['name']); ?></h1>
<p>URL: <a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['url']); ?></a></p>
<img src="<?php echo $qr_url; ?>" alt="QR Code">
<p><a href="marketing_list.php">Back to list</a></p>
</body>
</html>
