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
$title = isset($input['title']) ? sanitizeInput($input['title']) : '';
$description = isset($input['description']) ? sanitizeInput($input['description']) : '';
$status = isset($input['status']) ? $input['status'] : 'todo';

if (empty($title)) {
    echo json_encode(['success' => false, 'message' => 'عنوان تسک الزامی است']);
    exit;
}

$allowedStatuses = ['todo', 'in_progress', 'done'];
if (!in_array($status, $allowedStatuses)) {
    $status = 'todo';
}

try {
    $db = getPanelDB();
    $userId = getCurrentUserId();

    $stmt = $db->prepare("INSERT INTO tasks (designer_id, title, description, status, time_logged, created_at, updated_at) 
                          VALUES (?, ?, ?, ?, 0, NOW(), NOW())");
    $stmt->execute([$userId, $title, $description, $status]);
    
    $taskId = $db->lastInsertId();
    
    echo json_encode([
        'success' => true,
        'message' => 'تسک با موفقیت ایجاد شد',
        'task_id' => $taskId,
        'task' => [
            'id' => $taskId,
            'title' => $title,
            'description' => $description,
            'status' => $status
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'خطا در ایجاد تسک: ' . $e->getMessage()]);
}

?>

