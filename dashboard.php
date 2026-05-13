<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['user_role'] !== 'voter') {
    header("Location: results.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT has_voted FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$has_voted = $user['has_voted'];

$stmt = $pdo->query("SELECT * FROM parties");
$parties = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { max-width: 800px; }
        .party-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
        .party-card { background: white; padding: 24px; border-radius: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--border); transition: all 0.3s; }
        .party-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border-color: var(--primary); }
        .party-card h3 { margin-bottom: 20px; font-weight: 700; color: var(--text); }
        .vote-btn { background: var(--secondary-gradient); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
        .vote-btn:hover { box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.3); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .user-badge { background: #f1f5f9; padding: 8px 16px; border-radius: 99px; font-weight: 600; font-size: 0.9rem; color: var(--primary); }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="header-flex">
            <div class="user-badge">Voter: <?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
            <a href="logout.php" class="logout-link">Sign Out</a>
        </div>
        
        <h1>Cast Your Vote</h1>
        <p class="subtitle">Select your preferred representative below</p>
        
        <?php if ($has_voted): ?>
            <div style="text-align: center; padding: 40px 20px; background: #f0fdf4; border-radius: 24px; border: 1px solid #bbf7d0;">
                <h2 style="color: #166534; margin-bottom: 12px;">Vote Successfully Cast!</h2>
                <p style="color: #15803d; margin-bottom: 24px;">Your participation strengthens our democracy. Thank you!</p>
                <a href="logout.php" style="text-decoration: none;"><button style="width: auto; padding: 12px 32px;">Exit Dashboard</button></a>
            </div>
        <?php else: ?>
            <div class="party-list">
                <?php foreach ($parties as $party): ?>
                    <div class="party-card">
                        <h3><?php echo htmlspecialchars($party['party_name']); ?></h3>
                        <form action="vote.php" method="POST">
                            <input type="hidden" name="party_id" value="<?php echo $party['id']; ?>">
                            <button type="submit" class="vote-btn">Vote Now</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
