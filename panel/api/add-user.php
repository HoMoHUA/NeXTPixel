<?php
/**
 * API Endpoint برای افزودن همکار جدید
 */

header('Content-Type: application/json; charset=utf-8');

// بارگذاری auth.php که session را مدیریت می‌کند
require_once __DIR__ . '/../includes/auth.php';

// بررسی لاگین بودن
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید'], JSON_UNESCAPED_UNICODE);
    exit;
}

// بررسی نقش admin
if (!hasRole('admin')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'شما دسترسی به این بخش را ندارید'], JSON_UNESCAPED_UNICODE);
    exit;
}

// فقط متد POST مجاز است
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد مجاز نیست']);
    exit;
}

// دریافت داده‌های JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'داده‌های ارسالی نامعتبر است']);
    exit;
}

// بارگذاری فایل‌های مورد نیاز
require_once __DIR__ . '/../../config/db-config.php';
require_once __DIR__ . '/../../config/db-connection.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    $db = getDB();
    
    // دریافت و اعتبارسنجی داده‌ها
    $username = trim($data['username'] ?? '');
    $email = trim($data['email'] ?? '');
    $displayName = trim($data['display_name'] ?? '');
    $password = $data['password'] ?? '';
    $userType = $data['user_type'] ?? '';
    $role = !empty($data['role']) ? trim($data['role']) : null;
    $status = $data['status'] ?? 'active';
    
    // اعتبارسنجی
    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'نام کاربری الزامی است'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'ایمیل معتبر وارد کنید'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if (empty($password) || strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'رمز عبور باید حداقل ۶ کاراکتر باشد'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if (!in_array($userType, ['staff', 'customer'])) {
        echo json_encode(['success' => false, 'message' => 'نوع کاربر نامعتبر است'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if (!in_array($status, ['active', 'inactive'])) {
        $status = 'active';
    }
    
    // بررسی تکراری نبودن نام کاربری
    $stmt = $db->prepare("SELECT id FROM " . TABLE_USERS . " WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'این نام کاربری قبلاً استفاده شده است'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // بررسی تکراری نبودن ایمیل
    $stmt = $db->prepare("SELECT id FROM " . TABLE_USERS . " WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'این ایمیل قبلاً استفاده شده است'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // هش کردن رمز عبور
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // اگر display_name خالی است، از username استفاده کن
    if (empty($displayName)) {
        $displayName = $username;
    }
    
    // اگر role خالی است و user_type = staff است، role را staff قرار بده
    if (empty($role) && $userType === 'staff') {
        $role = 'staff';
    }
    
    // درج کاربر جدید
    $stmt = $db->prepare("
        INSERT INTO " . TABLE_USERS . " 
        (username, email, password, display_name, user_type, role, status, created_at, updated_at) 
        VALUES 
        (:username, :email, :password, :display_name, :user_type, :role, :status, NOW(), NOW())
    ");
    
    $result = $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':display_name' => $displayName,
        ':user_type' => $userType,
        ':role' => $role,
        ':status' => $status
    ]);
    
    if ($result) {
        $userId = $db->lastInsertId();
        
        // لاگ عملیات
        error_log("New user created by admin: {$username} (ID: {$userId}, Type: {$userType}, Role: {$role})");
        
        echo json_encode([
            'success' => true, 
            'message' => 'همکار با موفقیت افزوده شد',
            'user_id' => $userId
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['success' => false, 'message' => 'خطا در افزودن همکار'], JSON_UNESCAPED_UNICODE);
    }
    
} catch (PDOException $e) {
    error_log("Add User Error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'خطا در ارتباط با دیتابیس: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    error_log("Add User General Error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'خطا: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

?>

