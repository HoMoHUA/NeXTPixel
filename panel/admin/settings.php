<?php


$pageTitle = 'تنظیمات - NextPixel';
$currentPage = 'settings';

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
                    <span class="np-gradient-text">تنظیمات</span>
                </h2>
                <p class="geex-content__header__subtitle">تنظیمات سیستم و پیکربندی</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">تنظیمات عمومی</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <form class="geex-content__section__form">
                            <div class="geex-content__section__form-group">
                                <label>نام سایت</label>
                                <input type="text" class="geex-content__section__form-input" value="NextPixel">
                            </div>
                            <div class="geex-content__section__form-group">
                                <label>ایمیل تماس</label>
                                <input type="email" class="geex-content__section__form-input">
                            </div>
                            <button type="submit" class="geex-btn geex-btn--primary">ذخیره تغییرات</button>
                        </form>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">تنظیمات n8n</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <p>تنظیمات n8n در این بخش نمایش داده می‌شود.</p>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">تنظیمات امنیتی</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <p>تنظیمات امنیتی در این بخش نمایش داده می‌شود.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


