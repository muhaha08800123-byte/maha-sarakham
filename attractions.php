<?php
/**
 * Maha Sarakham Travel Guide - All Attractions (attractions.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'แหล่งท่องเที่ยวทั้งหมด - ท่องเที่ยวสารคาม';
$current_page = 'attractions';

// Handle Search and Filter
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Fetch Categories for Filter Buttons
try {
    $cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
    $categories = $cat_stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Build query for attractions
$sql = "
    SELECT a.*, c.name as category_name 
    FROM attractions a 
    JOIN categories c ON a.category_id = c.id 
    WHERE a.status = 'published'
";
$params = [];

if (!empty($search_query)) {
    $sql .= " AND (a.name_th LIKE ? OR a.name_en LIKE ? OR a.history LIKE ? OR a.highlights LIKE ?)";
    $like = "%{$search_query}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($category_filter > 0) {
    $sql .= " AND a.category_id = ?";
    $params[] = $category_filter;
}

$sql .= " ORDER BY a.id ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $attractions = $stmt->fetchAll();
} catch (PDOException $e) {
    $attractions = [];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">แหล่งท่องเที่ยวทั้งหมด</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold mb-1">แหล่งท่องเที่ยวจังหวัดมหาสารคาม</h1>
        <p class="text-muted mb-0">ค้นพบความงดงามของแหล่งท่องเที่ยวทั้ง 15 แห่ง ค้นหาและกรองตามประเภทสถานที่ได้ที่นี่</p>
    </div>
</div>

<div class="container py-4">
    <!-- Search and Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="attractions.php" method="GET" class="row g-3 align-items-center">
            <div class="col-lg-6 col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="พิมพ์ชื่อสถานที่ท่องเที่ยว..." value="<?= e($search_query) ?>">
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="0">-- ทุกหมวดหมู่ --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['id']) ?>" <?= $category_filter == $cat['id'] ? 'selected' : '' ?>>
                            <?= e($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom w-100">ค้นหา</button>
                <?php if (!empty($search_query) || $category_filter > 0): ?>
                    <a href="attractions.php" class="btn btn-outline-secondary" title="ล้างตัวกรอง">
                        <i class="bi bi-x-circle"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Category Pills Shortcut -->
        <div class="d-flex gap-2 flex-wrap mt-3 pt-3 border-top">
            <a href="attractions.php" class="badge rounded-pill text-decoration-none px-3 py-2 <?= $category_filter == 0 ? 'bg-success text-white' : 'bg-light text-dark border' ?>">
                ทั้งหมด (15)
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="attractions.php?category=<?= e($cat['id']) ?>" class="badge rounded-pill text-decoration-none px-3 py-2 <?= $category_filter == $cat['id'] ? 'bg-success text-white' : 'bg-light text-dark border' ?>">
                    <?= e($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Attractions Results -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 text-muted">
            พบสถานที่ท่องเที่ยว <strong class="text-success"><?= count($attractions) ?></strong> แห่ง
            <?php if (!empty($search_query)): ?>
                สำหรับคำค้น "<em><?= e($search_query) ?></em>"
            <?php endif; ?>
        </h5>
    </div>

    <?php if (empty($attractions)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 my-4">
            <i class="bi bi-search display-1 text-muted mb-3"></i>
            <h4>ไม่พบสถานที่ท่องเที่ยวที่ตรงกับเงื่อนไข</h4>
            <p class="text-muted">ลองเปลี่ยนคำค้นหา หรือเลือกหมวดหมู่อื่นดูนะครับ</p>
            <div>
                <a href="attractions.php" class="btn btn-primary-custom">ดูสถานที่ทั้งหมด</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($attractions as $item): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="card-img-wrapper">
                            <span class="category-tag">
                                <i class="bi bi-tag-fill me-1"></i><?= e($item['category_name']) ?>
                            </span>
                            <span class="time-tag">
                                <i class="bi bi-clock me-1 text-primary"></i><?= format_time_range($item['opening_time'], $item['closing_time'], $item['is_open_24_hours']) ?>
                            </span>
                            <img src="<?= e(get_image_url($item['image_url'])) ?>" alt="<?= e($item['name_th']) ?>" loading="lazy">
                        </div>
                        <div class="card-body-custom">
                            <h3 class="attraction-title">
                                <a href="attraction-detail.php?id=<?= e($item['id']) ?>" class="text-decoration-none text-reset">
                                    <?= e($item['name_th']) ?>
                                </a>
                            </h3>
                            <div class="attraction-en-name"><?= e($item['name_en'] ?? '') ?></div>
                            <p class="attraction-desc"><?= e($item['history'] ?? 'สถานที่ท่องเที่ยวอันทรงคุณค่าของจังหวัดมหาสารคาม') ?></p>
                            
                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-ticket-perforated me-1 text-success"></i><?= e($item['admission_fee']) ?>
                                </small>
                                <a href="attraction-detail.php?id=<?= e($item['id']) ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    รายละเอียด <i class="bi bi-chevron-right small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

