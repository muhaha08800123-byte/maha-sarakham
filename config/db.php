<?php
/**
 * Maha Sarakham Travel Guide
 * Database Connection via PDO (PHP Data Objects)
 * Connected to MySQL (phpMyAdmin / XAMPP)
 */

$db_host = 'localhost';
$db_port = '3306';
$db_name = 'maha_sarakham_travel';
$db_user = 'root';
$db_pass = ''; // Default password for XAMPP is empty
$charset = 'utf8mb4';

$dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // Auto-sync attraction images to match original folders
    static $synced = false;
    if (!$synced) {
        $synced = true;
        try {
            $image_maps = [
                1 => 'assets/images/attractions/muhaha png/1. ศาลหลักเมืองมหาสารคาม/IMG_1217.JPG',
                2 => 'assets/images/attractions/muhaha png/2. พระบรมธาตุนาดูน/IMG_1222.JPG',
                3 => 'assets/images/attractions/muhaha png/3. วัดป่าวังน้ำเย็น/IMG_1231.JPG',
                4 => 'assets/images/attractions/muhaha png/4. วัดหนองหูลิง/IMG_1233.JPG',
                5 => 'assets/images/attractions/muhaha png/5. พระพุทธรูปยืนมงคล วัดพุทธมงคล/IMG_1241.JPG',
                6 => 'assets/images/attractions/muhaha png/6. พระพุทธมิ่งเมือง วัดสุวรรณาวาส/IMG_1248.JPG',
                7 => 'assets/images/attractions/muhaha png/7. วัดป่าวังเลิง/IMG_1250.JPG',
                8 => 'assets/images/attractions/muhaha png/8. พระธาตุอินทร์แปลง/IMG_1256.JPG',
                9 => 'assets/images/attractions/muhaha png/9. สะพานไม้แกดำ/images.jpg',
                10 => 'assets/images/attractions/muhaha png/10. แก่งเลิงจาน/images (1).jpg',
                11 => 'assets/images/attractions/muhaha png/11. วนอุทยานโกสัมพี/IMG_1272.JPG',
                12 => 'assets/images/attractions/muhaha png/12. กู่สันตรัตน์/IMG_1277.JPG',
                13 => 'assets/images/attractions/muhaha png/13. กู่มหาธาตุ (ปรางค์กู่บ้านเขวา)/IMG_1281.JPG',
                14 => 'assets/images/attractions/muhaha png/14. พิพิธภัณฑ์บ้านอีสาน มหาวิทยาลัยมหาสารคาม/original_40762448.jpg',
                15 => 'assets/images/attractions/muhaha png/15. สะดืออีสาน/ING_333.jpeg'
            ];
            $sync_stmt = $pdo->prepare("UPDATE attractions SET image_url = :img WHERE id = :id");
            foreach ($image_maps as $aid => $aimg) {
                $sync_stmt->execute([':img' => $aimg, ':id' => $aid]);
            }
        } catch (Throwable $ignore) {
            // Silently continue if database or table not ready
        }
    }
} catch (PDOException $e) {
    // In production, avoid exposing raw database error
    error_log("Database Connection Error: " . $e->getMessage());
    die("ขออภัย ระบบไม่สามารถเชื่อมต่อฐานข้อมูลได้ในขณะนี้ กรุณาตรวจสอบการเปิดใช้งาน MySQL ใน XAMPP Control Panel");
}
?>

