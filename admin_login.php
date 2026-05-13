<?php
session_start();
require 'db_config.php';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header("Location: results.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['user_role'] = 'admin';
        header("Location: results.php");
        exit();
    } else {
        echo "<script>alert('Unauthorized access or invalid credentials.'); window.location.href='admin_login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - Voting System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 400px;">
        <h1>Owner Login</h1>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 30px;">Access restricted to voting system administrator.</p>
        <form action="admin_login.php" method="POST">
            <div class="form-group">
                <label>Admin Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" style="background-color: var(--text);">Login as Owner</button>
        </form>
        <div class="toggle-link">
            <a href="index.php">← Back to Voter Login</a>
        </div>
    </div>
</body>
</html>
