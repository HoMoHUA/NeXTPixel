<?php

require_once __DIR__ . '/auth.php';
$currentUser = getCurrentUser();
$userRole = $currentUser ? $currentUser['role'] : null;
?>

<header class="np-mobile-header">
    <div class="np-mobile-header__wrapper">
        <div class="np-mobile-header__logo">
            <a href="/panel/" class="np-gradient-text" style="font-size: 20px; font-weight: 900; text-decoration: none;">
                NextPixel
            </a>
        </div>
        <button class="np-mobile-header__hamburger" id="mobile-menu-toggle" aria-label="منو">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</header>

<div class="np-mobile-menu-overlay" id="mobile-menu-overlay"></div>

<nav class="np-mobile-menu" id="mobile-menu">
    <div class="np-mobile-menu__header">
        <div class="np-mobile-menu__logo">
            <span class="np-gradient-text" style="font-size: 24px; font-weight: 900;">NextPixel</span>
        </div>
        <button class="np-mobile-menu__close" id="mobile-menu-close" aria-label="بستن منو">
            <i class="uil uil-times"></i>
        </button>
    </div>
    
    <div class="np-mobile-menu__user">
        <div class="np-mobile-menu__user__avatar">
            <img src="/panel/assets/img/avatar/user.svg" alt="User">
        </div>
        <div class="np-mobile-menu__user__info">
            <h4><?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username'] ?? 'کاربر'); ?></h4>
            <p><?php echo ucfirst($userRole ?? 'کاربر'); ?></p>
        </div>
    </div>
    
    <div class="np-mobile-menu__content">
        <ul class="np-mobile-menu__list">
            <li class="np-mobile-menu__item">
                <a href="/panel/" class="np-mobile-menu__link <?php echo (!isset($currentPage) || $currentPage == 'dashboard') ? 'active' : ''; ?>">
                    <i class="uil uil-estate"></i>
                    <span>داشبورد</span>
                </a>
            </li>

            <?php if ($userRole === 'customer' || $userRole === 'client'): ?>
            <li class="np-mobile-menu__item">
                <a href="/panel/client/onboarding.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'onboarding') ? 'active' : ''; ?>">
                    <i class="uil uil-file-check-alt"></i>
                    <span>ثبت‌نام پروژه</span>
                </a>
            </li>
            <li class="np-mobile-menu__item">
                <a href="/panel/client/index.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'client-dashboard') ? 'active' : ''; ?>">
                    <i class="uil uil-chart-line"></i>
                    <span>وضعیت پروژه</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($userRole === 'seller'): ?>
            <li class="np-mobile-menu__item">
                <a href="/panel/seller/dashboard.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-dashboard') ? 'active' : ''; ?>">
                    <i class="uil uil-chart-line"></i>
                    <span>داشبورد فروش</span>
                </a>
            </li>
            <li class="np-mobile-menu__item">
                <a href="/panel/seller/report.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-report') ? 'active' : ''; ?>">
                    <i class="uil uil-file-upload-alt"></i>
                    <span>گزارش روزانه</span>
                </a>
            </li>
            <li class="np-mobile-menu__item">
                <a href="/panel/seller/monthly.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-monthly') ? 'active' : ''; ?>">
                    <i class="uil uil-chart-line"></i>
                    <span>گزارش ماهانه</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($userRole === 'designer'): ?>
            <li class="np-mobile-menu__item">
                <a href="/panel/designer/index.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'designer-dashboard') ? 'active' : ''; ?>">
                    <i class="uil uil-envelope"></i>
                    <span>تیکت‌ها</span>
                </a>
            </li>
            <li class="np-mobile-menu__item">
                <a href="/panel/designer/tasks.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'designer-tasks') ? 'active' : ''; ?>">
                    <i class="uil uil-clipboard-notes"></i>
                    <span>وظایف</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($userRole === 'admin'): ?>
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/n8n.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'n8n') ? 'active' : ''; ?>">
                    <i class="uil uil-zap"></i>
                    <span>مدیریت n8n</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/financial.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'financial') ? 'active' : ''; ?>">
                    <i class="uil uil-wallet"></i>
                    <span>داشبورد مالی</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item np-mobile-menu__item--has-submenu">
                <a href="#" class="np-mobile-menu__link np-mobile-menu__link--parent">
                    <i class="uil uil-users-alt"></i>
                    <span>مدیریت کاربران</span>
                    <i class="uil uil-angle-down np-mobile-menu__arrow"></i>
                </a>
                <ul class="np-mobile-menu__submenu">
                    <li class="np-mobile-menu__submenu__item">
                        <a href="/panel/admin/users.php" class="np-mobile-menu__submenu__link <?php echo (isset($currentPage) && $currentPage == 'users') ? 'active' : ''; ?>">
                            <i class="uil uil-list-ul"></i>
                            <span>لیست کاربران</span>
                        </a>
                    </li>
                    <li class="np-mobile-menu__submenu__item">
                        <a href="/panel/admin/add-user.php" class="np-mobile-menu__submenu__link <?php echo (isset($currentPage) && $currentPage == 'add-user') ? 'active' : ''; ?>">
                            <i class="uil uil-user-plus"></i>
                            <span>افزودن همکار جدید</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/approve-sales.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'approve-sales') ? 'active' : ''; ?>">
                    <i class="uil uil-check-circle"></i>
                    <span>تایید فروش‌ها</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/reports.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'reports') ? 'active' : ''; ?>">
                    <i class="uil uil-chart-bar"></i>
                    <span>گزارش‌ها و آمار</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/charts.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'charts') ? 'active' : ''; ?>">
                    <i class="uil uil-chart-pie"></i>
                    <span>نمودارها</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/tables.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'tables') ? 'active' : ''; ?>">
                    <i class="uil uil-table"></i>
                    <span>جداول</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/calendar.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'calendar') ? 'active' : ''; ?>">
                    <i class="uil uil-calendar-alt"></i>
                    <span>تقویم</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/files.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'files') ? 'active' : ''; ?>">
                    <i class="uil uil-folder"></i>
                    <span>مدیریت فایل</span>
                </a>
            </li>
            
            <li class="np-mobile-menu__item">
                <a href="/panel/admin/settings.php" class="np-mobile-menu__link <?php echo (isset($currentPage) && $currentPage == 'settings') ? 'active' : ''; ?>">
                    <i class="uil uil-cog"></i>
                    <span>تنظیمات</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (isLoggedIn()): ?>
            <li class="np-mobile-menu__item np-mobile-menu__item--logout">
                <a href="/panel/auth/logout.php" class="np-mobile-menu__link">
                    <i class="uil uil-signout"></i>
                    <span>خروج</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

