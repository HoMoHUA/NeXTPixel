<?php
/**
 * API Endpoint: Calculate Seller Salary
 * محاسبه حقوق فروشنده
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// بررسی لاگین بودن
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید']);
    exit;
}

// فقط فروشندگان می‌توانند استفاده کنند
if (!hasRole('seller')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'دسترسی غیرمجاز']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'متد غیرمجاز']);
    exit;
}

// دریافت مبلغ فروش
$input = json_decode(file_get_contents('php://input'), true);
$salesAmount = isset($input['totalSales']) ? floatval($input['totalSales']) : (isset($input['sales_amount']) ? floatval($input['sales_amount']) : 0);

if ($salesAmount < 0) {
    echo json_encode([
        'success' => false,
        'message' => 'مبلغ فروش باید عدد مثبت باشد'
    ]);
    exit;
}

// محاسبه حقوق
$salary = calculateSalary($salesAmount);

echo json_encode([
    'success' => true,
    'sales_amount' => $salesAmount,
    'salary' => $salary,
    'formatted_salary' => formatNumber($salary),
    'formatted_sales' => formatNumber($salesAmount)
]);

?>

