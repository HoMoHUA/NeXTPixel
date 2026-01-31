<?php


$pageTitle = 'جداول - NextPixel';
$currentPage = 'tables';

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
                    <span class="np-gradient-text">جداول</span>
                </h2>
                <p class="geex-content__header__subtitle">جداول اطلاعات و داده‌ها</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__section geex-content__form table-responsive">
                    <table class="table-reviews-geex-1">
                        <thead>
                            <tr style="width: 100%;">
                                <th style="width: 20%;">نام</th>
                                <th style="width: 20%;">تعیین</th>
                                <th style="width: 20%;">شرکت</th>
                                <th style="width: 20%;">شماره همراه</th>
                                <th style="width: 20%;">ایمیل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="author-area">
                                        <div class="profile-picture">
                                            <img src="/panel/assets/img/contact/01.png" alt="بررسی ها">
                                        </div>
                                        <p>دیوید میلار</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="designation">(مدیر عامل)*</span>
                                </td>
                                <td>
                                    <span class="name">رکتمز</span>
                                </td>
                                <td><a href="tel:+4733378901">09123456789</a></td>
                                <td><a href="mailto:webmaster@example.com">millar@mail.com</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="author-area">
                                        <div class="profile-picture">
                                            <img src="/panel/assets/img/contact/02.png" alt="بررسی ها">
                                        </div>
                                        <p>برایان فافر</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="designation">(مدیر فنی)*</span>
                                </td>
                                <td>
                                    <span class="name">تکنولوژی</span>
                                </td>
                                <td><a href="tel:+4733378901">09123456790</a></td>
                                <td><a href="mailto:webmaster@example.com">favor@mail.com</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


