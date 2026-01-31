<?php
/**
 * API Endpoint for Approving/Rejecting Sales
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

requireLogin();
requireRole('admin');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getPanelDB();
    $saleId = intval($_POST['sale_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $adminId = getCurrentUserId();

    if ($saleId <= 0) {
        $response['message'] = 'شناسه فروش نامعتبر است.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!in_array($action, ['approve', 'reject'])) {
        $response['message'] = 'عملیات نامعتبر است.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        if ($action === 'approve') {
            $stmt = $db->prepare("UPDATE seller_reports 
                                  SET status = 'approved', 
                                      approved_by = ?, 
                                      approved_at = NOW() 
                                  WHERE id = ? AND status = 'pending'");
            $stmt->execute([$adminId, $saleId]);
            
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'فروش با موفقیت تایید شد.';
            } else {
                $response['message'] = 'فروش یافت نشد یا قبلاً تایید/رد شده است.';
            }
        } else {
            $reason = $_POST['reason'] ?? '';
            if (empty($reason)) {
                $response['message'] = 'لطفاً دلیل رد را وارد کنید.';
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                exit;
            }

            $stmt = $db->prepare("UPDATE seller_reports 
                                  SET status = 'rejected', 
                                      approved_by = ?, 
                                      approved_at = NOW(),
                                      rejection_reason = ? 
                                  WHERE id = ? AND status = 'pending'");
            $stmt->execute([$adminId, $reason, $saleId]);
            
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'فروش رد شد.';
            } else {
                $response['message'] = 'فروش یافت نشد یا قبلاً تایید/رد شده است.';
            }
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $response['message'] = 'خطا در بروزرسانی وضعیت فروش.';
    }
} else {
    $response['message'] = 'درخواست نامعتبر.';
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>

