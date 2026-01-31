<?php


$pageTitle = 'داشبورد - NextPixel';

require_once __DIR__ . '/includes/auth.php';
requireLogin();



$userRole = getCurrentUserRole();
if ($userRole && $userRole !== 'admin') {
    redirectByRole(); 
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$currentUser = getCurrentUser();
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">خوش آمدید <span class="np-gradient-text"><?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?></span></h2>
                <p class="geex-content__header__subtitle">پنل مدیریت NextPixel</p>
            </div>
            
            <div class="geex-content__header__action">
                <div class="geex-content__header__customizer">
                    <button class="geex-btn geex-btn__toggle-sidebar">   
                        <i class="uil uil-align-center-alt"></i> 
                    </button>
                </div> 
                <div class="geex-content__header__action__wrap">
                    <ul class="geex-content__header__quickaction">
                        <li class="geex-content__header__quickaction__item">
                            <a href="/panel/auth/logout.php" class="geex-content__header__quickaction__link">
                                <i class="uil uil-signout"></i>
                                <span>خروج</span>
                            </a>
                        </li>
                        <li class="geex-content__header__quickaction__item">
                            <a href="#" class="geex-content__header__quickaction__link">
                                <img class="user-img" src="/panel/assets/img/avatar/user.svg" alt="user" />
                            </a>
                            <div class="geex-content__header__popup geex-content__header__popup--author">
                                <div class="geex-content__header__popup__header">
                                    <div class="geex-content__header__popup__header__img">
                                        <img src="/panel/assets/img/avatar/user.svg" alt="user" />
                                    </div>
                                    <div class="geex-content__header__popup__header__content">
                                        <h3 class="geex-content__header__popup__header__title"><?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?></h3>
                                        <span class="geex-content__header__popup__header__subtitle"><?php echo ucfirst($currentUser['role']); ?></span>
                                    </div>
                                </div>
                                <div class="geex-content__header__popup__content">
                                    <ul class="geex-content__header__popup__items">
                                        <li class="geex-content__header__popup__item">
                                            <a class="geex-content__header__popup__link" href="/panel/profile.php">
                                                <i class="uil uil-user"></i>
                                                مشخصات
                                            </a>
                                        </li>
                                        <li class="geex-content__header__popup__item">
                                            <a class="geex-content__header__popup__link" href="/panel/settings.php">
                                                <i class="uil uil-cog"></i>
                                                تنظیمات
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="geex-content__header__popup__footer">
                                    <a href="/panel/auth/logout.php" class="geex-content__header__popup__footer__link">
                                        <i class="uil uil-arrow-up-left"></i>خارج شدن
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> 
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__feature mb-40">
                    <div class="geex-content__feature__card">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">وضعیت</p>
                            <h4 class="geex-content__feature__card__title np-gradient-text">فعال</h4>
                            <span class="geex-content__feature__card__badge">آنلاین</span>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <i class="uil uil-check-circle" style="font-size: 48px; color: #10b981;"></i>
                        </div>
                    </div>
                    <div class="geex-content__feature__card">
                        <div class="geex-content__feature__card__text">
                            <p class="geex-content__feature__card__subtitle">نقش شما</p>
                            <h4 class="geex-content__feature__card__title"><?php echo ucfirst($userRole); ?></h4>
                        </div>
                        <div class="geex-content__feature__card__img">
                            <i class="uil uil-user-circle" style="font-size: 48px; color: #3b82f6;"></i>
                        </div>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">پنل مدیریت NextPixel</h4>
                        <p class="geex-content__section__header__subtitle">سیستم مدیریت یکپارچه پروژه‌های طراحی وب</p>
                    </div>
                    <div class="geex-content__section__content">
                        <p>به پنل مدیریت NextPixel خوش آمدید. از منوی سمت راست می‌توانید به بخش‌های مختلف دسترسی پیدا کنید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


