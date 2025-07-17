<?php
require_once '../config.php';
require_once '../functions.php';
require_login();
$role = current_user_role($conn);
if ($role !== 'admin') {
    echo 'Access denied';
    exit();
}
$company_id = current_user_company($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_tag'])) {
    $tag = trim($_POST['new_tag']);
    $stmt = $conn->prepare('INSERT INTO tags(company_id,name) VALUES(?,?)');
    $stmt->bind_param('is', $company_id, $tag);
    $stmt->execute();
}

if (isset($_GET['del'])) {
    $del = intval($_GET['del']);
    $stmt = $conn->prepare('DELETE FROM tags WHERE id = ? AND company_id = ?');
    $stmt->bind_param('ii', $del, $company_id);
    $stmt->execute();
}

$stmt = $conn->prepare('SELECT id,name FROM tags WHERE company_id = ?');
$stmt->bind_param('i', $company_id);
$stmt->execute();
$tags = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h1>Admin Dashboard</h1>
<h2>Your Tags</h2>
<ul>
<?php while($row = $tags->fetch_assoc()): ?>
    <li><?php echo escape($row['name']); ?> <a href="?del=<?php echo $row['id']; ?>">delete</a></li>
<?php endwhile; ?>
</ul>
<form method="POST">
    <input type="text" name="new_tag" placeholder="New tag">
    <button type="submit">Add</button>
</form>

<p><a href="marketing_list.php">View Company Items</a></p>
<p><a href="analytics.php">View Analytics</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
