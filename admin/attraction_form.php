<?php
/**
 * Maha Sarakham Travel Guide - Add / Edit Attraction (admin/attraction_form.php)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = ($id > 0);
$error = '';
$success = '';

// Fetch Categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();

// Default values
$data = [
    'category_id' => $categories[0]['id'] ?? 1,
    'name_th' => '',
    'name_en' => '',
    'slug' => '',
    'history' => '',
    'highlights' => '',
    'opening_time' => '08:00',
    'closing_time' => '18:00',
    'is_open_24_hours' => 0,
    'operating_days' => 'เปิดให้บริการทุกวัน',
    'admission_fee' => 'เข้าชมฟรี',
    'image_url' => 'assets/images/placeholder.svg',
    'address' => '',
    'travel_info' => '',
    'google_maps_url' => '',
    'facilities' => '',
    'nearby_places' => '',
    'visitor_tips' => '',
    'status' => 'published'
];

if ($is_edit) {
    $stmt = $pdo->prepare("SELECT * FROM attractions WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $data = $existing;
    } else {
        header("Location: index.php");
        exit;
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $name_th = trim($_POST['name_th'] ?? '');
    $name_en = trim($_POST['name_en'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 1);
    $slug = trim($_POST['slug'] ?? '');
    $history = trim($_POST['history'] ?? '');
    $highlights = trim($_POST['highlights'] ?? '');
    $is_open_24_hours = isset($_POST['is_open_24_hours']) ? 1 : 0;
    $opening_time = $is_open_24_hours ? null : (!empty($_POST['opening_time']) ? $_POST['opening_time'] : null);
    $closing_time = $is_open_24_hours ? null : (!empty($_POST['closing_time']) ? $_POST['closing_time'] : null);
    $operating_days = trim($_POST['operating_days'] ?? 'เปิดให้บริการทุกวัน');
    $admission_fee = trim($_POST['admission_fee'] ?? 'เข้าชมฟรี');
    $image_url = trim($_POST['image_url'] ?? 'assets/images/placeholder.svg');
    $address = trim($_POST['address'] ?? '');
    $travel_info = trim($_POST['travel_info'] ?? '');
    $google_maps_url = trim($_POST['google_maps_url'] ?? '');
    $facilities = trim($_POST['facilities'] ?? '');
    $nearby_places = trim($_POST['nearby_places'] ?? '');
    $visitor_tips = trim($_POST['visitor_tips'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'published';

    // Handle File Upload if provided
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_ext, $allowed)) {
            $new_name = 'attraction_' . time() . '_' . mt_rand(100, 999) . '.' . $file_ext;
            $upload_path = __DIR__ . '/../assets/images/attractions/' . $new_name;
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image_url = 'assets/images/attractions/' . $new_name;
            }
        }
    }

    if (empty($name_th)) {
        $error = 'กรุณาระบุชื่อสถานที่ (ภาษาไทย)';
    } elseif (empty($google_maps_url)) {
        $error = 'กรุณาระบุลิงก์ Google Maps';
    } else {
        if (empty($slug)) {
            $slug = 'place-' . time();
        }

        try {
            if ($is_edit) {
                $sql = "UPDATE attractions SET 
                    category_id = ?, name_th = ?, name_en = ?, slug = ?, history = ?, highlights = ?,
                    opening_time = ?, closing_time = ?, is_open_24_hours = ?, operating_days = ?,
                    admission_fee = ?, image_url = ?, address = ?, travel_info = ?, google_maps_url = ?,
                    facilities = ?, nearby_places = ?, visitor_tips = ?, status = ?
                    WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $category_id, $name_th, $name_en, $slug, $history, $highlights,
                    $opening_time, $closing_time, $is_open_24_hours, $operating_days,
                    $admission_fee, $image_url, $address, $travel_info, $google_maps_url,
                    $facilities, $nearby_places, $visitor_tips, $status, $id
                ]);
            } else {
                $sql = "INSERT INTO attractions (
                    category_id, name_th, name_en, slug, history, highlights,
                    opening_time, closing_time, is_open_24_hours, operating_days,
                    admission_fee, image_url, address, travel_info, google_maps_url,
                    facilities, nearby_places, visitor_tips, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $category_id, $name_th, $name_en, $slug, $history, $highlights,
                    $opening_time, $closing_time, $is_open_24_hours, $operating_days,
                    $admission_fee, $image_url, $address, $travel_info, $google_maps_url,
                    $facilities, $nearby_places, $visitor_tips, $status
                ]);
            }

            header("Location: index.php?msg=saved");
            exit;
        } catch (PDOException $e) {
            $error = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? 'แก้ไขสถานที่' : 'เพิ่มสถานที่ใหม่' ?> - ระบบผู้ดูแล</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

<div class="container py-4" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold font-prompt mb-0"><?= $is_edit ? 'แก้ไขข้อมูลแหล่งท่องเที่ยว' : 'เพิ่มแหล่งท่องเที่ยวใหม่' ?></h3>
            <p class="text-muted small mb-0">ระบบจัดการฐานข้อมูลท่องเที่ยวสารคาม</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i>ย้อนกลับแดชบอร์ด
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger rounded-3"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <form action="attraction_form.php<?= $is_edit ? '?id=' . $id : '' ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">ชื่อสถานที่ (ภาษาไทย) <span class="text-danger">*</span></label>
                    <input type="text" name="name_th" class="form-control" required value="<?= e($data['name_th']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">หมวดหมู่ <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= e($cat['id']) ?>" <?= $data['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">ชื่อสถานที่ (ภาษาอังกฤษ)</label>
                    <input type="text" name="name_en" class="form-control" value="<?= e($data['name_en'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Slug (URL เป็นมิตร)</label>
                    <input type="text" name="slug" class="form-control" value="<?= e($data['slug'] ?? '') ?>" placeholder="เช่น phra-that-na-dun">
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">ประวัติและความเป็นมา</label>
                    <textarea name="history" class="form-control" rows="4"><?= e($data['history'] ?? '') ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">จุดเด่นและไฮไลท์</label>
                    <textarea name="highlights" class="form-control" rows="3"><?= e($data['highlights'] ?? '') ?></textarea>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">เวลาเปิดทำการ</label>
                    <input type="time" name="opening_time" class="form-control" value="<?= e($data['opening_time'] ?? '08:00') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">เวลาปิดทำการ</label>
                    <input type="time" name="closing_time" class="form-control" value="<?= e($data['closing_time'] ?? '18:00') ?>">
                </div>
                <div class="col-md-3 d-flex align-items-center mt-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_open_24_hours" value="1" id="open24" <?= !empty($data['is_open_24_hours']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="open24">เปิด 24 ชั่วโมง</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">วันเปิดทำการ</label>
                    <input type="text" name="operating_days" class="form-control" value="<?= e($data['operating_days'] ?? 'เปิดให้บริการทุกวัน') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">อัตราค่าเข้าชม</label>
                    <input type="text" name="admission_fee" class="form-control" value="<?= e($data['admission_fee'] ?? 'เข้าชมฟรี') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">สถานะการแสดงผล</label>
                    <select name="status" class="form-select">
                        <option value="published" <?= $data['status'] === 'published' ? 'selected' : '' ?>>เผยแพร่ทันที (Published)</option>
                        <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>ฉบับร่าง (Draft)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">เส้นทางไฟล์รูปภาพ (URL/Path)</label>
                    <input type="text" name="image_url" class="form-control" value="<?= e($data['image_url'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">หรืออัปโหลดรูปภาพใหม่</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">ลิงก์ Google Maps <span class="text-danger">*</span></label>
                    <input type="url" name="google_maps_url" class="form-control" required value="<?= e($data['google_maps_url'] ?? '') ?>" placeholder="https://maps.app.goo.gl/...">
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">ที่อยู่ / พิกัดสถานที่</label>
                    <input type="text" name="address" class="form-control" value="<?= e($data['address'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">ข้อมูลการเดินทาง</label>
                    <textarea name="travel_info" class="form-control" rows="2"><?= e($data['travel_info'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">สิ่งอำนวยความสะดวก</label>
                    <textarea name="facilities" class="form-control" rows="2"><?= e($data['facilities'] ?? '') ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">สถานที่ท่องเที่ยวใกล้เคียง</label>
                    <textarea name="nearby_places" class="form-control" rows="2"><?= e($data['nearby_places'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">คำแนะนำสำหรับผู้มาเยือน</label>
                    <textarea name="visitor_tips" class="form-control" rows="2"><?= e($data['visitor_tips'] ?? '') ?></textarea>
                </div>

                <div class="col-12 mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                    <a href="index.php" class="btn btn-light px-4">ยกเลิก</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i>บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
