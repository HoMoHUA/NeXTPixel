<?php
/**
 * Authentication Middleware
 * میدلور احراز هویت برای بررسی نقش کاربر
 */

session_start();

/**
 * Check if user is logged in
 * بررسی لاگین بودن کاربر
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && (isset($_SESSION['role']) || isset($_SESSION['user_type']));
}

/**
 * Check if user has specific role
 * بررسی نقش کاربر
 */
function hasRole($requiredRole) {
    if (!isLoggedIn()) {
        return false;
    }
    
    // بررسی هم user_type و هم role
    $userRole = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
    
    // Mapping برای سازگاری
    if ($requiredRole === 'client' && ($userRole === 'customer' || $userRole === 'client')) {
        return true;
    }
    
    return $userRole === $requiredRole;
}

/**
 * Require login - redirect if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

/**
 * Require specific role - redirect if role doesn't match
 */
function requireRole($requiredRole) {
    requireLogin();
    
    if (!hasRole($requiredRole)) {
        // Redirect to appropriate dashboard based on user's actual role
        $userRole = $_SESSION['role'];
        header("Location: /panel/{$userRole}/index.php");
        exit();
    }
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user role
 */
function getCurrentUserRole() {
    // بررسی هم user_type و هم role برای سازگاری
    return $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
}

/**
 * Get current user data
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? '',
        'display_name' => $_SESSION['display_name'] ?? '',
        'email' => $_SESSION['email'] ?? '',
        'role' => $_SESSION['role'] ?? $_SESSION['user_type'] ?? null
    ];
}

/**
 * Redirect based on user role
 * هدایت کاربر به پنل مناسب بر اساس نقش
 */
function redirectByRole() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
    
    // استفاده از role اگر موجود باشد، در غیر این صورت از user_type
    $role = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
    
    if (!$role) {
        header('Location: /login.php');
        exit();
    }
    
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
        case 'staff':
        default:
            // برای staff که نقش دقیق‌تر ندارند، به پنل اصلی
            header('Location: /panel/index.php');
            break;
    }
    exit();
}

?>

