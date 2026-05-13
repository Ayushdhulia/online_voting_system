<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "<script>alert('Access Denied: Admin privileges required.'); window.location.href='index.php';</script>";
    exit();
}

$stmt = $pdo->query("SELECT * FROM parties");
$parties = $stmt->fetchAll();
$total_votes = array_sum(array_column($parties, 'vote_count'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Election Results</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { max-width: 700px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
        .stat-card { background: #f8fafc; padding: 20px; border-radius: 16px; text-align: center; border: 1px solid var(--border); }
        .stat-val { font-size: 1.5rem; font-weight: 800; color: var(--primary); }
        .stat-label { font-size: 0.8rem; color: var(--text-light); font-weight: 600; text-transform: uppercase; }
        .result-item { margin-bottom: 24px; background: white; padding: 20px; border-radius: 20px; border: 1px solid var(--border); transition: 0.3s; }
        .result-item:hover { border-color: var(--primary); transform: scale(1.01); }
        .result-info { display: flex; justify-content: space-between; margin-bottom: 12px; align-items: center; }
        .party-name { font-weight: 700; color: var(--text); }
        .vote-stats { text-align: right; }
        .vote-count { font-weight: 800; color: var(--primary); display: block; }
        .vote-pct { font-size: 0.8rem; color: var(--text-light); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .admin-badge { background: #1e293b; color: white; padding: 6px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="header-flex">
            <div class="admin-badge">Admin: <?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
            <a href="logout.php" class="logout-link">Sign Out</a>
        </div>
        
        <h1>Election Overview</h1>
        <p class="subtitle">Real-time voting analytics dashboard</p>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-val"><?php echo $total_votes; ?></div>
                <div class="stat-label">Total Votes</div>
            </div>
            <div class="stat-card">
                <div class="stat-val"><?php echo count($parties); ?></div>
                <div class="stat-label">Parties</div>
            </div>
        </div>
        
        <div class="results-container">
            <?php foreach ($parties as $party): 
                $percentage = $total_votes > 0 ? ($party['vote_count'] / $total_votes) * 100 : 0;
            ?>
                <div class="result-item fade-in">
                    <div class="result-info">
                        <span class="party-name"><?php echo htmlspecialchars($party['party_name']); ?></span>
                        <div class="vote-stats">
                            <span class="vote-count"><?php echo $party['vote_count']; ?> votes</span>
                            <span class="vote-pct"><?php echo round($percentage, 1); ?>% share</span>
                        </div>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: <?php echo $percentage; ?>%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
