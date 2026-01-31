<?php
/**
 * Header Include File
 * فایل شامل هدر مشترک
 */
require_once __DIR__ . '/auth.php';
$currentUser = getCurrentUser();
$userRole = getCurrentUserRole();
?>
<!doctype html>
<html lang="fa" dir="rtl" data-theme="dark" data-nav="side">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'پنل مدیریت NextPixel'; ?></title>

    <!-- NextPixel Theme CSS -->
    <link rel="stylesheet" href="/panel/assets/css/nextpixel-theme.css?v=1.1.0">
    
    <!-- Geex Template CSS -->
    <link rel="stylesheet" href="/panel/assets/vendor/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/panel/assets/css/style.css">
    
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css">
    
    <script>
        // Render localStorage JS:
        if (localStorage.theme) document.documentElement.setAttribute("data-theme", localStorage.theme);
        if (localStorage.layout) document.documentElement.setAttribute("data-nav", localStorage.navbar);
    </script>
</head>

<body class="geex-داشبورد">

<?php require_once __DIR__ . '/mobile-menu.php'; ?>

