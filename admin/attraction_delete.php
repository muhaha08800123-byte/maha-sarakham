<?php
/**
 * Maha Sarakham Travel Guide - Delete Attraction (admin/attraction_delete.php)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM attractions WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("ไม่สามารถลบข้อมูลได้: " . $e->getMessage());
        }
    }
}

header("Location: index.php?msg=deleted");
exit;
?>

