<?php
/**
 * Maha Sarakham Travel Guide - Homepage (index.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'หน้าแรก - ท่องเที่ยวสารคาม Maha Sarakham Travel Guide';
$current_page = 'home';

// Fetch Categories with counts
try {
    $cat_stmt = $pdo->query("
        SELECT c.*, COUNT(a.id) as attraction_count 
        FROM categories c 
        LEFT JOIN attractions a ON c.id = a.category_id AND a.status = 'published'
        GROUP BY c.id 
        ORDER BY c.id ASC
    ");
    $categories = $cat_stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Fetch Featured Attractions (6 items)
try {
    $attr_stmt = $pdo->query("
        SELECT a.*, c.name as category_name 
        FROM attractions a 
        JOIN categories c ON a.category_id = c.id 
        WHERE a.status = 'published' 
        ORDER BY a.id ASC 
        LIMIT 6
    ");
    $featured_attractions = $attr_stmt->fetchAll();
} catch (PDOException $e) {
    $featured_attractions = [];
}

// Total count of attractions
try {
    $total_stmt = $pdo->query("SELECT COUNT(*) FROM attractions WHERE status = 'published'");
    $total_attractions = $total_stmt->fetchColumn();
} catch (PDOException $e) {
    $total_attractions = 15;
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container py-4">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">
            <i class="bi bi-stars me-1"></i>มหาสารคาม เมืองตักสิลานคร แดนพุทธมณฑลอีสาน
        </span>
        <h1 class="hero-title mb-3">ค้นพบเสน่ห์แห่งมหาสารคาม</h1>
        <p class="hero-subtitle">
            สัมผัสมนต์เสน่ห์แห่งอารยธรรมทวารวดี ธรรมชาติอันร่มรื่น และวิถีชีวิตพื้นถิ่นที่เปี่ยมด้วยความอบอุ่น รวบรวม <?= e($total_attractions) ?> จุดหมายปลายทางยอดนิยม
        </p>

        <!-- Search Bar -->
        <div class="search-box-card">
            <form action="attractions.php" method="GET" class="d-flex align-items-center">
                <i class="bi bi-search text-muted fs-5 me-2"></i>
                <input type="text" name="q" class="form-control border-0 shadow-none ps-0" placeholder="ค้นหาชื่อสถานที่ท่องเที่ยว เช่น พระธาตุนาดูน, แกดำ..." autocomplete="off">
                <button type="submit" class="btn btn-primary-custom ms-2 text-nowrap">
                    ค้นหาทันที
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small">Explore By Category</span>
            <h2 class="display-6 fw-bold">หมวดหมู่ท่องเที่ยว</h2>
            <div class="mx-auto" style="width: 60px; height: 3px; background-color: var(--accent-gold); border-radius: 2px;"></div>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($categories as $cat): ?>
                <div class="col-lg-2 col-md-4 col-6">
                    <a href="attractions.php?category=<?= e($cat['id']) ?>" class="category-card">
                        <div class="category-icon-box">
                            <i class="bi <?= e($cat['icon']) ?>"></i>
                        </div>
                        <h6 class="fw-bold mb-1"><?= e($cat['name']) ?></h6>
                        <span class="badge bg-light text-secondary rounded-pill small">
                            <?= e($cat['attraction_count']) ?> สถานที่
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Attractions Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <span class="text-uppercase text-muted fw-bold small">Popular Destinations</span>
                <h2 class="display-6 fw-bold mb-0">สถานที่ท่องเที่ยวยอดนิยม</h2>
            </div>
            <a href="attractions.php" class="btn btn-outline-dark rounded-pill px-4">
                ดูทั้งหมด <?= e($total_attractions) ?> แห่ง <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($featured_attractions as $item): ?>
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
    </div>
</section>

<!-- Travel Highlights / Features -->
<section class="py-5" style="background-color: #f7e3c0;">
    <div class="container py-3">
        <div class="text-center mb-5">
            <span class="text-uppercase text-muted fw-bold small">Why Visit Maha Sarakham</span>
            <h2 class="display-6 fw-bold">ทำไมต้องมาเที่ยวมหาสารคาม?</h2>
            <div class="mx-auto" style="width: 60px; height: 3px; background-color: var(--accent-gold); border-radius: 2px;"></div>
        </div>

        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-bank fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">พุทธมณฑลอีสาน</h5>
                    <p class="text-muted small mb-0">
                        นมัสการพระบรมธาตุนาดูน ศูนย์รวมจิตใจของชาวอีสานที่มีอายุกว่าพันปี พร้อมพระพุทธรูปคู่บ้านคู่เมือง
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-camera fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">แลนด์มาร์กสุดชิค</h5>
                    <p class="text-muted small mb-0">
                        เดินทอดน่องบนสะพานไม้แกดำยาวเกือบ 1 กม. ข้ามบึงบัวธรรมชาติ และชมวิวพระอาทิตย์ตกที่แก่งเลิงจาน
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-compass fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">อารยธรรมและวิถีอีสาน</h5>
                    <p class="text-muted small mb-0">
                        ย้อนรอยประวัติศาสตร์กู่ขอมโบราณ ศึกษาภูมิปัญญาเรือนไทยอีสาน และเช็คอินที่จุดสะดืออีสาน
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #856650); color: white;">
    <div class="container text-center py-3">
        <h3 class="fw-bold mb-3">วางแผนทริปเที่ยวมหาสารคามของคุณได้แล้ววันนี้</h3>
        <p class="text-white-50 max-w-600 mx-auto mb-4">
            เลือกดูเส้นทางท่องเที่ยวแนะนำแบบ 1 วัน หรือค้นหาสถานที่ท่องเที่ยวที่คุณสนใจได้ทันที
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="attractions.php" class="btn btn-gold-custom px-4 py-2">
                <i class="bi bi-geo-alt me-1"></i>ดูสถานที่ทั้งหมด (15 แห่ง)
            </a>
            <a href="routes.php" class="btn btn-outline-light rounded-pill px-4 py-2">
                <i class="bi bi-signpost-2 me-1"></i>ดูเส้นทางท่องเที่ยว
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
