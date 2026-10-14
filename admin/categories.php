<?php
/**
 * Maha Sarakham Travel Guide - Categories Management (admin/categories.php)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';
$success = '';

// Handle POST Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? 'bi-geo-alt');

        if (empty($name)) {
            $error = 'กรุณาระบุชื่อหมวดหมู่';
        } else {
            if (empty($slug)) {
                $slug = 'cat-' . time();
            }
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, icon) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $slug, $description, $icon]);
                $success = 'เพิ่มหมวดหมู่สำเร็จ';
            } catch (PDOException $e) {
                $error = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? 'bi-geo-alt');

        if ($id > 0 && !empty($name)) {
            try {
                $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, icon = ? WHERE id = ?");
                $stmt->execute([$name, $slug, $description, $icon, $id]);
                $success = 'แก้ไขหมวดหมู่สำเร็จ';
            } catch (PDOException $e) {
                $error = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            // Check if attractions are linked
            $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM attractions WHERE category_id = ?");
            $check_stmt->execute([$id]);
            $count = $check_stmt->fetchColumn();

            if ($count > 0) {
                $error = "ไม่สามารถลบหมวดหมู่นี้ได้ เนื่องจากมีสถานที่ท่องเที่ยวใช้งานอยู่ {$count} แห่ง (กรุณาย้ายหรือลบสถานที่ดังกล่าวก่อน)";
            } else {
                try {
                    $del_stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                    $del_stmt->execute([$id]);
                    $success = 'ลบหมวดหมู่เรียบร้อยแล้ว';
                } catch (PDOException $e) {
                    $error = 'เกิดข้อผิดพลาดในการลบ: ' . $e->getMessage();
                }
            }
        }
    }
}

// Fetch categories with counts
try {
    $stmt = $pdo->query("
        SELECT c.*, COUNT(a.id) as attraction_count 
        FROM categories c 
        LEFT JOIN attractions a ON c.id = a.category_id 
        GROUP BY c.id 
        ORDER BY c.id ASC
    ");
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่ - ระบบผู้ดูแล</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

<div class="container py-4" style="max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold font-prompt mb-0">จัดการหมวดหมู่สถานที่ท่องเที่ยว</h3>
            <p class="text-muted small mb-0">เพิ่ม แก้ไข ลบ ประเภทและหมวดหมู่การท่องเที่ยว</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle me-1"></i>เพิ่มหมวดหมู่ใหม่
            </button>
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i>กลับแดชบอร์ด
            </a>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger rounded-3 alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= e($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success rounded-3 alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= e($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th style="width: 70px;">ไอคอน</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th>Slug</th>
                        <th>คำอธิบาย</th>
                        <th class="text-center">จำนวนสถานที่</th>
                        <th class="text-end pe-4" style="width: 120px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= e($cat['id']) ?></td>
                            <td>
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-success" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="bi <?= e($cat['icon']) ?>"></i>
                                </div>
                            </td>
                            <td><strong class="text-dark"><?= e($cat['name']) ?></strong></td>
                            <td><code><?= e($cat['slug']) ?></code></td>
                            <td class="small text-muted"><?= e($cat['description']) ?></td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3 py-1 rounded-pill">
                                    <?= e($cat['attraction_count']) ?> แห่ง
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="categories.php" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบหมวดหมู่นี้?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= e($cat['id']) ?>">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="ลบ" <?= $cat['attraction_count'] > 0 ? 'disabled' : '' ?>>
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

<!-- Modal Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold font-prompt">เพิ่มหมวดหมู่ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="categories.php" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น ตลาดน้ำและถนนคนเดิน">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug (URL)</label>
                        <input type="text" name="slug" class="form-control" placeholder="เช่น night-markets">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ไอคอน Bootstrap Icons</label>
                        <input type="text" name="icon" class="form-control" value="bi-geo-alt" placeholder="เช่น bi-shop, bi-cup-hot">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">คำอธิบายสั้น</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary-custom px-4">บันทึกหมวดหมู่</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
