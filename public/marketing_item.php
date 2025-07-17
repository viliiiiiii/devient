<?php
require_once '../config.php';
require_once '../functions.php';
$role = current_user_role($conn);
require_login();

$id = intval($_GET['id'] ?? 0);
$company_id = current_user_company($conn);
if ($role === 'owner' && isset($_GET['company'])) {
    $company_id = intval($_GET['company']);
}
$stmt = $conn->prepare('SELECT name,url FROM marketing_items WHERE id = ? AND company_id = ?');
$stmt->bind_param('ii', $id, $company_id);
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
<head><title><?php echo escape($item['name']); ?></title></head>
<body>
<h1><?php echo escape($item['name']); ?></h1>
<p>URL: <a href="<?php echo escape($item['url']); ?>"><?php echo escape($item['url']); ?></a></p>
<img src="<?php echo $qr_url; ?>" alt="QR Code">
<p><a href="marketing_list.php?company=<?php echo $company_id; ?>">Back to list</a></p>
</body>
</html>
