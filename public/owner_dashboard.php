<?php
require_once '../config.php';
require_once '../functions.php';
require_login();
$role = current_user_role($conn);
if ($role !== 'owner') {
    echo 'Access denied';
    exit();
}

$companies = $conn->query('SELECT id,name FROM companies');
?>
<!DOCTYPE html>
<html>
<head><title>Owner Dashboard</title></head>
<body>
<h1>Owner Dashboard</h1>
<h2>All Companies</h2>
<ul>
<?php while($row = $companies->fetch_assoc()): ?>
    <li><?php echo escape($row['name']); ?> - <a href="marketing_list.php?company=<?php echo $row['id']; ?>">items</a></li>
<?php endwhile; ?>
</ul>
<p><a href="analytics.php">Global Analytics</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
