<?php

$pageTitle = 'گزارش روزانه';
$currentPage = 'seller-report';

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

$today = date('Y-m-d');
$stmt = $db->prepare("SELECT * FROM seller_reports WHERE user_id = ? AND report_date = ?");
$stmt->execute([$userId, $today]);
$todayReport = $stmt->fetch();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportDate = isset($_POST['report_date']) ? $_POST['report_date'] : $today;
    $salesAmount = isset($_POST['sales_amount']) ? floatval($_POST['sales_amount']) : 0;
    $reportText = isset($_POST['report_text']) ? sanitizeInput($_POST['report_text']) : '';
    $noSaleReason = isset($_POST['no_sale_reason']) ? sanitizeInput($_POST['no_sale_reason']) : '';

    $audioFile = null;
    $imageFile = null;
    
    if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
        if (isValidAudio($_FILES['audio_file'])) {
            $audioFile = uploadFile($_FILES['audio_file'], 'uploads/reports/audio/', ['audio/mpeg', 'audio/mp3']);
        }
    }
    
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        if (isValidImage($_FILES['image_file'])) {
            $imageFile = uploadFile($_FILES['image_file'], 'uploads/reports/images/', ['image/jpeg', 'image/jpg', 'image/png']);
        }
    }

    $status = ($salesAmount > 0) ? 'pending' : 'approved';

    try {
        if ($todayReport) {
            
            try {
                $stmt = $db->prepare("UPDATE seller_reports SET sales_amount = ?, report_text = ?, audio_file = ?, image_file = ?, no_sale_reason = ?, status = ?, created_at = NOW() 
                                      WHERE user_id = ? AND report_date = ?");
                $stmt->execute([$salesAmount, $reportText, $audioFile, $imageFile, $noSaleReason, $status, $userId, $reportDate]);
            } catch (PDOException $e) {
                
                error_log("Status column might not exist: " . $e->getMessage());
                $stmt = $db->prepare("UPDATE seller_reports SET sales_amount = ?, report_text = ?, audio_file = ?, image_file = ?, no_sale_reason = ?, created_at = NOW() 
                                      WHERE user_id = ? AND report_date = ?");
                $stmt->execute([$salesAmount, $reportText, $audioFile, $imageFile, $noSaleReason, $userId, $reportDate]);
            }
            $message = 'گزارش با موفقیت به‌روزرسانی شد' . ($salesAmount > 0 ? ' و در انتظار تایید مدیر است' : '');
            $messageType = 'success';
        } else {
            
            try {
                $stmt = $db->prepare("INSERT INTO seller_reports (user_id, report_date, sales_amount, report_text, audio_file, image_file, no_sale_reason, status) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $reportDate, $salesAmount, $reportText, $audioFile, $imageFile, $noSaleReason, $status]);
            } catch (PDOException $e) {
                
                error_log("Status column might not exist: " . $e->getMessage());
                $stmt = $db->prepare("INSERT INTO seller_reports (user_id, report_date, sales_amount, report_text, audio_file, image_file, no_sale_reason) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $reportDate, $salesAmount, $reportText, $audioFile, $imageFile, $noSaleReason]);
            }
            $message = 'گزارش با موفقیت ثبت شد' . ($salesAmount > 0 ? ' و در انتظار تایید مدیر است' : '');
            $messageType = 'success';
        }
    } catch (PDOException $e) {
        error_log("Database error in report submission: " . $e->getMessage());
        $message = 'خطا در ثبت گزارش. لطفاً دوباره تلاش کنید.';
        $messageType = 'error';
    }

    $stmt = $db->prepare("SELECT * FROM seller_reports WHERE user_id = ? AND report_date = ?");
    $stmt->execute([$userId, $today]);
    $todayReport = $stmt->fetch();
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">گزارش روزانه</span>
                </h2>
                <p class="geex-content__header__subtitle">ثبت گزارش فروش و فعالیت روزانه</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>" style="background: <?php echo $messageType == 'success' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)'; ?>; 
                                                                        border: 1px solid <?php echo $messageType == 'success' ? '#10b981' : '#ef4444'; ?>; 
                                                                        padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="geex-content__section">
                <div class="geex-content__form__wrapper">
                    <form method="POST" enctype="multipart/form-data" class="geex-content__form">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">اطلاعات گزارش</h4>
                            <div class="geex-content__form__single__box">
                                <div class="input-wrapper mb-3">
                                    <label for="report_date" class="input-label">تاریخ گزارش:</label>
                                    <input type="date" id="report_date" name="report_date" class="form-control" 
                                           value="<?php echo $todayReport ? htmlspecialchars($todayReport['report_date']) : $today; ?>" 
                                           required style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                </div>

                                <div class="input-wrapper mb-3">
                                    <label for="sales_amount" class="input-label">مبلغ فروش (تومان):</label>
                                    <input type="number" id="sales_amount" name="sales_amount" class="form-control" 
                                           value="<?php echo $todayReport ? htmlspecialchars($todayReport['sales_amount']) : ''; ?>" 
                                           min="0" step="1000" placeholder="0"
                                           style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                    <small style="color: #94a3b8; font-size: 12px;">در صورت عدم فروش، خالی بگذارید</small>
                                </div>
                            </div>
                        </div>

                        <div class="geex-content__form__single" id="noSaleSection" style="display: none;">
                            <h4 class="geex-content__form__single__label">توضیحات عدم فروش</h4>
                            <div class="geex-content__form__single__box">
                                <div class="alert" style="background: rgba(245, 158, 11, 0.2); border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                                    <p style="color: #fbbf24; margin: 0;">⚠ لطفا دلیل عدم فروش را توضیح دهید و فایل‌های لازم را آپلود کنید.</p>
                                </div>
                                <div class="input-wrapper mb-3">
                                    <label for="no_sale_reason" class="input-label">دلیل عدم فروش:</label>
                                    <textarea id="no_sale_reason" name="no_sale_reason" class="form-control" rows="4" 
                                              placeholder="توضیح دهید چرا فروشی انجام نشده است..."
                                              style="background: #1e293b; border: 1px solid #f59e0b; color: white; padding: 12px; border-radius: 8px;"><?php echo $todayReport ? htmlspecialchars($todayReport['no_sale_reason'] ?? '') : ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">متن گزارش</h4>
                            <div class="geex-content__form__single__box">
                                <textarea id="report_text" name="report_text" class="form-control" rows="5" 
                                          placeholder="توضیحات گزارش خود را بنویسید..."
                                          style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;"><?php echo $todayReport ? htmlspecialchars($todayReport['report_text'] ?? '') : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">فایل‌های ضمیمه</h4>
                            <div class="geex-content__form__single__box">
                                <div class="input-wrapper mb-3">
                                    <label for="audio_file" class="input-label">فایل صوتی (MP3):</label>
                                    <input type="file" id="audio_file" name="audio_file" accept="audio/mpeg,audio/mp3" 
                                           class="form-control" style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                    <small style="color: #94a3b8; font-size: 12px;">حجم فایل باید کمتر از 10 مگابایت باشد</small>
                                    <?php if ($todayReport && $todayReport['audio_file']): ?>
                                        <div style="margin-top: 10px;">
                                            <audio controls style="width: 100%;">
                                                <source src="/panel/<?php echo htmlspecialchars($todayReport['audio_file']); ?>" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="input-wrapper mb-3">
                                    <label for="image_file" class="input-label">فایل تصویری (JPG/PNG):</label>
                                    <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/jpg,image/png" 
                                           class="form-control" style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                    <small style="color: #94a3b8; font-size: 12px;">حداکثر اندازه: 5 مگابایت</small>
                                    <?php if ($todayReport && $todayReport['image_file']): ?>
                                        <div style="margin-top: 10px;">
                                            <img src="/panel/<?php echo htmlspecialchars($todayReport['image_file']); ?>" 
                                                 alt="Report Image" style="max-width: 100%; border-radius: 8px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="geex-content__form__single">
                            <button type="submit" class="geex-btn geex-btn-primary" 
                                    style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 15px 40px; width: 100%; font-size: 18px;">
                                <?php echo $todayReport ? 'به‌روزرسانی گزارش' : 'ثبت گزارش'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script>

document.getElementById('sales_amount').addEventListener('input', function() {
    const salesAmount = parseFloat(this.value) || 0;
    const noSaleSection = document.getElementById('noSaleSection');
    
    if (salesAmount === 0 || this.value === '') {
        noSaleSection.style.display = 'block';
        document.getElementById('no_sale_reason').required = true;
    } else {
        noSaleSection.style.display = 'none';
        document.getElementById('no_sale_reason').required = false;
    }
});

window.addEventListener('load', function() {
    const salesInput = document.getElementById('sales_amount');
    if (salesInput.value === '' || parseFloat(salesInput.value) === 0) {
        document.getElementById('noSaleSection').style.display = 'block';
    }
});
</script>

