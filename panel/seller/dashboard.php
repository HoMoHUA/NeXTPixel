<?php

$pageTitle = 'داشبورد فروش - NextPixel';
$currentPage = 'seller-dashboard';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (!hasRole('seller')) {
    header('Location: /panel/index.php');
    exit();
}

$currentUser = getCurrentUser();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$db = getPanelDB();
$userId = getCurrentUserId();

$currentMonth = date('Y-m');
try {
    $stmt = $db->prepare("SELECT SUM(sales_amount) as total_sales 
                          FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND sales_amount > 0 
                          AND (status = 'approved' OR status IS NULL)");
    $stmt->execute([$userId, $currentMonth]);
    $monthSales = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalSales = floatval($monthSales['total_sales'] ?? 0);
} catch (PDOException $e) {
    
    error_log("Status column might not exist: " . $e->getMessage());
    $stmt = $db->prepare("SELECT SUM(sales_amount) as total_sales 
                          FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND sales_amount > 0");
    $stmt->execute([$userId, $currentMonth]);
    $monthSales = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalSales = floatval($monthSales['total_sales'] ?? 0);
}

$salary = calculateSalary($totalSales);

$today = date('Y-m-d');
$stmt = $db->prepare("SELECT * FROM seller_reports WHERE user_id = ? AND report_date = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$userId, $today]);
$todayReport = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT COUNT(*) as count FROM seller_reports 
                      WHERE user_id = ? AND DATE_FORMAT(report_date, '%Y-%m') = ?");
$stmt->execute([$userId, $currentMonth]);
$reportCount = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND (status = 'approved' OR status IS NULL) 
                          AND sales_amount > 0");
    $stmt->execute([$userId, $currentMonth]);
    $approvedSalesCount = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND (status = 'approved' OR status IS NULL) 
                          AND sales_amount > 0 
                          ORDER BY report_date DESC 
                          LIMIT 10");
    $stmt->execute([$userId, $currentMonth]);
    $approvedSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
    error_log("Status column might not exist: " . $e->getMessage());
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND sales_amount > 0");
    $stmt->execute([$userId, $currentMonth]);
    $approvedSalesCount = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM seller_reports 
                          WHERE user_id = ? 
                          AND DATE_FORMAT(report_date, '%Y-%m') = ? 
                          AND sales_amount > 0 
                          ORDER BY report_date DESC 
                          LIMIT 10");
    $stmt->execute([$userId, $currentMonth]);
    $approvedSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">داشبورد فروش</span>
                </h2>
                <p class="geex-content__header__subtitle">خوش آمدید <?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?></p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            
            <div class="geex-content__section mb-40">
                <div class="geex-content__feature">
                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">فروش تایید شده ماه جاری</p>
                            <h4 class="geex-content__feature__card__title"><?php echo formatNumber($totalSales); ?> تومان</h4>
                            <span class="geex-content__feature__card__badge" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6);">ماه <?php echo date('m/Y'); ?></span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <img src="/panel/assets/img/feature/feature-2.svg" alt="feature" />
                        </div>
                    </div>

                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">حقوق محاسبه شده</p>
                            <h4 class="geex-content__feature__card__title"><?php echo formatNumber($salary); ?> تومان</h4>
                            <span class="geex-content__feature__card__badge success-color">بر اساس فروش تایید شده</span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <img src="/panel/assets/img/feature/feature-3.svg" alt="feature" />
                        </div>
                    </div>

                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">فروش‌های تایید شده</p>
                            <h4 class="geex-content__feature__card__title"><?php echo $approvedSalesCount['count']; ?> مورد</h4>
                            <span class="geex-content__feature__card__badge">ماه جاری</span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <img src="/panel/assets/img/feature/feature-1.svg" alt="feature" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__section__header">
                    <h4 class="geex-content__section__header__title">نمودار فروش و درآمد ماهانه</h4>
                    <p class="geex-content__section__header__subtitle">مقایسه فروش و درآمد در 6 ماه گذشته</p>
                </div>
                <div class="geex-content__section__content">
                    <div id="sales-income-chart" style="min-height: 400px;"></div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__form__wrapper">
                    <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                        <h4 style="margin-bottom: 20px; color: #f8fafc;">وضعیت گزارش امروز</h4>
                        <?php if ($todayReport): ?>
                            <div style="background: #1e293b; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <?php 
                                        $status = $todayReport['status'] ?? null;
                                        if ($status == 'approved'): ?>
                                            <p style="color: #10b981; margin: 0; font-weight: bold;">✓ تایید شده</p>
                                        <?php elseif ($status == 'rejected'): ?>
                                            <p style="color: #ef4444; margin: 0; font-weight: bold;">✗ رد شده</p>
                                        <?php elseif ($status == 'pending'): ?>
                                            <p style="color: #f59e0b; margin: 0; font-weight: bold;">⏳ در انتظار تایید</p>
                                        <?php else: ?>
                                            <p style="color: #94a3b8; margin: 0; font-weight: bold;">● ثبت شده</p>
                                        <?php endif; ?>
                                        <p style="color: #94a3b8; font-size: 14px; margin-top: 5px;">
                                            <?php echo date('Y/m/d', strtotime($todayReport['report_date'])); ?>
                                        </p>
                                    </div>
                                    <div style="text-align: left;">
                                        <?php if ($todayReport['sales_amount'] > 0): ?>
                                            <p style="color: #3b82f6; font-size: 18px; font-weight: bold; margin: 0;">
                                                <?php echo formatNumber($todayReport['sales_amount']); ?> تومان
                                            </p>
                                            <?php if ($status == 'approved' || ($status === null && $todayReport['sales_amount'] > 0)): ?>
                                                <p style="color: #10b981; font-size: 12px; margin: 5px 0 0 0;">
                                                    حقوق: <?php echo formatNumber(calculateSalary($todayReport['sales_amount'])); ?> تومان
                                                </p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p style="color: #f59e0b; font-size: 14px; margin: 0;">بدون فروش</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <a href="/panel/seller/report.php" class="geex-btn" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; text-decoration: none; color: white; display: inline-block;">
                                مشاهده گزارش
                            </a>
                        <?php else: ?>
                            <div style="background: #1e293b; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <p style="color: #f59e0b; margin: 0;">⚠ هنوز گزارشی برای امروز ثبت نشده است</p>
                            </div>
                            <a href="/panel/seller/report.php" class="geex-btn" style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 12px 30px; text-decoration: none; color: white; display: inline-block;">
                                ثبت گزارش امروز
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__section__header">
                    <h4 class="geex-content__section__header__title">فروش‌های تایید شده این ماه</h4>
                    <p class="geex-content__section__header__subtitle">لیست فروش‌هایی که توسط مدیر تایید شده‌اند</p>
                </div>
                <div class="geex-content__section__content">
                    <?php if (empty($approvedSales)): ?>
                        <div class="geex-content__empty">
                            <i class="uil uil-chart-line" style="font-size: 64px; color: var(--np-text-muted);"></i>
                            <p>هنوز فروش تایید شده‌ای ثبت نشده است</p>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($approvedSales as $sale): ?>
                                        <?php $saleSalary = calculateSalary($sale['sales_amount']); ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                $date = new DateTime($sale['report_date']);
                                                echo $date->format('Y/m/d');
                                                ?>
                                            </td>
                                            <td>
                                                <strong style="color: #3b82f6;"><?php echo formatNumber($sale['sales_amount']); ?> تومان</strong>
                                            </td>
                                            <td>
                                                <strong style="color: #10b981;"><?php echo formatNumber($saleSalary); ?> تومان</strong>
                                            </td>
                                            <td>
                                                <span class="geex-badge geex-badge--success">تایید شده</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <div class="geex-content__form__wrapper">
                    <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                        <h4 style="margin-bottom: 20px; color: #f8fafc;">محاسبه‌گر حقوق</h4>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="salesInput" style="color: #cbd5e1; margin-bottom: 10px; display: block;">مبلغ فروش (تومان):</label>
                            <input type="number" id="salesInput" class="form-control" placeholder="مبلغ فروش را وارد کنید" 
                                   style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px; width: 100%;"
                                   oninput="calculateSalary()">
                        </div>
                        <div id="salaryResult" style="background: #1e293b; padding: 20px; border-radius: 8px; display: none;">
                            <p style="color: #94a3b8; margin-bottom: 10px;">حقوق محاسبه شده:</p>
                            <h3 style="color: #10b981; margin: 0; font-size: 28px;" id="calculatedSalary">0 تومان</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="geex-content__section mb-40">
                <h3 style="margin-bottom: 20px; color: #f8fafc;">عملیات سریع</h3>
                <div class="geex-content__form__wrapper" style="display: flex; gap: 20px;">
                    <a href="/panel/seller/report.php" class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; 
                                                                          border: 1px solid rgba(59, 130, 246, 0.2); text-decoration: none; display: block; flex: 1;">
                        <div style="text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 15px;">📊</div>
                            <h5 style="color: #f8fafc; margin-bottom: 10px;">گزارش روزانه</h5>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0;">ثبت گزارش فروش امروز</p>
                        </div>
                    </a>
                    <a href="/panel/seller/monthly.php" class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; 
                                                                          border: 1px solid rgba(59, 130, 246, 0.2); text-decoration: none; display: block; flex: 1;">
                        <div style="text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 15px;">📈</div>
                            <h5 style="color: #f8fafc; margin-bottom: 10px;">گزارش ماهانه</h5>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0;">مشاهده گزارش‌های ماهانه</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script>
function calculateSalary() {
    const salesInput = document.getElementById('salesInput');
    const resultDiv = document.getElementById('salaryResult');
    const salaryDisplay = document.getElementById('calculatedSalary');
    
    const salesAmount = parseFloat(salesInput.value) || 0;
    
    if (salesAmount > 0) {
        fetch('/panel/api/calculate_salary.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ totalSales: salesAmount })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const formattedSalary = new Intl.NumberFormat('fa-IR').format(Math.round(result.salary));
                salaryDisplay.textContent = formattedSalary + ' تومان';
                resultDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        resultDiv.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    loadSalesIncomeChart();
});

function loadSalesIncomeChart() {
    fetch('/panel/api/seller-chart-data.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && typeof ApexCharts !== 'undefined') {
                var options = {
                    series: [
                        {
                            name: 'فروش',
                            data: data.sales
                        },
                        {
                            name: 'درآمد',
                            data: data.income
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
                        categories: data.months,
                        labels: { style: { colors: '#94a3b8' } }
                    },
                    yaxis: {
                        labels: { 
                            style: { colors: '#94a3b8' },
                            formatter: function(val) {
                                return new Intl.NumberFormat('fa-IR').format(Math.round(val / 1000000)) + 'M';
                            }
                        }
                    },
                    legend: {
                        labels: { colors: '#cbd5e1' }
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
                var chart = new ApexCharts(document.querySelector("#sales-income-chart"), options);
                chart.render();
            }
        })
        .catch(error => {
            console.error('Error loading chart:', error);
        });
}
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
</style>

