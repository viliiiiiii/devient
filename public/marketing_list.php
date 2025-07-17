<?php
require_once '../config.php';
require_once '../functions.php';
require_login();

$stmt = $conn->prepare('SELECT id,name,url FROM marketing_items WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Your Marketing Items</title></head>
<body>
<h1>Your Marketing Items</h1>
<ul>
<?php while($row = $result->fetch_assoc()): ?>
    <li><a href="marketing_item.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></li>
<?php endwhile; ?>
</ul>
<p><a href="marketing.php">Create New</a></p>
<p><a href="index.php">Home</a></p>
</body>
</html>
