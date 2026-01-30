<?php

$pageTitle = 'مدیریت کاربران - NextPixel';
$currentPage = 'users';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';

$currentUser = getCurrentUser();

require_once __DIR__ . '/../config/db.php';
$db = getPanelDB();

try {
    $stmt = $db->prepare("
        SELECT id, username, email, display_name, user_type, role, status, created_at 
        FROM " . TABLE_USERS . " 
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
    error_log("Error fetching users: " . $e->getMessage());
}
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">مدیریت کاربران</span>
                </h2>
                <p class="geex-content__header__subtitle">لیست تمام کاربران سیستم</p>
            </div>
            <div class="geex-content__header__action">
                <a href="/panel/admin/add-user.php" class="geex-btn geex-btn--primary">
                    <i class="uil uil-user-plus"></i>
                    افزودن همکار جدید
                </a>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">لیست کاربران</h4>
                        <p class="geex-content__section__header__subtitle">تعداد کل: <?php echo count($users); ?> کاربر</p>
                    </div>
                    
                    <div class="geex-content__section__content">
                        <?php if (empty($users)): ?>
                            <div class="geex-content__empty">
                                <i class="uil uil-users-alt" style="font-size: 64px; color: var(--np-text-muted);"></i>
                                <p>هیچ کاربری یافت نشد</p>
                                <a href="/panel/admin/add-user.php" class="geex-btn geex-btn--primary">
                                    افزودن اولین کاربر
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="geex-table-wrapper">
                                <table class="geex-table">
                                    <thead>
                                        <tr>
                                            <th>شناسه</th>
                                            <th>نام کاربری</th>
                                            <th>ایمیل</th>
                                            <th>نام نمایشی</th>
                                            <th>نوع کاربر</th>
                                            <th>نقش</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ ایجاد</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['display_name'] ?? '-'); ?></td>
                                                <td>
                                                    <span class="geex-badge geex-badge--<?php echo $user['user_type'] === 'admin' ? 'danger' : ($user['user_type'] === 'staff' ? 'primary' : 'success'); ?>">
                                                        <?php 
                                                        $types = ['admin' => 'مدیر', 'staff' => 'همکار', 'customer' => 'مشتری'];
                                                        echo $types[$user['user_type']] ?? $user['user_type'];
                                                        ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($user['role']): ?>
                                                        <span class="geex-badge geex-badge--info">
                                                            <?php 
                                                            $roles = ['seller' => 'فروشنده', 'designer' => 'طراح', 'advisor' => 'مشاور', 'admin' => 'مدیر', 'staff' => 'همکار'];
                                                            echo $roles[$user['role']] ?? $user['role'];
                                                            ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="geex-badge geex-badge--<?php echo $user['status'] === 'active' ? 'success' : 'warning'; ?>">
                                                        <?php echo $user['status'] === 'active' ? 'فعال' : 'غیرفعال'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $date = new DateTime($user['created_at']);
                                                    echo $date->format('Y/m/d H:i');
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="geex-table__actions">
                                                        <a href="/panel/admin/edit-user.php?id=<?php echo $user['id']; ?>" 
                                                           class="geex-btn geex-btn--sm geex-btn--info" 
                                                           title="ویرایش">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                        <button onclick="confirmDelete(<?php echo $user['id']; ?>)" 
                                                                class="geex-btn geex-btn--sm geex-btn--danger" 
                                                                title="حذف">
                                                            <i class="uil uil-trash"></i>
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

<style>
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

.geex-badge--primary {
    background: rgba(59, 130, 246, 0.2);
    color: var(--np-primary);
}

.geex-badge--success {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.geex-badge--warning {
    background: rgba(245, 158, 11, 0.2);
    color: #f59e0b;
}

.geex-badge--danger {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.geex-badge--info {
    background: rgba(139, 92, 246, 0.2);
    color: var(--np-secondary);
}

.geex-table__actions {
    display: flex;
    gap: 8px;
}

.geex-btn--sm {
    padding: 6px 12px;
    font-size: 12px;
}

.geex-content__empty {
    text-align: center;
    padding: 60px 20px;
}

.geex-content__empty p {
    margin: 20px 0;
    color: var(--np-text-muted);
    font-size: 16px;
}
</style>

<script>
function confirmDelete(userId) {
    if (confirm('آیا از حذف این کاربر مطمئن هستید؟ این عمل غیرقابل بازگشت است.')) {
        $.ajax({
            url: '/panel/api/delete-user.php',
            type: 'POST',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('خطا: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('خطا در برقراری ارتباط با سرور.');
                console.error("AJAX Error: ", status, error, xhr.responseText);
            }
        });
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

