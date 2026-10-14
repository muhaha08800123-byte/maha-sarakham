<?php
/**
 * Maha Sarakham Travel Guide - Shared Header
 */
if (!isset($page_title)) {
    $page_title = 'ท่องเที่ยวสารคาม - Maha Sarakham Travel Guide';
}
if (!isset($current_page)) {
    $current_page = 'home';
}
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-geo-alt-fill text-danger fs-4"></i>
            <span>ท่องเที่ยวสารคาม</span>
            <span class="brand-badge d-none d-sm-inline">ตักสิลานคร</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'home' ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-house me-1"></i>หน้าแรก
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'attractions' ? 'active' : '' ?>" href="attractions.php">
                        <i class="bi bi-compass me-1"></i>แหล่งท่องเที่ยว
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'categories' ? 'active' : '' ?>" href="categories.php">
                        <i class="bi bi-grid me-1"></i>หมวดหมู่
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'routes' ? 'active' : '' ?>" href="routes.php">
                        <i class="bi bi-signpost-2 me-1"></i>เส้นทางท่องเที่ยว
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'about' ? 'active' : '' ?>" href="about.php">
                        <i class="bi bi-info-circle me-1"></i>เกี่ยวกับเรา
                    </a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-admin-nav d-inline-flex align-items-center" href="admin/login.php">
                        <i class="bi bi-shield-lock me-1"></i>ระบบผู้ดูแล
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
