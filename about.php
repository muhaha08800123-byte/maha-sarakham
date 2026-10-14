<?php
/**
 * Maha Sarakham Travel Guide - About & Contact (about.php)
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'เกี่ยวกับเราและข้อมูลจังหวัด - ท่องเที่ยวสารคาม';
$current_page = 'about';

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">เกี่ยวกับเรา</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold mb-1">เกี่ยวกับโครงการ & มหาสารคาม</h1>
        <p class="text-muted mb-0">ข้อมูลเกี่ยวกับระบบ Maha Sarakham Travel Guide และข้อมูลสำคัญเกี่ยวกับจังหวัดมหาสารคาม</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>มหาสารคาม เมืองตักสิลานคร
                </h4>
                <p class="lh-lg text-secondary">
                    จังหวัดมหาสารคาม เป็นจังหวัดที่ตั้งอยู่ใจกลางภาคตะวันออกเฉียงเหนือของประเทศไทย มีประวัติศาสตร์อันยาวนานตั้งแต่สมัยอารยธรรมทวารวดีและขอมโบราณ โดยเฉพาะการขุดค้นพบพระบรมสารีริกธาตุ ณ อำเภอนาดูน อันเป็นหลักฐานของนครจำปาศรีอันรุ่งเรือง
                </p>
                <p class="lh-lg text-secondary">
                    นอกจากนี้ มหาสารคามยังได้รับการขนานนามว่าเป็น <strong>"เมืองตักสิลานครแห่งอีสาน"</strong> เนื่องจากเป็นศูนย์กลางทางการศึกษา มีสถาบันการศึกษาสำคัญระดับอุดมศึกษาหลายแห่ง และยังคงรักษาขนบธรรมเนียม ประเพณีฮีตสิบสองครองสิบสี่ และภูมิปัญญาพื้นบ้านอีสานไว้อย่างเหนียวแน่น
                </p>

                <div class="row g-3 mt-2">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold text-success mb-1"><i class="bi bi-flower1 me-1"></i>ดอกไม้ประจำจังหวัด</h6>
                            <p class="small text-muted mb-0">ดอกลั่นทมขาว (ดอกลีลาวดี)</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold text-success mb-1"><i class="bi bi-tree me-1"></i>ต้นไม้ประจำจังหวัด</h6>
                            <p class="small text-muted mb-0">ต้นพฤกษ์ (Albizia lebbeck)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3 text-secondary border-bottom pb-2">
                    <i class="bi bi-code-slash text-success me-2"></i>เกี่ยวกับเว็บไซต์ Maha Sarakham Travel Guide
                </h4>
                <p class="lh-lg text-secondary mb-3">
                    เว็บไซต์นี้พัฒนาขึ้นโดยมีเป้าหมายเพื่อเป็นสื่อกลางในการเผยแพร่ ประชาสัมพันธ์ และส่งเสริมการท่องเที่ยวของจังหวัดมหาสารคาม รวบรวมข้อมูลสถานที่สำคัญ 15 แห่ง พร้อมระบบแผนที่นำทาง ข้อมูลเวลาทำการ อัตราค่าเข้าชม และประวัติศาสตร์ที่ถูกต้อง
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-secondary">PHP 8.2</span>
                    <span class="badge bg-secondary">MySQL 8.0</span>
                    <span class="badge bg-secondary">PDO Database Connection</span>
                    <span class="badge bg-secondary">Bootstrap 5.3</span>
                    <span class="badge bg-secondary">Responsive Web Design</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3 border-bottom pb-2">ข้อมูลการติดต่อและศูนย์บริการ</h5>
                
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2">
                            <i class="bi bi-building fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">ศูนย์ข้อมูลการท่องเที่ยว</small>
                            <strong>การท่องเที่ยวและกีฬาจังหวัดมหาสารคาม</strong>
                            <div class="small text-muted">ศาลากลางจังหวัดมหาสารคาม อ.เมือง จ.มหาสารคาม 44000</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2">
                            <i class="bi bi-telephone fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">เบอร์โทรศัพท์ติดต่อ</small>
                            <span>043-777-123 (เวลาราชการ)</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2">
                            <i class="bi bi-shield-exclamation fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">แจ้งเหตุด่วนเหตุฉุกเฉิน</small>
                            <span>ตำรวจท่องเที่ยว 1155 / เหตุด่วน 191</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning border-0 small mb-0 rounded-3">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    <strong>คำแนะนำ:</strong> ข้อมูลเวลาทำการและค่าเข้าชมอาจมีการเปลี่ยนแปลงตามประกาศของแต่ละสถานที่ แนะนำให้ตรวจสอบล่วงหน้าก่อนออกเดินทาง
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

