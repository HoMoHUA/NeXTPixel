<?php


$pageTitle = 'تایید فروش‌ها - NextPixel';
$currentPage = 'approve-sales';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../../config/db-config.php';
require_once __DIR__ . '/../../config/db-connection.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$currentUser = getCurrentUser();
$db = getPanelDB();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $saleId = intval($_POST['sale_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $reason = $_POST['reason'] ?? '';
    
    if ($saleId > 0 && in_array($action, ['approve', 'reject'])) {
        try {
            if ($action === 'approve') {
                try {
                    $stmt = $db->prepare("UPDATE seller_reports 
                                          SET status = 'approved', 
                                              approved_by = ?, 
                                              approved_at = NOW() 
                                          WHERE id = ? AND (status = 'pending' OR status IS NULL)");
                    $stmt->execute([getCurrentUserId(), $saleId]);
                } catch (PDOException $e) {
                    
                    if (strpos($e->getMessage(), 'status') !== false || strpos($e->getMessage(), 'approved_by') !== false) {
                        $stmt = $db->prepare("UPDATE seller_reports 
                                              SET approved_by = ?, 
                                                  approved_at = NOW() 
                                              WHERE id = ?");
                        $stmt->execute([getCurrentUserId(), $saleId]);
                    } else {
                        throw $e;
                    }
                }
                
                
                header('Location: /panel/admin/approve-sales.php?success=approved');
                exit;
            } else {
                try {
                    $stmt = $db->prepare("UPDATE seller_reports 
                                          SET status = 'rejected', 
                                              approved_by = ?, 
                                              approved_at = NOW(),
                                              rejection_reason = ? 
                                          WHERE id = ? AND (status = 'pending' OR status IS NULL)");
                    $stmt->execute([getCurrentUserId(), $reason, $saleId]);
                } catch (PDOException $e) {
                    
                    if (strpos($e->getMessage(), 'status') !== false || strpos($e->getMessage(), 'approved_by') !== false) {
                        $stmt = $db->prepare("UPDATE seller_reports 
                                              SET approved_by = ?, 
                                                  approved_at = NOW(),
                                                  rejection_reason = ? 
                                              WHERE id = ?");
                        $stmt->execute([getCurrentUserId(), $reason, $saleId]);
                    } else {
                        throw $e;
                    }
                }
                
                
                header('Location: /panel/admin/approve-sales.php?success=rejected');
                exit;
            }
        } catch (PDOException $e) {
            error_log("Error updating sale status: " . $e->getMessage());
            header('Location: /panel/admin/approve-sales.php?error=1');
            exit;
        }
    }
}


$successMessage = '';
$errorMessage = '';
if (isset($_GET['success'])) {
    $successMessage = $_GET['success'] === 'approved' ? 'فروش با موفقیت تایید شد' : 'فروش با موفقیت رد شد';
}
if (isset($_GET['error'])) {
    $errorMessage = 'خطا در بروزرسانی وضعیت فروش';
}


try {
    
    try {
        $stmt = $db->prepare("
            SELECT sr.*, u.username, u.display_name 
            FROM seller_reports sr
            JOIN " . TABLE_USERS . " u ON sr.user_id = u.id
            WHERE (sr.status = 'pending' OR sr.status IS NULL)
            AND sr.sales_amount > 0
            ORDER BY sr.report_date DESC, sr.created_at DESC
        ");
        $stmt->execute();
        $pendingSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        
        if (strpos($e->getMessage(), 'status') !== false) {
            $stmt = $db->prepare("
                SELECT sr.*, u.username, u.display_name 
                FROM seller_reports sr
                JOIN " . TABLE_USERS . " u ON sr.user_id = u.id
                WHERE sr.sales_amount > 0
                ORDER BY sr.report_date DESC, sr.created_at DESC
            ");
            $stmt->execute();
            $pendingSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw $e;
        }
    }
} catch (PDOException $e) {
    error_log("Error fetching pending sales: " . $e->getMessage());
    $pendingSales = [];
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">تایید فروش‌ها</span>
                </h2>
                <p class="geex-content__header__subtitle">تایید یا رد فروش‌های ثبت شده توسط فروشندگان</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <?php if ($successMessage): ?>
                <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #10b981;">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($errorMessage): ?>
                <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #ef4444;">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
                <?php endif; ?>
                
                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">فروش‌های در انتظار تایید</h4>
                        <p class="geex-content__section__header__subtitle">تعداد: <?php echo count($pendingSales); ?> مورد</p>
                    </div>
                    <div class="geex-content__section__content">
                        <?php if (empty($pendingSales)): ?>
                            <div class="geex-content__empty">
                                <i class="uil uil-check-circle" style="font-size: 64px; color: var(--np-text-muted);"></i>
                                <p>هیچ فروشی در انتظار تایید نیست</p>
                            </div>
                        <?php else: ?>
                            <div class="geex-table-wrapper">
                                <table class="geex-table">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>فروشنده</th>
                                            <th>مبلغ فروش</th>
                                            <th>حقوق</th>
                                            <th>توضیحات</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pendingSales as $sale): ?>
                                            <?php $saleSalary = calculateSalary($sale['sales_amount']); ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    $date = new DateTime($sale['report_date']);
                                                    echo $date->format('Y/m/d');
                                                    ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($sale['display_name'] ?? $sale['username']); ?></strong>
                                                </td>
                                                <td>
                                                    <strong style="color: #3b82f6;"><?php echo formatNumber($sale['sales_amount']); ?> تومان</strong>
                                                </td>
                                                <td>
                                                    <strong style="color: #10b981;"><?php echo formatNumber($saleSalary); ?> تومان</strong>
                                                </td>
                                                <td>
                                                    <?php if ($sale['report_text']): ?>
                                                        <span style="color: #94a3b8; font-size: 12px;">
                                                            <?php echo htmlspecialchars(substr($sale['report_text'], 0, 50)); ?>...
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="color: #64748b;">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="geex-table__actions">
                                                        <form method="POST" style="display: inline-block;" onsubmit="return confirm('آیا از تایید این فروش مطمئن هستید؟');">
                                                            <input type="hidden" name="sale_id" value="<?php echo $sale['id']; ?>">
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="geex-btn geex-btn--sm geex-btn--success">
                                                                <i class="uil uil-check"></i> تایید
                                                            </button>
                                                        </form>
                                                        <button onclick="showRejectModal(<?php echo $sale['id']; ?>)" 
                                                                class="geex-btn geex-btn--sm geex-btn--danger">
                                                            <i class="uil uil-times"></i> رد
                                                        </button>
                                                    </div>
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
    </div>
</main>


<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 10000; align-items: center; justify-content: center;">
    <div style="background: rgba(15, 23, 42, 0.95); padding: 30px; border-radius: 12px; max-width: 500px; width: 90%;">
        <h3 style="color: #f8fafc; margin-bottom: 20px;">رد فروش</h3>
        <form method="POST" id="rejectForm">
            <input type="hidden" name="sale_id" id="rejectSaleId">
            <input type="hidden" name="action" value="reject">
            <div style="margin-bottom: 20px;">
                <label style="color: #cbd5e1; display: block; margin-bottom: 10px;">دلیل رد:</label>
                <textarea name="reason" required 
                          style="width: 100%; background: #1e293b; border: 1px solid #ef4444; color: white; padding: 12px; border-radius: 8px; min-height: 100px;"
                          placeholder="لطفاً دلیل رد این فروش را وارد کنید..."></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeRejectModal()" 
                        style="background: #64748b; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                    انصراف
                </button>
                <button type="submit" 
                        style="background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                    رد فروش
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(saleId) {
    document.getElementById('rejectSaleId').value = saleId;
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejectForm').reset();
}


document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
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

.geex-table__actions {
    display: flex;
    gap: 8px;
}

.geex-btn--sm {
    padding: 6px 12px;
    font-size: 12px;
}

.geex-btn--success {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 1px solid #10b981;
}

.geex-btn--danger {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
    border: 1px solid #ef4444;
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


