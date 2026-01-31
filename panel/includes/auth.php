<?php


session_start();


function isLoggedIn() {
    return isset($_SESSION['user_id']) && (isset($_SESSION['role']) || isset($_SESSION['user_type']));
}


function hasRole($requiredRole) {
    if (!isLoggedIn()) {
        return false;
    }
    
    
    $userRole = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
    
    
    if ($requiredRole === 'client' && ($userRole === 'customer' || $userRole === 'client')) {
        return true;
    }
    
    return $userRole === $requiredRole;
}


function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}


function requireRole($requiredRole) {
    requireLogin();
    
    if (!hasRole($requiredRole)) {
        
        $userRole = $_SESSION['role'];
        header("Location: /panel/{$userRole}/index.php");
        exit();
    }
}


function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}


function getCurrentUserRole() {
    
    return $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
}


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


function redirectByRole() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
    
    
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
            
            header('Location: /panel/index.php');
            break;
    }
    exit();
}

?>


