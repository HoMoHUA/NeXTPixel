<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

requireLogin();

if (!hasRole('seller')) {
    echo json_encode(['success' => false, 'message' => 'دسترسی غیرمجاز']);
    exit;
}

$db = getPanelDB();
$userId = getCurrentUserId();


$months = [];
$sales = [];
$income = [];

for ($i = 5; $i >= 0; $i--) {
    $date = date('Y-m', strtotime("-$i months"));
    $months[] = date('F Y', strtotime("-$i months"));
    
    
    try {
        $stmt = $db->prepare("SELECT SUM(sales_amount) as total_sales 
                              FROM seller_reports 
                              WHERE user_id = ? 
                              AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                              AND sales_amount > 0 
                              AND (status = 'approved' OR status IS NULL)");
        $stmt->execute([$userId, $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSales = floatval($result['total_sales'] ?? 0);
    } catch (PDOException $e) {
        
        error_log("Status column might not exist: " . $e->getMessage());
        $stmt = $db->prepare("SELECT SUM(sales_amount) as total_sales 
                              FROM seller_reports 
                              WHERE user_id = ? 
                              AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                              AND sales_amount > 0");
        $stmt->execute([$userId, $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSales = floatval($result['total_sales'] ?? 0);
    }
    
    
    $salary = calculateSalary($totalSales);
    
    $sales[] = $totalSales;
    $income[] = $salary;
}

echo json_encode([
    'success' => true,
    'months' => $months,
    'sales' => $sales,
    'income' => $income
], JSON_UNESCAPED_UNICODE);
?>


