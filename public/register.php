<?php
require_once '../config.php';
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $company_id = null;
    if ($role !== 'owner') {
        $company = trim($_POST['company']);
        $stmt = $conn->prepare('SELECT id FROM companies WHERE name = ?');
        $stmt->bind_param('s', $company);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $company_id = $row['id'];
        } else {
            $stmt = $conn->prepare('INSERT INTO companies(name) VALUES(?)');
            $stmt->bind_param('s', $company);
            $stmt->execute();
            $company_id = $stmt->insert_id;
        }
    }
    $stmt = $conn->prepare('INSERT INTO users(company_id,name,email,password,role) VALUES(?,?,?,?,?)');
    $stmt->bind_param('issss', $company_id, $name, $email, $password, $role);
    if ($stmt->execute()) {
        echo 'Registered successfully. <a href="login.php">Login</a>';
        exit();
    } else {
        $error = 'Registration failed. Maybe email already exists.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>".escape($error)."</p>"; ?>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Role:</label>
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="owner">Owner</option>
        </select><br>
        <label>Company (for users/admins):</label>
        <input type="text" name="company"><br>
        <button type="submit">Register</button>
    </form>
    <p><a href="index.php">Back</a></p>
</body>
</html>
