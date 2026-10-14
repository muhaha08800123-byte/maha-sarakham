<?php
/**
 * Maha Sarakham Travel Guide - Categories (categories.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'หมวดหมู่ท่องเที่ยว - ท่องเที่ยวสารคาม';
$current_page = 'categories';

try {
    $cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
    $categories = $cat_stmt->fetchAll();

    // Fetch attractions grouped by category
    $attr_stmt = $pdo->query("
        SELECT id, category_id, name_th, name_en, image_url, admission_fee 
        FROM attractions 
        WHERE status = 'published' 
        ORDER BY id ASC
    ");
    $all_attractions = $attr_stmt->fetchAll();
    
    $grouped = [];
    foreach ($all_attractions as $a) {
        $grouped[$a['category_id']][] = $a;
    }
} catch (PDOException $e) {
    $categories = [];
    $grouped = [];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">หมวดหมู่ท่องเที่ยว</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold mb-1">หมวดหมู่แหล่งท่องเที่ยว</h1>
        <p class="text-muted mb-0">ค้นหาสถานที่ท่องเที่ยวตามประเภทที่ท่านชื่นชอบ ครอบคลุมทั้งสายบุญ ประวัติศาสตร์ ธรรมชาติ และวิถีอีสาน</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($categories as $cat): 
            $cat_items = $grouped[$cat['id']] ?? [];
        ?>
            <div class="col-12" id="cat-<?= e($cat['id']) ?>">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="category-icon-box m-0" style="width: 50px; height: 50px; line-height: 50px; font-size: 1.5rem;">
                                <i class="bi <?= e($cat['icon']) ?>"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0 text-secondary"><?= e($cat['name']) ?></h3>
                                <p class="text-muted small mb-0"><?= e($cat['description']) ?></p>
                            </div>
                        </div>
                        <a href="attractions.php?category=<?= e($cat['id']) ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">
                            ดูทั้งหมดในหมวดนี้ (<?= count($cat_items) ?>) <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body p-4 bg-light">
                        <div class="row g-3">
                            <?php foreach ($cat_items as $item): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="p-3 bg-white rounded-3 border h-100 d-flex flex-column">
                                        <div class="d-flex gap-3 align-items-center mb-2">
                                            <img src="<?= e(get_image_url($item['image_url'])) ?>" alt="<?= e($item['name_th']) ?>" class="rounded-3 object-fit-cover" width="70" height="60">
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    <a href="attraction-detail.php?id=<?= e($item['id']) ?>" class="text-decoration-none text-dark">
                                                        <?= e($item['name_th']) ?>
                                                    </a>
                                                </h6>
                                                <small class="text-muted d-block"><?= e($item['name_en'] ?? '') ?></small>
                                            </div>
                                        </div>
                                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                            <span class="badge bg-light text-secondary border small"><?= e($item['admission_fee']) ?></span>
                                            <a href="attraction-detail.php?id=<?= e($item['id']) ?>" class="small text-success text-decoration-none fw-semibold">
                                                ดูข้อมูล <i class="bi bi-chevron-right small"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
