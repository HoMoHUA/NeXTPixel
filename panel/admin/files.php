<?php

$pageTitle = 'مدیریت فایل - NextPixel';
$currentPage = 'files';

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
                    <span class="np-gradient-text">مدیریت فایل</span>
                </h2>
                <p class="geex-content__header__subtitle">مدیریت و سازماندهی فایل‌ها</p>
            </div>
            <div class="geex-content__header__action">
                <button class="geex-btn geex-btn--primary" onclick="document.getElementById('file-upload').click()">
                    <i class="uil uil-upload"></i>
                    آپلود فایل
                </button>
                <input type="file" id="file-upload" style="display: none;" multiple>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="row g-4">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="single-feature-card-area-start">
                            <div class="top-feature-wrapper">
                                <div class="icon">
                                    <img src="/panel/assets/img/feature/01.png" alt="feature">
                                </div>
                                <div class="information">
                                    <span>ذخیره سازی</span>
                                    <h5 class="title">دراپ باکس</h5>
                                </div>
                            </div>
                            <div class="space">120Gb / 250Gb</div>
                            <div id="chart-5"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="single-feature-card-area-start">
                            <div class="top-feature-wrapper">
                                <div class="icon">
                                    <img src="/panel/assets/img/feature/02.png" alt="feature">
                                </div>
                                <div class="information">
                                    <span>ذخیره سازی</span>
                                    <h5 class="title">گوگل درایو</h5>
                                </div>
                            </div>
                            <div class="space">120Gb / 250Gb</div>
                            <div id="chart-6"></div>
                        </div>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">فایل‌های اخیر</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <div class="geex-table-wrapper">
                            <table class="geex-table">
                                <thead>
                                    <tr>
                                        <th>نام فایل</th>
                                        <th>نوع</th>
                                        <th>حجم</th>
                                        <th>تاریخ</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>document.pdf</td>
                                        <td>PDF</td>
                                        <td>2.5 MB</td>
                                        <td>1403/10/15</td>
                                        <td>
                                            <a href="#" class="geex-btn geex-btn--sm geex-btn--info">
                                                <i class="uil uil-download"></i>
                                            </a>
                                            <a href="#" class="geex-btn geex-btn--sm geex-btn--danger">
                                                <i class="uil uil-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof ApexCharts !== 'undefined') {
        
        if (document.getElementById('chart-5')) {
            var chart5Options = {
                series: [48],
                chart: {
                    type: 'radialBar',
                    height: 150
                },
                colors: ['#3b82f6']
            };
            new ApexCharts(document.querySelector("#chart-5"), chart5Options).render();
        }

        if (document.getElementById('chart-6')) {
            var chart6Options = {
                series: [65],
                chart: {
                    type: 'radialBar',
                    height: 150
                },
                colors: ['#10b981']
            };
            new ApexCharts(document.querySelector("#chart-6"), chart6Options).render();
        }
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

