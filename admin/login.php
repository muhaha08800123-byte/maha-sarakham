<?php
/**
 * Maha Sarakham Travel Guide - Admin Login (admin/login.php)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่านให้ครบถ้วน';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                // Login Success
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_fullname'] = $admin['full_name'];
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header("Location: index.php");
                exit;
            } else {
                $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            }
        } catch (PDOException $e) {
            $error = 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบผู้ดูแล - ท่องเที่ยวสารคาม</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background: linear-gradient(135deg, #3d3d79, #0d1a3f);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(255, 254, 254, 0.25);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background: #fdfbf7;
            padding: 2.2rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .font-prompt {
            font-family: 'Prompt', sans-serif;
        }
        .btn-login {
            background-color: #454b8d;
            border-color: #1f2140;
            color: #fff;
            font-family: 'Prompt', sans-serif;
            padding: 0.7rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: #1c1d39;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container p-3">
    <div class="card card-login mx-auto border-0">
        <div class="login-header">
            <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 65px; height: 65px;">
                <i class="bi bi-shield-lock-fill fs-2"></i>
            </div>
            <h4 class="font-prompt fw-bold mb-1 text-dark">ระบบผู้ดูแลเว็บไซต์</h4>
            <p class="text-muted small mb-0">Maha Sarakham Travel Guide</p>
        </div>

        <div class="p-4 p-sm-5">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small py-2 px-3 rounded-3 mb-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= e($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold font-prompt text-secondary">ชื่อผู้ใช้งาน (Username)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="admin" required autofocus value="<?= e($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold font-prompt text-secondary">รหัสผ่าน (Password)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i>เข้าสู่ระบบ
                </button>

                <div class="text-center">
                    <a href="../index.php" class="text-decoration-none small text-muted">
                        <i class="bi bi-arrow-left me-1"></i>กลับสู่หน้าเว็บไซต์
                    </a>
                </div>
            </form>

            <div class="mt-4 pt-3 border-top text-center text-muted small">
                <span>บัญชีเริ่มต้น: <code>admin</code> / <code>Password@1234</code></span>
            </div>
        </div>
    </div>
</div>

</body>
</html>

