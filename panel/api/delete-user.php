<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

requireLogin();
requireRole('admin');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getPanelDB();
    $userId = intval($_POST['id'] ?? 0);

    if ($userId <= 0) {
        $response['message'] = 'شناسه کاربر نامعتبر است.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    
    if ($userId == getCurrentUserId()) {
        $response['message'] = 'شما نمی‌توانید حساب کاربری خود را حذف کنید.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $stmt = $db->prepare("DELETE FROM " . TABLE_USERS . " WHERE id = :id");
        $stmt->execute([':id' => $userId]);

        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'کاربر با موفقیت حذف شد.';
        } else {
            $response['message'] = 'کاربر یافت نشد.';
        }
    } catch (PDOException $e) {
        error_log("Database error deleting user: " . $e->getMessage());
        $response['message'] = 'خطا در حذف کاربر: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'درخواست نامعتبر.';
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>


