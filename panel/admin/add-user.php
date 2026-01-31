<?php
/**
 * افزودن همکار جدید - پنل مدیریت NextPixel
 */

$pageTitle = 'افزودن همکار جدید - NextPixel';
$currentPage = 'add-user';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';

$currentUser = getCurrentUser();
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">افزودن همکار جدید</span>
                </h2>
                <p class="geex-content__header__subtitle">ایجاد حساب کاربری جدید برای همکار</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">اطلاعات همکار</h4>
                        <p class="geex-content__section__header__subtitle">لطفاً اطلاعات مورد نیاز را وارد کنید</p>
                    </div>
                    
                    <div class="geex-content__section__content">
                        <form id="add-user-form" class="geex-form">
                            <div class="geex-form__group">
                                <label class="geex-form__label">نام کاربری <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="username" 
                                       name="username" 
                                       class="geex-form__input" 
                                       placeholder="نام کاربری را وارد کنید"
                                       required>
                                <small class="geex-form__help">نام کاربری باید یکتا باشد و فقط شامل حروف، اعداد و زیرخط باشد</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">ایمیل <span class="text-red-500">*</span></label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="geex-form__input" 
                                       placeholder="example@domain.com"
                                       required>
                                <small class="geex-form__help">ایمیل معتبر وارد کنید</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">نام نمایشی</label>
                                <input type="text" 
                                       id="display_name" 
                                       name="display_name" 
                                       class="geex-form__input" 
                                       placeholder="نام نمایشی (اختیاری)">
                                <small class="geex-form__help">نامی که در پنل نمایش داده می‌شود</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">رمز عبور <span class="text-red-500">*</span></label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="geex-form__input" 
                                       placeholder="رمز عبور را وارد کنید"
                                       required
                                       minlength="6">
                                <small class="geex-form__help">حداقل ۶ کاراکتر</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">تکرار رمز عبور <span class="text-red-500">*</span></label>
                                <input type="password" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       class="geex-form__input" 
                                       placeholder="رمز عبور را دوباره وارد کنید"
                                       required
                                       minlength="6">
                                <small class="geex-form__help">رمز عبور را دوباره وارد کنید</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">نوع کاربر <span class="text-red-500">*</span></label>
                                <select id="user_type" name="user_type" class="geex-form__select" required>
                                    <option value="">انتخاب کنید</option>
                                    <option value="staff">همکار (Staff)</option>
                                    <option value="customer">مشتری (Customer)</option>
                                </select>
                                <small class="geex-form__help">نوع کاربر را انتخاب کنید</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">نقش (Role)</label>
                                <select id="role" name="role" class="geex-form__select">
                                    <option value="">انتخاب کنید (اختیاری)</option>
                                    <option value="seller">فروشنده (Seller)</option>
                                    <option value="designer">طراح (Designer)</option>
                                    <option value="advisor">مشاور (Advisor)</option>
                                    <option value="staff">همکار (Staff)</option>
                                </select>
                                <small class="geex-form__help">نقش دقیق کاربر در سیستم (در صورت نیاز)</small>
                            </div>

                            <div class="geex-form__group">
                                <label class="geex-form__label">وضعیت <span class="text-red-500">*</span></label>
                                <select id="status" name="status" class="geex-form__select" required>
                                    <option value="active" selected>فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                </select>
                                <small class="geex-form__help">وضعیت حساب کاربری</small>
                            </div>

                            <div id="form-message" class="geex-form__message" style="display: none;"></div>

                            <div class="geex-form__actions">
                                <button type="submit" class="geex-btn geex-btn--primary">
                                    <i class="uil uil-user-plus"></i>
                                    افزودن همکار
                                </button>
                                <a href="/panel/admin/users.php" class="geex-btn geex-btn--secondary">
                                    <i class="uil uil-times"></i>
                                    انصراف
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-user-form');
    const messageDiv = document.getElementById('form-message');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // پاک کردن پیام‌های قبلی
        messageDiv.style.display = 'none';
        messageDiv.className = 'geex-form__message';
        
        // دریافت مقادیر فرم
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const displayName = document.getElementById('display_name').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        const userType = document.getElementById('user_type').value;
        const role = document.getElementById('role').value;
        const status = document.getElementById('status').value;
        
        // اعتبارسنجی
        if (password !== passwordConfirm) {
            showMessage('رمز عبور و تکرار آن یکسان نیستند', 'error');
            return;
        }
        
        if (password.length < 6) {
            showMessage('رمز عبور باید حداقل ۶ کاراکتر باشد', 'error');
            return;
        }
        
        // نمایش loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="uil uil-spinner-alt"></i> در حال افزودن...';
        
        try {
            const response = await fetch('/panel/api/add-user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    username: username,
                    email: email,
                    display_name: displayName || null,
                    password: password,
                    user_type: userType,
                    role: role || null,
                    status: status
                })
            });
            
            // بررسی وضعیت پاسخ
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error('خطا در ارتباط با سرور (کد: ' + response.status + ')');
            }
            
            const data = await response.json();
            
            if (data.success) {
                showMessage(data.message || 'همکار با موفقیت افزوده شد', 'success');
                form.reset();
                
                // هدایت به صفحه لیست کاربران بعد از 2 ثانیه
                setTimeout(() => {
                    window.location.href = '/panel/admin/users.php';
                }, 2000);
            } else {
                showMessage(data.message || 'خطا در افزودن همکار', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('خطا در ارتباط با سرور: ' + (error.message || 'خطای نامشخص'), 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
    
    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.className = 'geex-form__message';
        
        if (type === 'success') {
            messageDiv.classList.add('geex-form__message--success');
            messageDiv.style.background = 'rgba(16, 185, 129, 0.1)';
            messageDiv.style.borderColor = '#10b981';
            messageDiv.style.color = '#10b981';
        } else {
            messageDiv.classList.add('geex-form__message--error');
            messageDiv.style.background = 'rgba(239, 68, 68, 0.1)';
            messageDiv.style.borderColor = '#ef4444';
            messageDiv.style.color = '#ef4444';
        }
        
        messageDiv.style.display = 'block';
    }
});
</script>

<style>
.geex-form__group {
    margin-bottom: 24px;
}

.geex-form__label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--np-text-primary);
}

.geex-form__input,
.geex-form__select {
    width: 100%;
    padding: 12px 16px;
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    color: var(--np-text-primary);
    font-size: 14px;
    transition: all 0.3s ease;
}

.geex-form__input:focus,
.geex-form__select:focus {
    outline: none;
    border-color: var(--np-primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.geex-form__help {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--np-text-muted);
}

.geex-form__message {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid;
}

.geex-form__actions {
    display: flex;
    gap: 12px;
    margin-top: 32px;
}

.geex-btn {
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.geex-btn--primary {
    background: var(--np-gradient);
    color: white;
}

.geex-btn--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.geex-btn--secondary {
    background: rgba(15, 23, 42, 0.6);
    color: var(--np-text-primary);
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.geex-btn--secondary:hover {
    background: rgba(15, 23, 42, 0.8);
}

.geex-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

