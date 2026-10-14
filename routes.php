<?php
/**
 * Maha Sarakham Travel Guide - Travel Routes (routes.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'เส้นทางท่องเที่ยวแนะนำ - ท่องเที่ยวสารคาม';
$current_page = 'routes';

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">เส้นทางท่องเที่ยวแนะนำ</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold mb-1">เส้นทางท่องเที่ยวสารคาม</h1>
        <p class="text-muted mb-0">วางแผนการเดินทางอย่างสะดวกสบายด้วยทริปท่องเที่ยวที่ออกแบบมาอย่างลงตัว ทั้งแบบ 1 วัน และ 2 วัน 1 คืน</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Route 1 -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-1 fw-bold">1 Day Trip</span>
                        <h4 class="fw-bold mb-0 text-secondary">ทริปสายบุญ นมัสการพระธาตุและกู่โบราณ</h4>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3">
                        <i class="bi bi-compass fs-3"></i>
                    </div>
                </div>
                <p class="text-muted small">เส้นทางยอดนิยมสำหรับสายมูและผู้ชื่นชอบประวัติศาสตร์ สัมผัสความศักดิ์สิทธิ์และโบราณสถานสมัยทวารวดีและขอมโบราณ</p>
                
                <div class="timeline position-relative ps-4 border-start border-2 border-warning my-3 d-flex flex-column gap-3">
                    <div>
                        <span class="badge bg-light text-dark border small">08:30 - 10:00 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=3" class="text-decoration-none text-success">1. วัดป่าวังน้ำเย็น (วัดพุทธวนาราม)</a></h6>
                        <p class="small text-muted mb-0">สักการะพระมหาเจดีย์สีทองอร่ามและชมศาลาไม้ซุงขนาดยักษ์อันงดงาม</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">11:00 - 13:00 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=2" class="text-decoration-none text-success">2. พระบรมธาตุนาดูน (พุทธมณฑลอีสาน)</a></h6>
                        <p class="small text-muted mb-0">กราบไหว้พระบรมสารีริกธาตุคู่บ้านคู่เมือง สัมผัสนครจำปาศรี และรับประทานอาหารกลางวัน</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">13:30 - 14:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=12" class="text-decoration-none text-success">3. กู่สันตรัตน์</a></h6>
                        <p class="small text-muted mb-0">ชมอโรคยาศาลโบราณสร้างด้วยศิลาแลงสมัยพระเจ้าชัยวรมันที่ 7 ศิลปะขอมแบบบายน</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">15:30 - 17:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=9" class="text-decoration-none text-success">4. สะพานไม้แกดำ</a></h6>
                        <p class="small text-muted mb-0">เดินเล่นรับลมเย็นบนสะพานไม้ยาวข้ามบึงบัวธรรมชาติ ชมวิวพระอาทิตย์ตกดินอันแสนโรแมนติก</p>
                    </div>
                </div>

                <div class="mt-auto pt-3 border-top">
                    <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i>ระยะทางรวมโดยประมาณ: 110 กม.</span>
                </div>
            </div>
        </div>

        <!-- Route 2 -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <div>
                        <span class="badge bg-success px-3 py-1 rounded-pill mb-1 fw-bold">1 Day Trip</span>
                        <h4 class="fw-bold mb-0 text-secondary">ทริปธรรมชาติ เช็คอินแลนด์มาร์กสุดชิล</h4>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-3">
                        <i class="bi bi-tree fs-3"></i>
                    </div>
                </div>
                <p class="text-muted small">เส้นทางพักผ่อนหย่อนใจ เหมาะสำหรับครอบครัวและกลุ่มเพื่อน สัมผัสความร่มรื่น ถ่ายภาพเช็คอินจุดสำคัญ</p>
                
                <div class="timeline position-relative ps-4 border-start border-2 border-success my-3 d-flex flex-column gap-3">
                    <div>
                        <span class="badge bg-light text-dark border small">09:00 - 10:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=11" class="text-decoration-none text-success">1. วนอุทยานโกสัมพี</a></h6>
                        <p class="small text-muted mb-0">ชมฝูงลิงสีทองหายาก ลานต้นยางนายักษ์ริมฝั่งแม่น้ำชีอันร่มรื่น</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">11:00 - 12:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=15" class="text-decoration-none text-success">2. สะดืออีสาน (บึงกุย)</a></h6>
                        <p class="small text-muted mb-0">เช็คอินจุดพิกัดศูนย์กลางภูมิศาสตร์ของภาคอีสาน และพักรับประทานอาหารริมบึง</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">13:30 - 15:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=14" class="text-decoration-none text-success">3. พิพิธภัณฑ์บ้านอีสาน มมส.</a></h6>
                        <p class="small text-muted mb-0">เรียนรู้วิถีชีวิตชาวอีสาน สถาปัตยกรรมเรือนไทยอีสานดั้งเดิมกลางแจ้ง</p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark border small">16:30 - 18:30 น.</span>
                        <h6 class="fw-bold mt-1 mb-1"><a href="attraction-detail.php?id=10" class="text-decoration-none text-success">4. แก่งเลิงจาน</a></h6>
                        <p class="small text-muted mb-0">ออกกำลังกาย พักผ่อนหย่อนใจ นั่งจิบกาแฟชมพระอาทิตย์อัสดงสะท้อนผิวน้ำแก่งเลิงจาน</p>
                    </div>
                </div>

                <div class="mt-auto pt-3 border-top">
                    <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i>ระยะทางรวมโดยประมาณ: 65 กม.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

