<?php
/**
 * Sidebar Include File
 * فایل شامل سایدبار مشترک
 */
$currentUser = getCurrentUser();
$userRole = $currentUser ? $currentUser['role'] : null;
?>
<div class="geex-sidebar">
    <a href="#" class="geex-sidebar__close">
        <i class="uil uil-times"></i>
    </a>
    <div class="geex-sidebar__wrapper">
        <div class="geex-sidebar__header">
            <a href="/panel/" class="geex-sidebar__logo">
                <span class="np-gradient-text" style="font-size: 24px; font-weight: 900;">NextPixel</span>
            </a>
        </div>
        <nav class="geex-sidebar__menu-wrapper">
            <ul class="geex-sidebar__menu">
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/" class="geex-sidebar__menu__link <?php echo (!isset($currentPage) || $currentPage == 'dashboard') ? 'active' : ''; ?>">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1139_9707)">
                            <path d="M21.1943 8.31319L14.2413 1.35936C13.3808 0.501345 12.2152 0.0195312 11 0.0195312C9.78482 0.0195312 8.61921 0.501345 7.75868 1.35936L0.805761 8.31319C0.549484 8.56782 0.3463 8.8708 0.207987 9.20454C0.0696733 9.53829 -0.00101787 9.89617 1.10729e-05 10.2574V19.2564C1.10729e-05 19.9857 0.289742 20.6852 0.805467 21.2009C1.32119 21.7166 2.02067 22.0064 2.75001 22.0064H19.25C19.9794 22.0064 20.6788 21.7166 21.1946 21.2009C21.7103 20.6852 22 19.9857 22 19.2564V10.2574C22.001 9.89617 21.9303 9.53829 21.792 9.20454C21.6537 8.8708 21.4505 8.56782 21.1943 8.31319ZM13.75 20.173H8.25001V16.5669C8.25001 15.8375 8.53974 15.138 9.05547 14.6223C9.57119 14.1066 10.2707 13.8169 11 13.8169C11.7294 13.8169 12.4288 14.1066 12.9446 14.6223C13.4603 15.138 13.75 15.8375 13.75 16.5669V20.173ZM20.1667 19.2564C20.1667 19.4995 20.0701 19.7326 19.8982 19.9045C19.7263 20.0764 19.4931 20.173 19.25 20.173H15.5833V16.5669C15.5833 15.3513 15.1005 14.1855 14.2409 13.3259C13.3814 12.4664 12.2156 11.9835 11 11.9835C9.78444 11.9835 8.61865 12.4664 7.75911 13.3259C6.89956 14.1855 6.41668 15.3513 6.41668 16.5669V20.173H2.75001C2.5069 20.173 2.27374 20.0764 2.10183 19.9045C1.92992 19.7326 1.83334 19.4995 1.83334 19.2564V10.2574C1.83419 10.0145 1.93068 9.78168 2.10193 9.60935L9.05485 2.65827C9.57157 2.14396 10.271 1.85522 11 1.85522C11.7291 1.85522 12.4285 2.14396 12.9452 2.65827L19.8981 9.61211C20.0687 9.78375 20.1651 10.0155 20.1667 10.2574V19.2564Z" fill="#B9BBBD"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1139_9707">
                            <rect width="22" height="22" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <span>داشبورد</span>
                    </a>
                </li>

                <?php if ($userRole === 'customer' || $userRole === 'client'): ?>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/client/onboarding.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'onboarding') ? 'active' : ''; ?>">
                        <i class="uil uil-file-check-alt"></i>
                        <span>ثبت‌نام پروژه</span>
                    </a>
                </li>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/client/index.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'client-dashboard') ? 'active' : ''; ?>">
                        <i class="uil uil-chart-line"></i>
                        <span>وضعیت پروژه</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($userRole === 'seller'): ?>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/seller/dashboard.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-dashboard') ? 'active' : ''; ?>">
                        <i class="uil uil-chart-line"></i>
                        <span>داشبورد فروش</span>
                    </a>
                </li>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/seller/report.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-report') ? 'active' : ''; ?>">
                        <i class="uil uil-file-upload-alt"></i>
                        <span>گزارش روزانه</span>
                    </a>
                </li>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/seller/monthly.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'seller-monthly') ? 'active' : ''; ?>">
                        <i class="uil uil-chart-line"></i>
                        <span>گزارش ماهانه</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($userRole === 'designer'): ?>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/designer/index.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'designer-dashboard') ? 'active' : ''; ?>">
                        <i class="uil uil-envelope"></i>
                        <span>تیکت‌ها</span>
                    </a>
                </li>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/designer/tasks.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'designer-tasks') ? 'active' : ''; ?>">
                        <i class="uil uil-clipboard-notes"></i>
                        <span>وظایف</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if ($userRole === 'admin'): ?>
                <!-- مدیریت n8n -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/n8n.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'n8n') ? 'active' : ''; ?>">
                        <i class="uil uil-zap"></i>
                        <span>مدیریت n8n</span>
                    </a>
                </li>
                
                <!-- داشبورد مالی -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/financial.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'financial') ? 'active' : ''; ?>">
                        <i class="uil uil-wallet"></i>
                        <span>داشبورد مالی</span>
                    </a>
                </li>
                
                <!-- مدیریت کاربران -->
                <li class="geex-sidebar__menu__item has-children <?php echo (isset($currentPage) && ($currentPage == 'users' || $currentPage == 'add-user')) ? 'active' : ''; ?>">
                    <a href="#" class="geex-sidebar__menu__link">
                        <i class="uil uil-users-alt"></i>
                        <span>مدیریت کاربران</span>
                        <i class="uil uil-angle-down geex-sidebar__menu__arrow"></i>
                    </a>
                    <ul class="geex-sidebar__submenu" style="<?php echo (isset($currentPage) && ($currentPage == 'users' || $currentPage == 'add-user')) ? 'display: block; max-height: 500px;' : ''; ?>">
                        <li class="geex-sidebar__menu__item">
                            <a href="/panel/admin/users.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'users') ? 'active' : ''; ?>">
                                <i class="uil uil-list-ul"></i>
                                <span>لیست کاربران</span>
                            </a>
                        </li>
                        <li class="geex-sidebar__menu__item">
                            <a href="/panel/admin/add-user.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'add-user') ? 'active' : ''; ?>">
                                <i class="uil uil-user-plus"></i>
                                <span>افزودن همکار جدید</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- تایید فروش‌ها -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/approve-sales.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'approve-sales') ? 'active' : ''; ?>">
                        <i class="uil uil-check-circle"></i>
                        <span>تایید فروش‌ها</span>
                    </a>
                </li>
                
                <!-- گزارش‌ها و آمار -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/reports.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'reports') ? 'active' : ''; ?>">
                        <i class="uil uil-chart-bar"></i>
                        <span>گزارش‌ها و آمار</span>
                    </a>
                </li>
                
                <!-- نمودارها -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/charts.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'charts') ? 'active' : ''; ?>">
                        <i class="uil uil-chart-pie"></i>
                        <span>نمودارها</span>
                    </a>
                </li>
                
                <!-- جدول‌ها -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/tables.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'tables') ? 'active' : ''; ?>">
                        <i class="uil uil-table"></i>
                        <span>جداول</span>
                    </a>
                </li>
                
                <!-- تقویم -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/calendar.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'calendar') ? 'active' : ''; ?>">
                        <i class="uil uil-calendar-alt"></i>
                        <span>تقویم</span>
                    </a>
                </li>
                
                <!-- مدیریت فایل -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/files.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'files') ? 'active' : ''; ?>">
                        <i class="uil uil-folder"></i>
                        <span>مدیریت فایل</span>
                    </a>
                </li>
                
                <!-- تنظیمات -->
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/admin/settings.php" class="geex-sidebar__menu__link <?php echo (isset($currentPage) && $currentPage == 'settings') ? 'active' : ''; ?>">
                        <i class="uil uil-cog"></i>
                        <span>تنظیمات</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (isLoggedIn()): ?>
                <li class="geex-sidebar__menu__item">
                    <a href="/panel/auth/logout.php" class="geex-sidebar__menu__link">
                        <i class="uil uil-signout"></i>
                        <span>خروج</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="geex-sidebar__footer">
            <span class="geex-sidebar__footer__title np-gradient-text">NextPixel Dashboard</span>
            <p class="geex-sidebar__footer__copyright">© 2025 کلیه حقوق محفوظ است</p>
        </div>
    </div>
</div>

