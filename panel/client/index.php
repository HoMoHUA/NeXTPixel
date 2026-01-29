<?php
/**
 * Client Dashboard
 * داشبورد مشتری
 */

$pageTitle = 'داشبورد مشتری';
$currentPage = 'client-dashboard';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

// بررسی نقش
if (!hasRole('customer') && !hasRole('client')) {
    header('Location: /panel/index.php');
    exit();
}

$currentUser = getCurrentUser();
require_once __DIR__ . '/../config/db.php';

$db = getPanelDB();
$userId = getCurrentUserId();

// دریافت اطلاعات onboarding
$stmt = $db->prepare("SELECT * FROM client_onboarding WHERE user_id = ?");
$stmt->execute([$userId]);
$onboarding = $stmt->fetch();

// محاسبه پیشرفت پروژه
$progress = 0;
$status = 'در حال بررسی';
if ($onboarding) {
    $currentStep = intval($onboarding['step']);
    if ($currentStep >= 7) {
        $progress = 100;
        $status = 'تکمیل شده';
    } else {
        $progress = ($currentStep / 7) * 100;
        $statuses = [
            1 => 'تأیید هویت',
            2 => 'امضای قرارداد',
            3 => 'تأیید پروژه',
            4 => 'انتخاب مشاور',
            5 => 'تعیین روش پرداخت',
            6 => 'پرداخت',
            7 => 'تکمیل'
        ];
        $status = $statuses[$currentStep] ?? 'در حال بررسی';
    }
}

// دریافت تیکت‌ها
$stmt = $db->prepare("SELECT t.*, COUNT(tm.id) as message_count FROM tickets t 
                      LEFT JOIN ticket_messages tm ON t.id = tm.ticket_id 
                      WHERE t.client_id = ? GROUP BY t.id ORDER BY t.created_at DESC LIMIT 5");
$stmt->execute([$userId]);
$tickets = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<main class="geex-main-content">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">داشبورد مشتری</h2>
                <p class="geex-content__header__subtitle">خوش آمدید <?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?></p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <!-- Onboarding Status -->
            <?php if (!$onboarding || $onboarding['step'] < 7): ?>
            <div class="geex-content__section mb-40">
                <div class="alert" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%); 
                                          border: 1px solid #3b82f6; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                    <h5 style="color: #60a5fa; margin-bottom: 10px;">ثبت‌نام شما هنوز تکمیل نشده است</h5>
                    <p style="color: #cbd5e1;">لطفا برای تکمیل ثبت‌نام، از <a href="/panel/client/onboarding.php" style="color: #a78bfa; text-decoration: underline;">اینجا</a> وارد شوید.</p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Progress Bar -->
            <?php if ($onboarding): ?>
            <div class="geex-content__section mb-40">
                <div class="geex-content__feature">
                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text" style="width: 100%;">
                            <p class="geex-content__feature__card__subtitle">وضعیت پروژه</p>
                            <h4 class="geex-content__feature__card__title"><?php echo $status; ?></h4>
                            <div style="margin-top: 20px;">
                                <div style="background: #1e293b; height: 20px; border-radius: 10px; overflow: hidden; position: relative;">
                                    <div style="background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899); 
                                                height: 100%; width: <?php echo $progress; ?>%; 
                                                transition: width 0.5s ease; 
                                                position: relative; overflow: hidden;">
                                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; 
                                                    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); 
                                                    animation: shine 2s infinite;"></div>
                                    </div>
                                </div>
                                <p style="margin-top: 10px; color: #94a3b8; font-size: 14px;"><?php echo round($progress); ?>% تکمیل شده</p>
                            </div>
                            <?php if ($onboarding['support_id']): ?>
                                <div style="margin-top: 20px; padding: 15px; background: #1e293b; border-radius: 8px;">
                                    <p style="color: #94a3b8; font-size: 12px; margin-bottom: 5px;">شناسه پشتیبانی:</p>
                                    <p style="color: #3b82f6; font-size: 18px; font-weight: bold; letter-spacing: 2px;">
                                        <?php echo htmlspecialchars($onboarding['support_id']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Project Stages -->
            <?php if ($onboarding && $onboarding['onboarding_completed']): ?>
            <div class="geex-content__section mb-40">
                <h3 style="margin-bottom: 20px; color: #f8fafc;">مراحل پروژه</h3>
                <div class="geex-content__form__wrapper">
                    <?php
                    $stages = [
                        ['name' => 'تحلیل', 'icon' => '📊', 'color' => '#3b82f6'],
                        ['name' => 'طراحی', 'icon' => '🎨', 'color' => '#8b5cf6'],
                        ['name' => 'توسعه', 'icon' => '💻', 'color' => '#ec4899'],
                        ['name' => 'تست', 'icon' => '✅', 'color' => '#10b981'],
                        ['name' => 'تحویل', 'icon' => '🚀', 'color' => '#f59e0b']
                    ];
                    foreach ($stages as $index => $stage):
                        $isActive = false; // TODO: Get from database
                    ?>
                    <div class="card" style="background: var(--np-dark-card-bg); padding: 20px; border-radius: 12px; 
                                             border: 1px solid <?php echo $isActive ? $stage['color'] : 'rgba(59, 130, 246, 0.2)'; ?>; 
                                             flex: 1; margin: 0 10px;">
                        <div style="font-size: 40px; text-align: center; margin-bottom: 10px;"><?php echo $stage['icon']; ?></div>
                        <h5 style="text-align: center; color: <?php echo $isActive ? $stage['color'] : '#94a3b8'; ?>;">
                            <?php echo $stage['name']; ?>
                        </h5>
                        <div style="text-align: center; margin-top: 10px;">
                            <span style="color: <?php echo $isActive ? '#10b981' : '#64748b'; ?>; font-size: 12px;">
                                <?php echo $isActive ? 'فعال' : 'در انتظار'; ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Payment Status -->
            <?php if ($onboarding && $onboarding['payment_method']): ?>
            <div class="geex-content__section mb-40">
                <h3 style="margin-bottom: 20px; color: #f8fafc;">وضعیت پرداخت</h3>
                <div class="geex-content__feature">
                    <div class="geex-content__feature__card" style="background: var(--np-dark-card-bg); border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div class="geex-content__feature__card__text" style="width: 100%;">
                            <p class="geex-content__feature__card__subtitle">روش پرداخت</p>
                            <h4 class="geex-content__feature__card__title">
                                <?php
                                $methods = [
                                    'cash_check' => 'نقدی/چک',
                                    'progressive' => 'پلکانی',
                                    'full_cash' => 'تمام نقدی'
                                ];
                                echo $methods[$onboarding['payment_method']] ?? 'تعریف نشده';
                                ?>
                            </h4>
                            <?php if ($onboarding['payment_status'] != 'completed' && $onboarding['payment_method'] != 'full_cash'): ?>
                                <button class="geex-btn geex-btn-primary" onclick="payRemainder()" 
                                        style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 12px 30px; margin-top: 20px;">
                                    پرداخت باقیمانده
                                </button>
                            <?php elseif ($onboarding['payment_method'] == 'full_cash'): ?>
                                <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%); 
                                             border-radius: 8px; border: 1px solid #8b5cf6;">
                                    <p style="color: #a78bfa; margin: 0;">🎁 چت‌بات هوش مصنوعی شما فعال است!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Recent Tickets -->
            <div class="geex-content__section mb-40">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="color: #f8fafc; margin: 0;">تیکت‌های اخیر</h3>
                    <button class="geex-btn" onclick="createTicket()" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 10px 20px;">
                        تیکت جدید
                    </button>
                </div>
                
                <?php if (!empty($tickets)): ?>
                <div class="geex-content__form__wrapper">
                    <?php foreach ($tickets as $ticket): ?>
                    <div class="card" style="background: var(--np-dark-card-bg); padding: 20px; border-radius: 12px; 
                                             border: 1px solid rgba(59, 130, 246, 0.2); margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1;">
                                <h5 style="color: #f8fafc; margin-bottom: 10px;"><?php echo htmlspecialchars($ticket['subject']); ?></h5>
                                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 10px;">
                                    <?php echo date('Y/m/d H:i', strtotime($ticket['created_at'])); ?>
                                </p>
                                <span class="badge" style="background: <?php
                                    $colors = [
                                        'open' => '#3b82f6',
                                        'in_progress' => '#f59e0b',
                                        'resolved' => '#10b981',
                                        'closed' => '#64748b'
                                    ];
                                    echo $colors[$ticket['status']] ?? '#64748b';
                                ?>; padding: 5px 15px; border-radius: 20px; font-size: 12px;">
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
                            </div>
                            <div style="text-align: left;">
                                <span style="color: #94a3b8; font-size: 14px;"><?php echo $ticket['message_count']; ?> پیام</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="card" style="background: var(--np-dark-card-bg); padding: 40px; border-radius: 12px; 
                                         border: 1px solid rgba(59, 130, 246, 0.2); text-align: center;">
                    <p style="color: #94a3b8;">هنوز تیکتی ایجاد نشده است</p>
                    <button class="geex-btn" onclick="createTicket()" 
                            style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 10px 20px; margin-top: 15px;">
                        ایجاد تیکت جدید
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
function payRemainder() {
    if (confirm('آیا می‌خواهید باقیمانده مبلغ را پرداخت کنید؟')) {
        // TODO: Redirect to payment gateway
        alert('در حال هدایت به درگاه پرداخت...');
    }
}

function createTicket() {
    // TODO: Open modal or redirect to ticket creation page
    alert('این قابلیت به زودی اضافه می‌شود');
}

// Shine animation for progress bar
const style = document.createElement('style');
style.textContent = `
    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
`;
document.head.appendChild(style);
</script>

