<?php
/**
 * Authentication Handler
 * مدیریت ورود کاربران و هدایت به پنل‌های مربوطه
 */

header('Content-Type: application/json');

// شروع session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// بارگذاری فایل‌های مورد نیاز
require_once __DIR__ . '/config/db-connection.php';

// فقط متد POST مجاز است
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد مجاز نیست']);
    exit;
}

// دریافت action
$action = $_POST['action'] ?? '';

// فقط action login مجاز است (ثبت نام حذف شده)
if ($action !== 'login') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'عمل درخواستی نامعتبر است']);
    exit;
}

// دریافت اطلاعات ورود
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$user_type = trim($_POST['user_type'] ?? ''); // 'staff' یا 'customer'

// اعتبارسنجی ورودی‌ها
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'نام کاربری و رمز عبور الزامی است']);
    exit;
}

if (empty($user_type) || !in_array($user_type, ['staff', 'customer'])) {
    echo json_encode(['success' => false, 'message' => 'نوع کاربر نامعتبر است']);
    exit;
}

try {
    $db = getDB();
    
    // جستجوی کاربر با نام کاربری
    // نقش دقیق (seller, designer, admin) توسط HoMo در ستون role تعیین شده است
    $stmt = $db->prepare("
        SELECT id, username, email, password, display_name, user_type, status, role
        FROM " . TABLE_USERS . " 
        WHERE username = :username 
        AND status = 'active'
        LIMIT 1
    ");
    
    $stmt->execute([
        ':username' => $username
    ]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode([
            'success' => false, 
            'message' => 'نام کاربری یا رمز عبور اشتباه است'
        ]);
        exit;
    }
    
    // بررسی رمز عبور
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'نام کاربری یا رمز عبور اشتباه است'
        ]);
        exit;
    }
    
    // بررسی تطابق نوع کاربر انتخاب شده با نوع کاربر در دیتابیس
    $dbUserType = $user['user_type'];
    
    // تعیین نقش دقیق: اگر ستون role وجود دارد و خالی نیست، از آن استفاده می‌کنیم
    // در غیر این صورت از user_type استفاده می‌کنیم
    $actualRole = (!empty($user['role'])) ? $user['role'] : $dbUserType;
    
    // اگر user_type = 'admin' است، role را هم 'admin' تنظیم می‌کنیم (برای سازگاری)
    if ($dbUserType === 'admin' && empty($user['role'])) {
        $actualRole = 'admin';
    }
    
    // اگر کاربر customer انتخاب کرده، باید در دیتابیس هم customer باشد
    if ($user_type === 'customer' && $dbUserType !== 'customer') {
        echo json_encode([
            'success' => false, 
            'message' => 'نوع کاربر انتخاب شده با حساب کاربری شما تطابق ندارد'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // اگر کاربر staff انتخاب کرده، باید در دیتابیس staff یا admin باشد
    // مدیر اصلی (admin) می‌تواند از تب "ورود همکاران" وارد شود
    // نقش دقیق (seller, designer, admin) در ستون role ذخیره می‌شود
    if ($user_type === 'staff') {
        // بررسی نوع کاربر در دیتابیس
        // admin می‌تواند از تب staff وارد شود
        if (!in_array($dbUserType, ['staff', 'admin'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'نوع کاربر انتخاب شده با حساب کاربری شما تطابق ندارد'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
    
    // ایجاد session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['display_name'] = $user['display_name'] ?? $user['username'];
    $_SESSION['user_type'] = $dbUserType;
    $_SESSION['role'] = $actualRole; // نقش دقیق برای استفاده در پنل
    
    // تعیین مسیر هدایت بر اساس نقش دقیق کاربر
    $redirectPath = '/panel/';
    
    // نقش دقیق کاربر که توسط HoMo تعیین شده است
    switch ($actualRole) {
        case 'customer':
        case 'client':
            $redirectPath = '/panel/client/index.php';
            break;
        case 'seller':
            $redirectPath = '/panel/seller/dashboard.php';
            break;
        case 'designer':
            $redirectPath = '/panel/designer/index.php';
            break;
        case 'admin':
            $redirectPath = '/panel/index.php';
            break;
        case 'staff':
        default:
            // برای staff که نقش دقیق‌تر ندارند، به پنل اصلی
            $redirectPath = '/panel/index.php';
            break;
    }
    
    // لاگ ورود موفق
    error_log("User login successful: {$username} (user_type: {$dbUserType}, role: {$actualRole}) -> {$redirectPath}");
    
    echo json_encode([
        'success' => true, 
        'message' => 'ورود با موفقیت انجام شد. در حال هدایت به پنل...',
        'user_type' => $dbUserType,
        'role' => $actualRole,
        'redirect' => $redirectPath
    ], JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    error_log("Login Error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'خطا در ارتباط با سرور. لطفا دوباره تلاش کنید.'
    ]);
}

?>
