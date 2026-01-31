<?php


$pageTitle = 'گزارش‌ها و آمار - NextPixel';
$currentPage = 'reports';

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
                    <span class="np-gradient-text">گزارش‌ها و آمار</span>
                </h2>
                <p class="geex-content__header__subtitle">گزارش‌های جامع و آمار عملکرد</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">گزارش فروش</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <p>گزارش فروش در این بخش نمایش داده می‌شود.</p>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">گزارش پروژه‌ها</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <p>گزارش پروژه‌ها در این بخش نمایش داده می‌شود.</p>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">آمار کاربران</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <p>آمار کاربران در این بخش نمایش داده می‌شود.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


