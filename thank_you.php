<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - Secure Voting</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .success-card { text-align: center; padding: 20px 0; }
        .success-icon-container { width: 80px; height: 80px; background: #f0fdf4; border-radius: 99px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #10b981; border: 1px solid #bbf7d0; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1); }
        .success-card h1 { background: var(--secondary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="success-card">
            <div class="success-icon-container">
                <i data-lucide="check-circle" size="48"></i>
            </div>
            <h1>Vote Recorded!</h1>
            <p class="subtitle">Your secure ballot has been successfully submitted and counted in the system.</p>
            
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px; border: 1px solid var(--border); margin: 32px 0;">
                <p style="font-size: 0.85rem; color: var(--text-light); font-weight: 500;">For security reasons, please sign out of your session now.</p>
            </div>

            <a href="logout.php" style="text-decoration: none;">
                <button style="background: var(--primary-gradient); width: auto; padding: 16px 48px;">Sign Out Securely</button>
            </a>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
