<?php
/**
 * Maha Sarakham Travel Guide - Attraction Detail (attraction-detail.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if ($id <= 0 && empty($slug)) {
    header("Location: attractions.php");
    exit;
}

try {
    if ($id > 0) {
        $stmt = $pdo->prepare("
            SELECT a.*, c.name as category_name, c.icon as category_icon 
            FROM attractions a 
            JOIN categories c ON a.category_id = c.id 
            WHERE a.id = ? AND a.status = 'published'
        ");
        $stmt->execute([$id]);
    } else {
        $stmt = $pdo->prepare("
            SELECT a.*, c.name as category_name, c.icon as category_icon 
            FROM attractions a 
            JOIN categories c ON a.category_id = c.id 
            WHERE a.slug = ? AND a.status = 'published'
        ");
        $stmt->execute([$slug]);
    }
    $item = $stmt->fetch();

    if (!$item) {
        header("Location: attractions.php");
        exit;
    }

    // Fetch related attractions in the same category
    $rel_stmt = $pdo->prepare("
        SELECT * FROM attractions 
        WHERE category_id = ? AND id != ? AND status = 'published' 
        LIMIT 3
    ");
    $rel_stmt->execute([$item['category_id'], $item['id']]);
    $related = $rel_stmt->fetchAll();

} catch (PDOException $e) {
    die("เกิดข้อผิดพลาดในการดึงข้อมูล");
}

$page_title = $item['name_th'] . ' - ท่องเที่ยวสารคาม';
$current_page = 'attractions';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb Header -->
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="attractions.php" class="text-decoration-none">แหล่งท่องเที่ยว</a></li>
                <li class="breadcrumb-item"><a href="attractions.php?category=<?= e($item['category_id']) ?>" class="text-decoration-none"><?= e($item['category_name']) ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= e($item['name_th']) ?></li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-1 rounded-pill">
                <i class="bi <?= e($item['category_icon']) ?> me-1"></i><?= e($item['category_name']) ?>
            </span>
            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1 rounded-pill">
                <i class="bi bi-clock me-1"></i><?= format_time_range($item['opening_time'], $item['closing_time'], $item['is_open_24_hours']) ?>
            </span>
        </div>
        <h1 class="display-6 fw-bold mb-1"><?= e($item['name_th']) ?></h1>
        <?php if (!empty($item['name_en'])): ?>
            <p class="text-muted fs-5 mb-0"><?= e($item['name_en']) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Hero Image -->
            <div class="rounded-4 overflow-hidden shadow-sm mb-4" style="max-height: 480px; background-color: #eae5de;">
                <img src="<?= e(get_image_url($item['image_url'])) ?>" alt="<?= e($item['name_th']) ?>" class="w-100 h-100 object-fit-cover" style="min-height: 320px;">
            </div>

            <!-- History Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                    <i class="bi bi-book-half text-success me-2"></i>ประวัติและความเป็นมา
                </h4>
                <div class="lh-lg text-secondary">
                    <?= nl2br(e($item['history'])) ?>
                </div>
            </div>

            <!-- Highlights Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                    <i class="bi bi-star-fill text-warning me-2"></i>จุดเด่นและไฮไลท์ที่ไม่ควรพลาด
                </h4>
                <div class="lh-lg text-secondary">
                    <?= nl2br(e($item['highlights'])) ?>
                </div>
            </div>

            <!-- Travel & Facilities Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                    <i class="bi bi-info-circle text-primary me-2"></i>การเดินทางและสิ่งอำนวยความสะดวก
                </h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold text-success mb-2"><i class="bi bi-car-front me-1"></i>การเดินทาง</h6>
                            <p class="small text-muted mb-0"><?= nl2br(e($item['travel_info'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold text-success mb-2"><i class="bi bi-tools me-1"></i>สิ่งอำนวยความสะดวก</h6>
                            <p class="small text-muted mb-0"><?= nl2br(e($item['facilities'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold text-success mb-2"><i class="bi bi-compass me-1"></i>สถานที่ใกล้เคียง</h6>
                            <p class="small text-muted mb-0"><?= nl2br(e($item['nearby_places'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold text-warning mb-2"><i class="bi bi-exclamation-triangle me-1"></i>คำแนะนำสำหรับผู้มาเยือน</h6>
                            <p class="small text-muted mb-0"><?= nl2br(e($item['visitor_tips'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3 border-bottom pb-2">ข้อมูลสำคัญสำหรับนักท่องเที่ยว</h5>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2">
                            <i class="bi bi-clock fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">เวลาเปิด-ปิดทำการ</small>
                            <strong><?= format_time_range($item['opening_time'], $item['closing_time'], $item['is_open_24_hours']) ?></strong>
                            <div class="small text-secondary"><?= e($item['operating_days']) ?></div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2">
                            <i class="bi bi-ticket-perforated fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">อัตราค่าเข้าชม</small>
                            <strong class="text-success"><?= e($item['admission_fee']) ?></strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2">
                            <i class="bi bi-geo-alt fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">ที่ตั้งและพิกัด</small>
                            <span><?= e($item['address']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Navigation Button -->
                <a href="<?= e($item['google_maps_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary-custom w-100 py-2 mb-2 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-map-fill"></i>เปิดนำทางด้วย Google Maps
                </a>

                <a href="attractions.php" class="btn btn-outline-secondary w-100 rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i>ย้อนกลับไปรายการทั้งหมด
                </a>

                <?php if (!empty($related)): ?>
                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">สถานที่ใกล้เคียงในหมวดนี้</h6>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($related as $rel): ?>
                            <a href="attraction-detail.php?id=<?= e($rel['id']) ?>" class="p-2 border rounded-3 text-decoration-none text-dark d-flex align-items-center gap-2 bg-light">
                                <i class="bi bi-geo-alt text-success"></i>
                                <span class="small fw-semibold text-truncate"><?= e($rel['name_th']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

