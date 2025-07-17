<?php
require_once '../config.php';
require_once '../functions.php';
require_login();
$role = current_user_role($conn);
$company_id = current_user_company($conn);
if ($role === 'owner' && isset($_GET['company'])) {
    $company_id = intval($_GET['company']);
}
$stmt = $conn->prepare('SELECT t.name, COUNT(i.id) as views FROM tags t LEFT JOIN tag_interactions i ON t.id=i.tag_id WHERE t.company_id = ? GROUP BY t.id');
$stmt->bind_param('i', $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Analytics</title></head>
<body>
<h1>Analytics</h1>
<table border="1">
<tr><th>Tag</th><th>Views</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr><td><?php echo escape($row['name']); ?></td><td><?php echo $row['views']; ?></td></tr>
<?php endwhile; ?>
</table>
<p><a href="index.php">Home</a></p>
</body>
</html>
