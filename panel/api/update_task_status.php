<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید']);
    exit;
}

if (!hasRole('designer')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'دسترسی غیرمجاز']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد غیرمجاز']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$taskId = isset($input['task_id']) ? intval($input['task_id']) : 0;
$newStatus = isset($input['status']) ? $input['status'] : '';

if ($taskId <= 0) {
    echo json_encode(['success' => false, 'message' => 'شناسه تسک معتبر نیست']);
    exit;
}

$allowedStatuses = ['todo', 'in_progress', 'done'];
if (!in_array($newStatus, $allowedStatuses)) {
    echo json_encode(['success' => false, 'message' => 'وضعیت معتبر نیست']);
    exit;
}

try {
    $db = getPanelDB();
    $userId = getCurrentUserId();

    $stmt = $db->prepare("SELECT id FROM tasks WHERE id = ? AND designer_id = ?");
    $stmt->execute([$taskId, $userId]);
    $task = $stmt->fetch();
    
    if (!$task) {
        echo json_encode(['success' => false, 'message' => 'تسک یافت نشد یا دسترسی ندارید']);
        exit;
    }

    $stmt = $db->prepare("UPDATE tasks SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$newStatus, $taskId]);
    
    echo json_encode([
        'success' => true,
        'message' => 'وضعیت تسک با موفقیت به‌روزرسانی شد',
        'status' => $newStatus
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'خطا در به‌روزرسانی: ' . $e->getMessage()]);
}

?>

