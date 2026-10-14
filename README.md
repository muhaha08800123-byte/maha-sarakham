# Maha Sarakham Travel Guide (ระบบแนะนำสถานที่ท่องเที่ยวมหาสารคาม)

เว็บไซต์รวบรวมข้อมูลและประชาสัมพันธ์แหล่งท่องเที่ยวสำคัญ 15 แห่ง ในจังหวัดมหาสารคาม พร้อมระบบจัดการหลังบ้าน (Admin CMS)

## ✨ คุณสมบัติเด่น (Features)
- 🏛️ รวบรวมข้อมูลสถานที่ท่องเที่ยวสำคัญ 15 แห่ง แบ่งออกเป็น 5 หมวดหมู่
- 📍 พิกัด Google Maps พร้อมแผนที่นำทางไปยังสถานที่จริง
- 🕒 ข้อมูลเวลาเปิด-ปิดทำการ วันให้บริการ และอัตราค่าเข้าชม
- 🗺️ แนะนำเส้นทางท่องเที่ยว (1 Day Trip สายบุญ & สายธรรมชาติ)
- 🛡️ ระบบจัดการหลังบ้าน (Admin CRUD) สำหรับเพิ่ม แก้ไข ลบสถานที่ท่องเที่ยว พร้อมระบบความปลอดภัย CSRF Token และ Password Hash

## 🛠️ เทคโนโลยีที่ใช้ (Tech Stack)
- **Backend:** PHP 8.x (PDO MySQL)
- **Database:** MySQL / MariaDB (utf8mb4)
- **Frontend:** HTML5, CSS3, JavaScript (Bootstrap 5.3, Bootstrap Icons)
- **Architecture:** Responsive Web Design

## 🚀 วิธีการติดตั้งและใช้งาน (Installation)
1. ติดตั้งโปรแกรม XAMPP หรือ Web Server (Apache + MySQL + PHP)
2. นำโฟลเดอร์โปรเจกต์ไปวางไว้ในโฟลเดอร์ `htdocs/`
3. เปิด MySQL และนำเข้าไฟล์ฐานข้อมูล `database.sql` ผ่าน phpMyAdmin
4. เข้าใช้งานเว็บไซต์ผ่านเบราว์เซอร์: `http://localhost/ท่องเที่ยวสารคราม/`
5. เข้าสู่ระบบหลังบ้าน: `http://localhost/ท่องเที่ยวสารคราม/admin/login.php`
   - **Username:** `admin`
   - **Password:** `Password@1234`

