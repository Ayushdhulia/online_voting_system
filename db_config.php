<?php
// Database configuration
$host = 'localhost';
$db   = 'voting_db';
$user = 'root'; // Update with your MySQL username
$pass = '93060@Ayush';     // Update with your MySQL password
$charset = 'utf8mb4';

try {
    // First, connect without a database to create it if it doesn't exist
    $dsn_no_db = "mysql:host=$host;charset=$charset";
    $pdo_init = new PDO($dsn_no_db, $user, $pass);
    $pdo_init->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo_init->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset");
    
    // Now connect to the actual database
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Create tables if they don't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        has_voted TINYINT(1) DEFAULT 0
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS parties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        party_name VARCHAR(100) NOT NULL,
        vote_count INT DEFAULT 0
    )");

    // Seed parties if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM parties");
    if ($stmt->fetchColumn() == 0) {
        $parties = ['BJP', 'Congress', 'Aam Aadmi Party', 'Bahujan Samaj Party', 'Communist Party of India'];
        $insertStmt = $pdo->prepare("INSERT INTO parties (party_name) VALUES (?)");
        foreach ($parties as $party) {
            $insertStmt->execute([$party]);
        }
    }

} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
