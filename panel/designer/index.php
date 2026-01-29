<?php
/**
 * Designer Dashboard - Tickets
 * پنل طراح - سیستم تیکت
 */

$pageTitle = 'تیکت‌ها';
$currentPage = 'designer-dashboard';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

// بررسی نقش
if (!hasRole('designer')) {
    header('Location: /panel/index.php');
    exit();
}

$currentUser = getCurrentUser();
require_once __DIR__ . '/../config/db.php';

$db = getPanelDB();
$userId = getCurrentUserId();

// فیلتر تیکت‌ها
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// ساخت کوئری
$query = "SELECT t.*, u.username as client_username, u.display_name as client_name, 
          COUNT(tm.id) as message_count,
          SUM(CASE WHEN tm.is_read = 0 AND tm.user_id != ? THEN 1 ELSE 0 END) as unread_count
          FROM tickets t
          LEFT JOIN users u ON t.client_id = u.id
          LEFT JOIN ticket_messages tm ON t.id = tm.ticket_id
          WHERE t.designer_id = ? OR t.designer_id IS NULL";
$params = [$userId, $userId];

if ($statusFilter !== 'all') {
    $query .= " AND t.status = ?";
    $params[] = $statusFilter;
}

if (!empty($searchQuery)) {
    $query .= " AND (t.subject LIKE ? OR t.description LIKE ?)";
    $searchParam = "%$searchQuery%";
    $params[] = $searchParam;
    $params[] = $searchParam;
}

$query .= " GROUP BY t.id ORDER BY t.created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$tickets = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<main class="geex-main-content">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">سیستم تیکت</h2>
                <p class="geex-content__header__subtitle">مدیریت تیکت‌های مشتریان</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <!-- Filters and Search -->
            <div class="geex-content__section mb-40">
                <div class="geex-content__form__wrapper">
                    <form method="GET" class="geex-content__form">
                        <div style="display: flex; gap: 15px; align-items: end; flex-wrap: wrap;">
                            <div style="flex: 1; min-width: 200px;">
                                <label for="search" style="color: #cbd5e1; margin-bottom: 5px; display: block;">جستجو:</label>
                                <input type="text" id="search" name="search" class="form-control" 
                                       value="<?php echo htmlspecialchars($searchQuery); ?>" 
                                       placeholder="جستجو در موضوع یا محتوا..."
                                       style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                            </div>
                            <div style="flex: 0 0 200px;">
                                <label for="status" style="color: #cbd5e1; margin-bottom: 5px; display: block;">وضعیت:</label>
                                <select id="status" name="status" class="form-control" 
                                        style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                    <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>همه</option>
                                    <option value="open" <?php echo $statusFilter === 'open' ? 'selected' : ''; ?>>باز</option>
                                    <option value="in_progress" <?php echo $statusFilter === 'in_progress' ? 'selected' : ''; ?>>در حال بررسی</option>
                                    <option value="resolved" <?php echo $statusFilter === 'resolved' ? 'selected' : ''; ?>>حل شده</option>
                                    <option value="closed" <?php echo $statusFilter === 'closed' ? 'selected' : ''; ?>>بسته</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="geex-btn" 
                                        style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px;">
                                    فیلتر
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tickets List -->
            <div class="geex-content__section">
                <?php if (!empty($tickets)): ?>
                    <div class="geex-content__form__wrapper">
                        <?php foreach ($tickets as $ticket): ?>
                            <div class="card" style="background: var(--np-dark-card-bg); padding: 25px; border-radius: 12px; 
                                                     border: 1px solid rgba(59, 130, 246, 0.2); margin-bottom: 20px; cursor: pointer;"
                                 onclick="viewTicket(<?php echo $ticket['id']; ?>)">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                                            <h5 style="color: #f8fafc; margin: 0; font-size: 18px;">
                                                <?php echo htmlspecialchars($ticket['subject']); ?>
                                            </h5>
                                            <?php if ($ticket['unread_count'] > 0): ?>
                                                <span class="badge" style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                                    <?php echo $ticket['unread_count']; ?> پیام جدید
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="display: flex; gap: 20px; margin-bottom: 10px; flex-wrap: wrap;">
                                            <span style="color: #94a3b8; font-size: 14px;">
                                                <strong>مشتری:</strong> <?php echo htmlspecialchars($ticket['client_name'] ?? $ticket['client_username'] ?? 'نامشخص'); ?>
                                            </span>
                                            <span style="color: #94a3b8; font-size: 14px;">
                                                <strong>تاریخ:</strong> <?php echo date('Y/m/d H:i', strtotime($ticket['created_at'])); ?>
                                            </span>
                                            <span style="color: #94a3b8; font-size: 14px;">
                                                <strong>پیام‌ها:</strong> <?php echo $ticket['message_count']; ?>
                                            </span>
                                        </div>
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <span class="badge" style="background: <?php
                                                $colors = [
                                                    'open' => '#3b82f6',
                                                    'in_progress' => '#f59e0b',
                                                    'resolved' => '#10b981',
                                                    'closed' => '#64748b'
                                                ];
                                                echo $colors[$ticket['status']] ?? '#64748b';
                                            ?>; padding: 6px 15px; border-radius: 20px; font-size: 13px;">
                                                <?php
                                                $statusText = [
                                                    'open' => 'باز',
                                                    'in_progress' => 'در حال بررسی',
                                                    'resolved' => 'حل شده',
                                                    'closed' => 'بسته'
                                                ];
                                                echo $statusText[$ticket['status']] ?? $ticket['status'];
                                                ?>
                                            </span>
                                            <span class="badge" style="background: <?php
                                                $priorityColors = [
                                                    'low' => '#64748b',
                                                    'medium' => '#3b82f6',
                                                    'high' => '#f59e0b',
                                                    'urgent' => '#ef4444'
                                                ];
                                                echo $priorityColors[$ticket['priority']] ?? '#64748b';
                                            ?>; padding: 6px 15px; border-radius: 20px; font-size: 13px;">
                                                <?php
                                                $priorityText = [
                                                    'low' => 'کم',
                                                    'medium' => 'متوسط',
                                                    'high' => 'زیاد',
                                                    'urgent' => 'فوری'
                                                ];
                                                echo $priorityText[$ticket['priority']] ?? $ticket['priority'];
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div style="text-align: left; margin-right: 20px;">
                                        <i class="uil uil-angle-left" style="color: #94a3b8; font-size: 24px;"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="card" style="background: var(--np-dark-card-bg); padding: 60px; border-radius: 12px; 
                                             border: 1px solid rgba(59, 130, 246, 0.2); text-align: center;">
                        <div style="font-size: 60px; margin-bottom: 20px;">📭</div>
                        <h4 style="color: #94a3b8; margin-bottom: 10px;">تیکتی یافت نشد</h4>
                        <p style="color: #64748b;">هیچ تیکتی با این فیلترها یافت نشد</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
function viewTicket(ticketId) {
    // TODO: Open ticket detail modal or redirect to ticket detail page
    window.location.href = '/panel/designer/ticket.php?id=' + ticketId;
}
</script>

