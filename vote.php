<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['party_id'])) {
    $user_id = $_SESSION['user_id'];
    $party_id = $_POST['party_id'];

    // Start transaction
    $pdo->beginTransaction();

    try {
        // Check if user has already voted
        $stmt = $pdo->prepare("SELECT has_voted FROM users WHERE id = ? FOR UPDATE");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if ($user['has_voted']) {
            $pdo->rollBack();
            echo "<script>alert('You have already voted!'); window.location.href='dashboard.php';</script>";
            exit();
        }

        // Increment party vote count
        $stmt = $pdo->prepare("UPDATE parties SET vote_count = vote_count + 1 WHERE id = ?");
        $stmt->execute([$party_id]);

        // Mark user as voted
        $stmt = $pdo->prepare("UPDATE users SET has_voted = 1 WHERE id = ?");
        $stmt->execute([$user_id]);

        $pdo->commit();
        header("Location: thank_you.php");
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: dashboard.php");
}
?>
