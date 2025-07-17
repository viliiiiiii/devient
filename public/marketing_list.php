<?php
require_once '../config.php';
require_once '../functions.php';
require_login();
$role = current_user_role($conn);
$company_id = isset($_GET['company']) ? intval($_GET['company']) : current_user_company($conn);
$cname = '';
if ($company_id) {
    $stmt = $conn->prepare('SELECT name FROM companies WHERE id = ?');
    $stmt->bind_param('i', $company_id);
    $stmt->execute();
    $cname = $stmt->get_result()->fetch_assoc()['name'] ?? '';
}

$query = 'SELECT id,name,url FROM marketing_items WHERE company_id = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $company_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Marketing Items</title></head>
<body>
<h1>Marketing Items for <?php echo escape($cname); ?></h1>
<ul>
<?php while($row = $result->fetch_assoc()): ?>
    <li><a href="marketing_item.php?id=<?php echo $row['id']; ?>"><?php echo escape($row['name']); ?></a></li>
<?php endwhile; ?>
</ul>
<p><a href="marketing.php">Create New</a></p>
<p><a href="analytics.php">View Analytics</a></p>
<p><a href="index.php">Home</a></p>
</body>
</html>
