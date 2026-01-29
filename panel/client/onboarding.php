<?php
/**
 * Client Onboarding Wizard
 * ویزارد ثبت‌نام مشتری - 7 مرحله
 */

$pageTitle = 'ثبت‌نام پروژه';
$currentPage = 'onboarding';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

// بررسی نقش - فقط مشتریان
if (!hasRole('customer') && !hasRole('client')) {
    header('Location: /panel/index.php');
    exit();
}

$currentUser = getCurrentUser();
require_once __DIR__ . '/../config/db.php';

// بررسی وضعیت onboarding
$db = getPanelDB();
$userId = getCurrentUserId();
$stmt = $db->prepare("SELECT * FROM client_onboarding WHERE user_id = ?");
$stmt->execute([$userId]);
$onboarding = $stmt->fetch();

$currentStep = $onboarding ? intval($onboarding['step']) : 1;

// دریافت لیست مشاوران
$stmt = $db->prepare("SELECT id, username, display_name FROM users WHERE is_advisor = 1 AND status = 'active' ORDER BY display_name");
$stmt->execute();
$advisors = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<main class="geex-main-content">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">ثبت‌نام پروژه</h2>
                <p class="geex-content__header__subtitle">لطفا مراحل زیر را به ترتیب تکمیل کنید</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <!-- Progress Bar -->
            <div class="geex-content__section mb-40">
                <div class="geex-content__form__wrapper">
                    <div class="progress-step-indicator" style="display: flex; justify-content: space-between; margin-bottom: 30px; position: relative;">
                        <?php for ($i = 1; $i <= 7; $i++): ?>
                            <div class="step-item" style="flex: 1; text-align: center; position: relative;">
                                <div class="step-circle <?php echo $i <= $currentStep ? 'active' : ''; ?>" 
                                     style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo $i <= $currentStep ? 'linear-gradient(45deg, #3b82f6, #8b5cf6)' : '#374151'; ?>; 
                                            color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold;">
                                    <?php echo $i; ?>
                                </div>
                                <div class="step-label" style="font-size: 12px; color: <?php echo $i <= $currentStep ? '#8b5cf6' : '#9ca3af'; ?>;">
                                    <?php
                                    $labels = [
                                        1 => 'تأیید هویت',
                                        2 => 'قرارداد',
                                        3 => 'خلاصه پروژه',
                                        4 => 'انتخاب مشاور',
                                        5 => 'روش پرداخت',
                                        6 => 'پرداخت',
                                        7 => 'تکمیل'
                                    ];
                                    echo $labels[$i];
                                    ?>
                                </div>
                                <?php if ($i < 7): ?>
                                    <div class="step-connector" style="position: absolute; top: 20px; left: calc(50% + 20px); width: calc(100% - 40px); height: 2px; 
                                                                      background: <?php echo $i < $currentStep ? 'linear-gradient(90deg, #3b82f6, #8b5cf6)' : '#374151'; ?>; z-index: -1;"></div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Step Content -->
            <div class="geex-content__section">
                <div class="geex-content__form__wrapper">
                    <!-- Step 1: Identity Confirmation -->
                    <div class="wizard-step" id="step-1" style="display: <?php echo $currentStep == 1 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 1: تأیید هویت</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="form-group mb-3">
                                        <label>نام کاربری:</label>
                                        <p style="color: #cbd5e1; font-size: 16px;"><?php echo htmlspecialchars($currentUser['username']); ?></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>نام نمایشی:</label>
                                        <p style="color: #cbd5e1; font-size: 16px;"><?php echo htmlspecialchars($currentUser['display_name'] ?? 'تعریف نشده'); ?></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>ایمیل:</label>
                                        <p style="color: #cbd5e1; font-size: 16px;"><?php echo htmlspecialchars($currentUser['email'] ?? 'تعریف نشده'); ?></p>
                                    </div>
                                    <button type="button" class="geex-btn geex-btn-primary" onclick="submitStep(1)" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; margin-top: 20px;">
                                        تأیید و ادامه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Contract & Signature -->
                    <div class="wizard-step" id="step-2" style="display: <?php echo $currentStep == 2 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 2: قرارداد و امضا</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="contract-text" style="background: #1e293b; padding: 20px; border-radius: 8px; margin-bottom: 30px; max-height: 300px; overflow-y: auto;">
                                        <h5>قرارداد همکاری با NextPixel</h5>
                                        <p>این قرارداد برای تعریف شرایط همکاری بین مشتری و NextPixel تنظیم شده است. با امضای این قرارداد، شما شرایط و ضوابط ذکر شده را می‌پذیرید.</p>
                                        <p>متن قرارداد در اینجا قرار می‌گیرد...</p>
                                    </div>
                                    <div class="signature-container">
                                        <label>لطفا قرارداد را امضا کنید:</label>
                                        <canvas id="signatureCanvas" width="600" height="200" style="border: 2px dashed #3b82f6; border-radius: 8px; background: white; cursor: crosshair; width: 100%; max-width: 600px; height: 200px;"></canvas>
                                        <button type="button" onclick="clearSignature()" style="margin-top: 10px; padding: 8px 20px; background: #64748b; color: white; border: none; border-radius: 6px; cursor: pointer;">
                                            پاک کردن
                                        </button>
                                    </div>
                                    <button type="button" class="geex-btn geex-btn-primary" onclick="submitStep(2)" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; margin-top: 20px;">
                                        ثبت امضا و ادامه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Project Summary -->
                    <div class="wizard-step" id="step-3" style="display: <?php echo $currentStep == 3 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 3: خلاصه پروژه</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="form-group mb-3">
                                        <label>توضیحات پروژه:</label>
                                        <p style="color: #cbd5e1;"><?php echo htmlspecialchars($onboarding['project_description'] ?? 'پروژه طراحی وب‌سایت'); ?></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>مدت زمان:</label>
                                        <p style="color: #cbd5e1;"><?php echo htmlspecialchars($onboarding['project_duration'] ?? '2 ماه'); ?></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>قیمت کل:</label>
                                        <p style="color: #cbd5e1; font-size: 20px; font-weight: bold;"><?php echo number_format(floatval($onboarding['total_price'] ?? 5000000), 0, '.', ','); ?> تومان</p>
                                    </div>
                                    <button type="button" class="geex-btn geex-btn-primary" onclick="submitStep(3)" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; margin-top: 20px;">
                                        تأیید و ادامه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Advisor Selection -->
                    <div class="wizard-step" id="step-4" style="display: <?php echo $currentStep == 4 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 4: انتخاب مشاور</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="form-group">
                                        <label for="advisor_id">لطفا یک مشاور انتخاب کنید: *</label>
                                        <select class="form-control" id="advisor_id" name="advisor_id" required style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px;">
                                            <option value="">-- انتخاب مشاور --</option>
                                            <?php foreach ($advisors as $advisor): ?>
                                                <option value="<?php echo $advisor['id']; ?>" <?php echo ($onboarding && $onboarding['advisor_id'] == $advisor['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($advisor['display_name'] ?? $advisor['username']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (empty($advisors)): ?>
                                            <p style="color: #ef4444; margin-top: 10px;">در حال حاضر مشاوری برای انتخاب وجود ندارد. لطفا با مدیریت تماس بگیرید.</p>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="geex-btn geex-btn-primary" onclick="submitStep(4)" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; margin-top: 20px;">
                                        ثبت و ادامه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Payment Method -->
                    <div class="wizard-step" id="step-5" style="display: <?php echo $currentStep == 5 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 5: روش پرداخت</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="form-group">
                                        <label>لطفا روش پرداخت خود را انتخاب کنید:</label>
                                        <div class="payment-options" style="margin-top: 20px;">
                                            <div class="form-check mb-3" style="padding: 20px; background: #1e293b; border-radius: 8px; border: 2px solid transparent;">
                                                <input class="form-check-input" type="radio" name="payment_method" id="cash_check" value="cash_check" 
                                                       <?php echo ($onboarding && $onboarding['payment_method'] == 'cash_check') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="cash_check" style="color: #cbd5e1; cursor: pointer; width: 100%;">
                                                    <strong>نقدی/چک</strong>
                                                    <p style="margin: 5px 0 0; font-size: 14px;">50% نقدی + 50% چک یک‌ماهه</p>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3" style="padding: 20px; background: #1e293b; border-radius: 8px; border: 2px solid transparent;">
                                                <input class="form-check-input" type="radio" name="payment_method" id="progressive" value="progressive"
                                                       <?php echo ($onboarding && $onboarding['payment_method'] == 'progressive') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="progressive" style="color: #cbd5e1; cursor: pointer; width: 100%;">
                                                    <strong>پلکانی</strong>
                                                    <p style="margin: 5px 0 0; font-size: 14px;">50% اکنون + 50% در 50% پیشرفت پروژه</p>
                                                </label>
                                            </div>
                                            <div class="form-check mb-3" style="padding: 20px; background: linear-gradient(135deg, #1e293b 0%, #2d1b4e 100%); border-radius: 8px; border: 2px solid #8b5cf6;">
                                                <input class="form-check-input" type="radio" name="payment_method" id="full_cash" value="full_cash"
                                                       <?php echo ($onboarding && $onboarding['payment_method'] == 'full_cash') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="full_cash" style="color: #cbd5e1; cursor: pointer; width: 100%;">
                                                    <strong>تمام نقدی (100%)</strong>
                                                    <p style="margin: 5px 0 0; font-size: 14px; color: #a78bfa;">🎁 دریافت هدیه چت‌بات هوش مصنوعی رایگان!</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="ai-gift-message" style="display: none; margin-top: 20px; padding: 15px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%); border-radius: 8px; border: 1px solid #8b5cf6;">
                                            <h5 style="color: #a78bfa; margin-bottom: 10px;">🎉 تبریک!</h5>
                                            <p style="color: #cbd5e1;">شما با انتخاب روش پرداخت تمام نقدی، چت‌بات هوش مصنوعی رایگان دریافت می‌کنید!</p>
                                        </div>
                                    </div>
                                    <button type="button" class="geex-btn geex-btn-primary" onclick="submitStep(5)" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 12px 30px; margin-top: 20px;">
                                        ثبت و ادامه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Payment -->
                    <div class="wizard-step" id="step-6" style="display: <?php echo $currentStep == 6 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <h4 class="geex-content__form__single__label">مرحله 6: پرداخت</h4>
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="payment-summary">
                                        <h5 style="margin-bottom: 20px;">خلاصه پرداخت:</h5>
                                        <div style="background: #1e293b; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                                <span>قیمت کل پروژه:</span>
                                                <strong><?php echo number_format(floatval($onboarding['total_price'] ?? 5000000), 0, '.', ','); ?> تومان</strong>
                                            </div>
                                            <?php if ($onboarding && $onboarding['payment_method'] == 'full_cash'): ?>
                                                <div style="display: flex; justify-content: space-between; color: #10b981;">
                                                    <span>هدیه چت‌بات AI:</span>
                                                    <strong>رایگان!</strong>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="geex-btn geex-btn-primary" onclick="processPayment()" style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 15px 40px; width: 100%; font-size: 18px;">
                                            پرداخت و تکمیل
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 7: Completion -->
                    <div class="wizard-step" id="step-7" style="display: <?php echo $currentStep == 7 ? 'block' : 'none'; ?>;">
                        <div class="geex-content__form__single">
                            <div class="geex-content__form__single__box">
                                <div class="card" style="background: var(--np-dark-card-bg); padding: 40px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2); text-align: center;">
                                    <div style="font-size: 60px; margin-bottom: 20px;">✅</div>
                                    <h3 style="color: #10b981; margin-bottom: 20px;">تبریک! ثبت‌نام شما با موفقیت انجام شد</h3>
                                    <?php if ($onboarding && $onboarding['support_id']): ?>
                                        <div style="background: #1e293b; padding: 20px; border-radius: 8px; margin: 30px 0;">
                                            <p style="color: #cbd5e1; margin-bottom: 10px;">شناسه پشتیبانی شما:</p>
                                            <p style="font-size: 24px; font-weight: bold; color: #3b82f6; letter-spacing: 2px;">
                                                <?php echo htmlspecialchars($onboarding['support_id']); ?>
                                            </p>
                                            <p style="color: #94a3b8; font-size: 14px; margin-top: 10px;">لطفا این شناسه را یادداشت کنید</p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($onboarding && $onboarding['payment_method'] == 'full_cash'): ?>
                                        <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%); padding: 20px; border-radius: 8px; border: 1px solid #8b5cf6; margin: 20px 0;">
                                            <h5 style="color: #a78bfa;">🎁 چت‌بات هوش مصنوعی شما فعال شد!</h5>
                                            <p style="color: #cbd5e1; margin-top: 10px;">مشاور شما به زودی با شما تماس خواهد گرفت.</p>
                                        </div>
                                    <?php endif; ?>
                                    <a href="/panel/client/index.php" class="geex-btn geex-btn-primary" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; padding: 15px 40px; margin-top: 30px; display: inline-block; text-decoration: none; color: white;">
                                        رفتن به داشبورد
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
// Signature Canvas
const canvas = document.getElementById('signatureCanvas');
const ctx = canvas.getContext('2d');
let isDrawing = false;

if (canvas) {
    // Set canvas size
    canvas.width = canvas.offsetWidth;
    canvas.height = 200;
    
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    
    // Touch events for mobile
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        ctx.beginPath();
        ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
        isDrawing = true;
    });
    
    canvas.addEventListener('touchmove', (e) => {
        if (!isDrawing) return;
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
        ctx.stroke();
    });
    
    canvas.addEventListener('touchend', stopDrawing);
}

function startDrawing(e) {
    isDrawing = true;
    const rect = canvas.getBoundingClientRect();
    ctx.beginPath();
    ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
}

function draw(e) {
    if (!isDrawing) return;
    const rect = canvas.getBoundingClientRect();
    ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    ctx.stroke();
}

function stopDrawing() {
    isDrawing = false;
}

function clearSignature() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// Show/hide AI gift message
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const aiMessage = document.getElementById('ai-gift-message');
        if (this.value === 'full_cash') {
            aiMessage.style.display = 'block';
        } else {
            aiMessage.style.display = 'none';
        }
    });
});

// Submit Step Function
function submitStep(step) {
    let data = { step: step };
    
    if (step === 2) {
        // Get signature as Base64
        const signature = canvas.toDataURL('image/png');
        if (!signature || signature.length < 100) {
            alert('لطفا قرارداد را امضا کنید');
            return;
        }
        data.signature = signature;
    } else if (step === 4) {
        const advisorId = document.getElementById('advisor_id').value;
        if (!advisorId) {
            alert('لطفا یک مشاور انتخاب کنید');
            return;
        }
        data.advisor_id = advisorId;
    } else if (step === 5) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            alert('لطفا روش پرداخت را انتخاب کنید');
            return;
        }
        data.payment_method = paymentMethod.value;
    }
    
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = 'در حال ارسال...';
    btn.disabled = true;
    
    fetch('/panel/api/process_client_step.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            if (result.next_step) {
                window.location.reload();
            }
        } else {
            alert('خطا: ' + result.message);
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در ارتباط با سرور');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function processPayment() {
    // Simulate payment processing
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = 'در حال پردازش پرداخت...';
    btn.disabled = true;
    
    // Simulate payment delay
    setTimeout(() => {
        submitStep(6);
    }, 2000);
}
</script>

<style>
.wizard-step {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-check input[type="radio"]:checked + label {
    color: #3b82f6 !important;
}

.form-check:hover {
    border-color: #3b82f6 !important;
    transition: all 0.3s;
}
</style>

