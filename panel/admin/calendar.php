<?php

$pageTitle = 'تقویم - NextPixel';
$currentPage = 'calendar';

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
                    <span class="np-gradient-text">تقویم</span>
                </h2>
                <p class="geex-content__header__subtitle">مدیریت رویدادها و قرارها</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section geex-content__section--transparent geex-content__calendar">
                    <button class="geex-btn geex-content__calendar__toggle">
                        <i class="uil-bars"></i> Event List
                    </button>
                    <div class="geex-content__calendar__sidebar">
                        <div class="geex-content__calendar__sidebar__header">
                            <button class="geex-btn geex-btn--primary geex-btn__add-modal">
                                <i class="uil-plus"></i> رویداد جدید
                            </button>
                        </div>

                        <div class="geex-content__calendar__sidebar__meeting">
                            <span class="geex-content__calendar__sidebar__meeting__label">برنامه امروز من</span>
                            <div class="geex-content__calendar__sidebar__meeting__single">
                                <div class="geex-content__calendar__sidebar__meeting__single__text">
                                    <h4 class="geex-content__calendar__sidebar__meeting__single__title">جلسه هفتگی مشتری</h4>
                                    <span class="geex-content__calendar__sidebar__meeting__single__time">09:00 صبح - 10:00 صبح</span>
                                </div>
                                <div class="geex-content__calendar__sidebar__meeting__single__tag">
                                    <a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item danger">
                                        فوری
                                    </a>
                                    <a href="#" class="geex-content__calendar__sidebar__meeting__single__tag__item success">
                                        چهره به چهره
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {

    console.log('Calendar initialized');
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

