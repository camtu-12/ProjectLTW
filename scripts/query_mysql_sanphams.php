<?php
$host = '127.0.0.1';
$db   = 'doanlaptrinhweb';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT id, tensanpham, hinhanh FROM sanphams ORDER BY id DESC LIMIT 10");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
} catch (PDOException $e) {
    echo 'DB Error: ' . $e->getMessage() . PHP_EOL;
}
