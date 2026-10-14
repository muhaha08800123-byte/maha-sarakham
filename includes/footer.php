<?php
/**
 * Maha Sarakham Travel Guide - Shared Footer
 */
?>
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-3 font-prompt">
                    <i class="bi bi-geo-alt-fill text-warning me-2"></i>ท่องเที่ยวสารคาม
                </h5>
                <p class="text-light-50 small mb-3">
                    เว็บไซต์แนะนำแหล่งท่องเที่ยวจังหวัดมหาสารคาม แดนพุทธมณฑลอีสาน ศิลปวัฒนธรรมล้ำค่า และวิถีชีวิตอันทรงเสน่ห์ รวบรวม 15 แหล่งท่องเที่ยวสำคัญอย่างครบถ้วน
                </p>
                <div class="d-flex gap-2">
                    <span class="badge bg-secondary bg-opacity-50">Bootstrap 5</span>
                    <span class="badge bg-secondary bg-opacity-50">PHP PDO</span>
                    <span class="badge bg-secondary bg-opacity-50">MySQL</span>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="text-white mb-3 font-prompt">เมนูหลัก</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="index.php"><i class="bi bi-chevron-right me-1"></i>หน้าแรก</a></li>
                    <li><a href="attractions.php"><i class="bi bi-chevron-right me-1"></i>แหล่งท่องเที่ยวทั้งหมด</a></li>
                    <li><a href="categories.php"><i class="bi bi-chevron-right me-1"></i>หมวดหมู่</a></li>
                    <li><a href="routes.php"><i class="bi bi-chevron-right me-1"></i>เส้นทางท่องเที่ยว</a></li>
                    <li><a href="about.php"><i class="bi bi-chevron-right me-1"></i>เกี่ยวกับเรา</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="text-white mb-3 font-prompt">หมวดหมู่ท่องเที่ยว</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="attractions.php?category=1"><i class="bi bi-bank me-1"></i>วัดและศาสนสถาน</a></li>
                    <li><a href="attractions.php?category=2"><i class="bi bi-hourglass-split me-1"></i>โบราณสถาน</a></li>
                    <li><a href="attractions.php?category=3"><i class="bi bi-tree me-1"></i>ธรรมชาติและพักผ่อน</a></li>
                    <li><a href="attractions.php?category=4"><i class="bi bi-mortarboard me-1"></i>ศิลปวัฒนธรรม</a></li>
                    <li><a href="attractions.php?category=5"><i class="bi bi-pin-map me-1"></i>แลนด์มาร์กสำคัญ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-white mb-3 font-prompt">ผู้ดูแลระบบ</h6>
                <p class="small text-light-50 mb-3">
                    ระบบจัดการข้อมูลแหล่งท่องเที่ยว เพิ่ม แก้ไข ลบ และเปลี่ยนสถานะการเผยแพร่
                </p>
                <a href="admin/login.php" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-box-arrow-in-right me-1"></i>เข้าสู่ระบบหลังบ้าน
                </a>
            </div>
        </div>

        <div class="footer-bottom text-center">
            <p class="mb-0">
                &copy; <?= date('Y') ?> <strong>Maha Sarakham Travel Guide</strong>. พัฒนาขึ้นเพื่อการศึกษาและการท่องเที่ยวจังหวัดมหาสารคาม
            </p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

