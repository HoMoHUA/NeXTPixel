<?php

$pageTitle = 'گزارش ماهانه - NextPixel';
$currentPage = 'seller-monthly';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (!hasRole('seller')) {
    header('Location: /panel/index.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$currentUser = getCurrentUser();
$db = getPanelDB();
$userId = getCurrentUserId();

$selectedMonth = $_GET['month'] ?? date('Y-m');
$selectedYear = date('Y', strtotime($selectedMonth . '-01'));
$selectedMonthNum = date('m', strtotime($selectedMonth . '-01'));

try {
    $stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_reports,
            SUM(CASE WHEN sales_amount > 0 THEN 1 ELSE 0 END) as sales_count,
            SUM(CASE WHEN (status = 'approved' OR status IS NULL) AND sales_amount > 0 THEN sales_amount ELSE 0 END) as total_sales,
            SUM(CASE WHEN status = 'pending' AND sales_amount > 0 THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN status = 'rejected' AND sales_amount > 0 THEN 1 ELSE 0 END) as rejected_count
        FROM seller_reports 
        WHERE user_id = ? 
        AND DATE_FORMAT(report_date, '%Y-%m') = ?
    ");
    $stmt->execute([$userId, $selectedMonth]);
    $monthStats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
    error_log("Status column might not exist: " . $e->getMessage());
    $stmt = $db->prepare("
        SELECT 
            COUNT(*) as total_reports,
            SUM(CASE WHEN sales_amount > 0 THEN 1 ELSE 0 END) as sales_count,
            SUM(CASE WHEN sales_amount > 0 THEN sales_amount ELSE 0 END) as total_sales,
            0 as pending_count,
            0 as rejected_count
        FROM seller_reports 
        WHERE user_id = ? 
        AND DATE_FORMAT(report_date, '%Y-%m') = ?
    ");
    $stmt->execute([$userId, $selectedMonth]);
    $monthStats = $stmt->fetch(PDO::FETCH_ASSOC);
}

$totalSales = floatval($monthStats['total_sales'] ?? 0);
$calculatedSalary = calculateSalary($totalSales);

$stmt = $db->prepare("
    SELECT * 
    FROM seller_reports 
    WHERE user_id = ? 
    AND DATE_FORMAT(report_date, '%Y-%m') = ?
    ORDER BY report_date DESC
");
$stmt->execute([$userId, $selectedMonth]);
$monthReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

$chartMonths = [];
$chartSales = [];
$chartIncome = [];

for ($i = 11; $i >= 0; $i--) {
    $date = date('Y-m', strtotime("-$i months"));
    $monthName = date('F Y', strtotime("-$i months"));
    $chartMonths[] = $monthName;
    
    try {
        $stmt = $db->prepare("
            SELECT SUM(sales_amount) as total_sales 
            FROM seller_reports 
            WHERE user_id = ? 
            AND DATE_FORMAT(report_date, '%Y-%m') = ? 
            AND sales_amount > 0 
            AND (status = 'approved' OR status IS NULL)
        ");
        $stmt->execute([$userId, $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $monthSales = floatval($result['total_sales'] ?? 0);
    } catch (PDOException $e) {
        
        $stmt = $db->prepare("
            SELECT SUM(sales_amount) as total_sales 
            FROM seller_reports 
            WHERE user_id = ? 
            AND DATE_FORMAT(report_date, '%Y-%m') = ? 
            AND sales_amount > 0
        ");
        $stmt->execute([$userId, $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $monthSales = floatval($result['total_sales'] ?? 0);
    }
    $monthSalary = calculateSalary($monthSales);
    
    $chartSales[] = $monthSales;
    $chartIncome[] = $monthSalary;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">گزارش ماهانه</span>
                </h2>
                <p class="geex-content__header__subtitle">مشاهده و تحلیل عملکرد ماهانه</p>
            </div>
            <div class="geex-content__header__action">
                <form method="GET" style="display: inline-block;">
                    <input type="month" name="month" value="<?php echo htmlspecialchars($selectedMonth); ?>" 
                           onchange="this.form.submit()"
                           style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(59, 130, 246, 0.3); 
                                  color: white; padding: 10px; border-radius: 8px;">
                </form>
            </div>
        </div>

        <div class="geex-content__wrapper">
            
            <div class="geex-content__section mb-40">
                <div class="geex-content__feature">
                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">فروش تایید شده</p>
                            <h4 class="geex-content__feature__card__title"><?php echo formatNumber($totalSales); ?> تومان</h4>
                            <span class="geex-content__feature__card__badge">ماه <?php echo date('F Y', strtotime($selectedMonth . '-01')); ?></span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <i class="uil uil-chart-line" style="font-size: 48px; color: #3b82f6;"></i>
                        </div>
                    </div>

                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(16, 185, 129, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">حقوق محاسبه شده</p>
                            <h4 class="geex-content__feature__card__title"><?php echo formatNumber($calculatedSalary); ?> تومان</h4>
                            <span class="geex-content__feature__card__badge success-color">بر اساس فروش</span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <i class="uil uil-dollar-sign" style="font-size: 48px; color: #10b981;"></i>
                        </div>
                    </div>

                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(245, 158, 11, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">تعداد فروش</p>
                            <h4 class="geex-content__feature__card__title"><?php echo $monthStats['sales_count']; ?> مورد</h4>
                            <span class="geex-content__feature__card__badge"><?php echo $monthStats['total_reports']; ?> گزارش</span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <i class="uil uil-shopping-cart" style="font-size: 48px; color: #f59e0b;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__section__header">
                    <h4 class="geex-content__section__header__title">نمودار فروش و درآمد 12 ماه گذشته</h4>
                    <p class="geex-content__section__header__subtitle">مقایسه عملکرد در یک سال گذشته</p>
                </div>
                <div class="geex-content__section__content">
                    <div id="monthly-chart" style="min-height: 400px;"></div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__section__header">
                    <h4 class="geex-content__section__header__title">لیست گزارش‌های ماه</h4>
                    <p class="geex-content__section__header__subtitle">تمام گزارش‌های ثبت شده در این ماه</p>
                </div>
                <div class="geex-content__section__content">
                    <?php if (empty($monthReports)): ?>
                        <div class="geex-content__empty">
                            <i class="uil uil-file-alt" style="font-size: 64px; color: var(--np-text-muted);"></i>
                            <p>هیچ گزارشی برای این ماه ثبت نشده است</p>
                        </div>
                    <?php else: ?>
                        <div class="geex-table-wrapper">
                            <table class="geex-table">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>مبلغ فروش</th>
                                        <th>حقوق</th>
                                        <th>وضعیت</th>
                                        <th>توضیحات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($monthReports as $report): ?>
                                        <?php 
                                        $reportStatus = $report['status'] ?? null;
                                        $reportSalary = ($report['sales_amount'] > 0 && ($reportStatus == 'approved' || $reportStatus === null)) 
                                            ? calculateSalary($report['sales_amount']) 
                                            : 0;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                $date = new DateTime($report['report_date']);
                                                echo $date->format('Y/m/d');
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($report['sales_amount'] > 0): ?>
                                                    <strong style="color: #3b82f6;"><?php echo formatNumber($report['sales_amount']); ?> تومان</strong>
                                                <?php else: ?>
                                                    <span style="color: #94a3b8;">بدون فروش</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($reportSalary > 0): ?>
                                                    <strong style="color: #10b981;"><?php echo formatNumber($reportSalary); ?> تومان</strong>
                                                <?php else: ?>
                                                    <span style="color: #94a3b8;">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($report['sales_amount'] > 0): ?>
                                                    <?php 
                                                    $reportStatus = $report['status'] ?? null;
                                                    if ($reportStatus == 'approved'): ?>
                                                        <span class="geex-badge geex-badge--success">تایید شده</span>
                                                    <?php elseif ($reportStatus == 'rejected'): ?>
                                                        <span class="geex-badge geex-badge--danger">رد شده</span>
                                                    <?php elseif ($reportStatus == 'pending'): ?>
                                                        <span class="geex-badge geex-badge--warning">در انتظار</span>
                                                    <?php else: ?>
                                                        <span class="geex-badge" style="background: rgba(100, 116, 139, 0.2); color: #64748b;">ثبت شده</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="geex-badge" style="background: rgba(100, 116, 139, 0.2); color: #64748b;">بدون فروش</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($report['report_text']): ?>
                                                    <span style="color: #94a3b8; font-size: 12px;">
                                                        <?php echo htmlspecialchars(substr($report['report_text'], 0, 50)); ?>...
                                                    </span>
                                                <?php else: ?>
                                                    <span style="color: #64748b;">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof ApexCharts !== 'undefined') {
        const chartData = {
            months: <?php echo json_encode($chartMonths, JSON_UNESCAPED_UNICODE); ?>,
            sales: <?php echo json_encode($chartSales); ?>,
            income: <?php echo json_encode($chartIncome); ?>
        };

        var options = {
            series: [
                {
                    name: 'فروش',
                    data: chartData.sales
                },
                {
                    name: 'درآمد',
                    data: chartData.income
                }
            ],
            chart: {
                type: 'line',
                height: 400,
                toolbar: { show: false },
                fontFamily: 'Vazirmatn, sans-serif'
            },
            colors: ['#3b82f6', '#10b981'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: { 
                categories: chartData.months,
                labels: { 
                    style: { colors: '#94a3b8' },
                    rotate: -45,
                    rotateAlways: true
                }
            },
            yaxis: {
                labels: { 
                    style: { colors: '#94a3b8' },
                    formatter: function(val) {
                        if (val >= 1000000) {
                            return new Intl.NumberFormat('fa-IR').format(Math.round(val / 1000000)) + 'M';
                        }
                        return new Intl.NumberFormat('fa-IR').format(Math.round(val / 1000)) + 'K';
                    }
                }
            },
            legend: {
                labels: { colors: '#cbd5e1' },
                position: 'top'
            },
            grid: {
                borderColor: 'rgba(59, 130, 246, 0.1)'
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return new Intl.NumberFormat('fa-IR').format(Math.round(val)) + ' تومان';
                    }
                }
            }
        };
        
        var chart = new ApexCharts(document.querySelector("#monthly-chart"), options);
        chart.render();
    }
});
</script>

<style>
.geex-content__empty {
    text-align: center;
    padding: 60px 20px;
}

.geex-content__empty p {
    margin: 20px 0;
    color: var(--np-text-muted);
    font-size: 16px;
}

.geex-table-wrapper {
    overflow-x: auto;
}

.geex-table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(15, 23, 42, 0.6);
    border-radius: 8px;
    overflow: hidden;
}

.geex-table thead {
    background: rgba(59, 130, 246, 0.1);
}

.geex-table th {
    padding: 16px;
    text-align: right;
    font-weight: 600;
    color: var(--np-text-primary);
    border-bottom: 1px solid rgba(59, 130, 246, 0.2);
}

.geex-table td {
    padding: 16px;
    text-align: right;
    color: var(--np-text-secondary);
    border-bottom: 1px solid rgba(59, 130, 246, 0.1);
}

.geex-table tbody tr:hover {
    background: rgba(59, 130, 246, 0.05);
}

.geex-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.geex-badge--success {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.geex-badge--danger {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.geex-badge--warning {
    background: rgba(245, 158, 11, 0.2);
    color: #f59e0b;
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
