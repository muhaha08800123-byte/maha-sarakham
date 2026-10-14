<?php
/**
 * Maha Sarakham Travel Guide - Admin Dashboard (admin/index.php)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Fetch statistics
try {
    $total_attr = $pdo->query("SELECT COUNT(*) FROM attractions")->fetchColumn();
    $published_attr = $pdo->query("SELECT COUNT(*) FROM attractions WHERE status = 'published'")->fetchColumn();
    $draft_attr = $pdo->query("SELECT COUNT(*) FROM attractions WHERE status = 'draft'")->fetchColumn();
    $total_cat = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

    // Fetch recent attractions
    $recent_stmt = $pdo->query("
        SELECT a.*, c.name as category_name 
        FROM attractions a 
        JOIN categories c ON a.category_id = c.id 
        ORDER BY a.id ASC
    ");
    $attractions = $recent_stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ดผู้ดูแลระบบ - ท่องเที่ยวสารคาม</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-nav {
            background-color: #879bd7 !important;
            border-bottom: 2px solid #3d40d4;
        }
        .stat-card {
            border-radius: 1rem;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="bg-light">

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg admin-nav navbar-dark sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand font-prompt fw-bold text-white" href="index.php">
            <i class="bi bi-shield-check text-warning me-2"></i>ระบบผู้ดูแล - ท่องเที่ยวสารคาม
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="../index.php" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i>ดูหน้าเว็บไซต์
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <span class="text-light small">
                        <i class="bi bi-person-circle me-1 text-warning"></i><?= e($_SESSION['admin_fullname']) ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm btn-outline-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i>ออกจากระบบ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="font-prompt fw-bold mb-0">แผงควบคุมระบบ (Dashboard)</h2>
            <p class="text-muted small mb-0">ยินดีต้อนรับคุณ <?= e($_SESSION['admin_fullname']) ?> เข้าสู่ระบบจัดการข้อมูล</p>
        </div>
        <div class="d-flex gap-2">
            <a href="attraction_form.php" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle me-1"></i>เพิ่มสถานที่ใหม่
            </a>
            <a href="categories.php" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-folder me-1"></i>จัดการหมวดหมู่
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">สถานที่ทั้งหมด</span>
                        <h3 class="fw-bold mb-0 text-dark"><?= e($total_attr) ?></h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3">
                        <i class="bi bi-geo-alt-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">เผยแพร่แล้ว (Published)</span>
                        <h3 class="fw-bold mb-0 text-success"><?= e($published_attr) ?></h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-3">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">ฉบับร่าง (Draft)</span>
                        <h3 class="fw-bold mb-0 text-secondary"><?= e($draft_attr) ?></h3>
                    </div>
                    <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary p-3">
                        <i class="bi bi-pencil-square fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">หมวดหมู่ทั้งหมด</span>
                        <h3 class="fw-bold mb-0 text-warning"><?= e($total_cat) ?></h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3">
                        <i class="bi bi-folder-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attractions Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 font-prompt">
                <i class="bi bi-list-task me-2 text-success"></i>รายการแหล่งท่องเที่ยว (<?= count($attractions) ?> รายการ)
            </h5>
            <span class="badge bg-light text-muted border">ข้อมูลอัปเดตล่าสุดจากฐานข้อมูล</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#</th>
                        <th>ชื่อสถานที่</th>
                        <th>หมวดหมู่</th>
                        <th>เวลาทำการ</th>
                        <th>ค่าเข้าชม</th>
                        <th>สถานะ</th>
                        <th class="text-end pe-3" style="width: 180px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attractions as $item): ?>
                        <tr>
                            <td class="ps-3 fw-bold text-muted"><?= e($item['id']) ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= e($item['name_th']) ?></div>
                                <small class="text-muted"><?= e($item['name_en'] ?? '') ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= e($item['category_name']) ?></span>
                            </td>
                            <td class="small">
                                <?= format_time_range($item['opening_time'], $item['closing_time'], $item['is_open_24_hours']) ?>
                            </td>
                            <td class="small text-success fw-medium">
                                <?= e($item['admission_fee']) ?>
                            </td>
                            <td>
                                <?php if ($item['status'] === 'published'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle">
                                        <i class="bi bi-check-circle me-1"></i>เผยแพร่แล้ว
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border">
                                        <i class="bi bi-dash-circle me-1"></i>ฉบับร่าง
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <a href="../attraction-detail.php?id=<?= e($item['id']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="ดูหน้าเว็บ">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="attraction_form.php?id=<?= e($item['id']) ?>" class="btn btn-sm btn-outline-primary" title="แก้ไข">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="attraction_delete.php" method="POST" class="d-inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสถานที่ \'<?= e(addslashes($item['name_th'])) ?>\' ?');">
                                    <input type="hidden" name="id" value="<?= e($item['id']) ?>">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="ลบ">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

