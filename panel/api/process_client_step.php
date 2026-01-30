<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید']);
    exit;
}

if (!hasRole('customer') && !hasRole('client')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'دسترسی غیرمجاز']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد غیرمجاز']);
    exit;
}

$db = getPanelDB();
$userId = getCurrentUserId();
$input = json_decode(file_get_contents('php://input'), true);
$step = isset($input['step']) ? intval($input['step']) : 0;

$stmt = $db->prepare("SELECT * FROM client_onboarding WHERE user_id = ?");
$stmt->execute([$userId]);
$onboarding = $stmt->fetch();

if (!$onboarding) {
    
    $stmt = $db->prepare("INSERT INTO client_onboarding (user_id, step) VALUES (?, 1)");
    $stmt->execute([$userId]);
    $onboardingId = $db->lastInsertId();
} else {
    $onboardingId = $onboarding['id'];
}

$response = ['success' => false, 'message' => ''];

try {
    switch ($step) {
        case 1:

            $stmt = $db->prepare("UPDATE client_onboarding SET step = 2 WHERE id = ?");
            $stmt->execute([$onboardingId]);
            $response = ['success' => true, 'message' => 'مرحله ۱ با موفقیت تکمیل شد', 'next_step' => 2];
            break;

        case 2:
            
            $signature = isset($input['signature']) ? $input['signature'] : null;
            if (!$signature) {
                throw new Exception('لطفا قرارداد را امضا کنید');
            }
            $stmt = $db->prepare("UPDATE client_onboarding SET contract_signature = ?, step = 3 WHERE id = ?");
            $stmt->execute([$signature, $onboardingId]);
            $response = ['success' => true, 'message' => 'امضای شما ثبت شد', 'next_step' => 3];
            break;

        case 3:
            
            $stmt = $db->prepare("UPDATE client_onboarding SET step = 4 WHERE id = ?");
            $stmt->execute([$onboardingId]);
            $response = ['success' => true, 'message' => 'مرحله ۳ با موفقیت تکمیل شد', 'next_step' => 4];
            break;

        case 4:
            
            $advisorId = isset($input['advisor_id']) ? intval($input['advisor_id']) : 0;
            if ($advisorId <= 0) {
                throw new Exception('لطفا یک مشاور انتخاب کنید');
            }

            $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND is_advisor = 1 AND status = 'active'");
            $stmt->execute([$advisorId]);
            if (!$stmt->fetch()) {
                throw new Exception('مشاور انتخاب شده معتبر نیست');
            }
            
            $stmt = $db->prepare("UPDATE client_onboarding SET advisor_id = ?, step = 5 WHERE id = ?");
            $stmt->execute([$advisorId, $onboardingId]);
            $response = ['success' => true, 'message' => 'مشاور با موفقیت انتخاب شد', 'next_step' => 5];
            break;

        case 5:
            
            $paymentMethod = isset($input['payment_method']) ? sanitizeInput($input['payment_method']) : '';
            if (!in_array($paymentMethod, ['cash_check', 'progressive', 'full_cash'])) {
                throw new Exception('روش پرداخت معتبر نیست');
            }
            
            $stmt = $db->prepare("UPDATE client_onboarding SET payment_method = ?, step = 6 WHERE id = ?");
            $stmt->execute([$paymentMethod, $onboardingId]);
            
            $message = 'روش پرداخت ثبت شد';
            if ($paymentMethod === 'full_cash') {
                $message .= ' - تبریک! شما هدیه چت‌بات هوش مصنوعی رایگان دریافت کردید!';
            }
            
            $response = [
                'success' => true, 
                'message' => $message, 
                'next_step' => 6,
                'has_ai_gift' => ($paymentMethod === 'full_cash')
            ];
            break;

        case 6:

            $supportId = generateSupportID();
            
            $paymentStatus = 'completed';
            if (isset($input['payment_method'])) {
                $paymentMethod = sanitizeInput($input['payment_method']);
                if ($paymentMethod === 'cash_check' || $paymentMethod === 'progressive') {
                    $paymentStatus = 'partial';
                }
            }
            
            $stmt = $db->prepare("UPDATE client_onboarding SET support_id = ?, payment_status = ?, step = 7, onboarding_completed = 1 WHERE id = ?");
            $stmt->execute([$supportId, $paymentStatus, $onboardingId]);
            
            $response = [
                'success' => true, 
                'message' => 'پرداخت با موفقیت انجام شد',
                'support_id' => $supportId,
                'next_step' => 7
            ];
            break;

        default:
            throw new Exception('مرحله نامعتبر');
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>

