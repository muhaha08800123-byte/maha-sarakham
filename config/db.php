<?php
/**
 * Maha Sarakham Travel Guide
 * Database Connection via PDO (PHP Data Objects)
 * Connected to MySQL (phpMyAdmin / XAMPP)
 */

$db_host = '127.0.0.1';
$db_port = '3306';
$db_name = 'maha_sarakham_travel';
$db_user = 'root';
$db_pass = ''; // Default password for XAMPP is empty
$charset = 'utf8mb4';

$dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_TIMEOUT            => 5,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // In production, avoid exposing raw database error
    error_log("Database Connection Error: " . $e->getMessage());
    die("ขออภัย ระบบไม่สามารถเชื่อมต่อฐานข้อมูลได้ในขณะนี้ กรุณาตรวจสอบการเปิดใช้งาน MySQL ใน XAMPP Control Panel");
}
?>

