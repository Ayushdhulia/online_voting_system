<?php
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = isset($_POST['role']) ? $_POST['role'] : 'voter'; // Get role from form

    try {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $password, $role]);
        echo "<script>alert('".ucfirst($role)." Registration successful! Please login.'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Email already registered.'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
