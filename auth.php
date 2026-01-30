<?php

header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/db-connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد مجاز نیست']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action !== 'login') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'عمل درخواستی نامعتبر است']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$user_type = trim($_POST['user_type'] ?? ''); 

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

    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'نام کاربری یا رمز عبور اشتباه است'
        ]);
        exit;
    }

    $dbUserType = $user['user_type'];

    $actualRole = (!empty($user['role'])) ? $user['role'] : $dbUserType;

    if ($dbUserType === 'admin' && empty($user['role'])) {
        $actualRole = 'admin';
    }

    if ($user_type === 'customer' && $dbUserType !== 'customer') {
        echo json_encode([
            'success' => false, 
            'message' => 'نوع کاربر انتخاب شده با حساب کاربری شما تطابق ندارد'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($user_type === 'staff') {

        if (!in_array($dbUserType, ['staff', 'admin'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'نوع کاربر انتخاب شده با حساب کاربری شما تطابق ندارد'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['display_name'] = $user['display_name'] ?? $user['username'];
    $_SESSION['user_type'] = $dbUserType;
    $_SESSION['role'] = $actualRole; 

    $redirectPath = '/panel/';

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
            
            $redirectPath = '/panel/index.php';
            break;
    }

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
