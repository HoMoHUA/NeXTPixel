<?php
/**
 * Redirect to Main Login Page
 * هدایت به صفحه لاگین اصلی
 */

// اگر کاربر قبلا لاگین کرده، به پنل مناسب هدایت شود
session_start();
if (isset($_SESSION['user_id'])) {
    // دریافت نقش کاربر
    $role = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
    
    // هدایت به پنل مناسب
    switch ($role) {
        case 'customer':
        case 'client':
            header('Location: /panel/client/index.php');
            break;
        case 'seller':
            header('Location: /panel/seller/dashboard.php');
            break;
        case 'designer':
            header('Location: /panel/designer/index.php');
            break;
        case 'admin':
            header('Location: /panel/index.php');
            break;
        default:
            header('Location: /panel/index.php');
            break;
    }
    exit;
}

// هدایت به صفحه لاگین اصلی
header('Location: /login.php');
exit;

?>
