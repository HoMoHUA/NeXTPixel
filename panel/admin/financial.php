<?php


$pageTitle = 'داشبورد مالی - NextPixel';
$currentPage = 'financial';

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
                    <span class="np-gradient-text">داشبورد مالی</span>
                </h2>
                <p class="geex-content__header__subtitle">مدیریت و نظارت بر امور مالی</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="geex-content__double-column mb-40">
                    <div class="geex-content__section geex-content__income-count">
                        <div class="geex-content__section__header">
                            <div class="geex-content__section__header__title-part">
                                <h4 class="geex-content__section__header__title">درآمد</h4>
                            </div>
                        </div>
                        <div class="geex-content__section__content">
                            <div class="geex-content__section__content__top">
                                <div class="geex-content__section__content__top__left">
                                    <h4 class="geex-content__section__content__amount increment">
                                        <i class="uil uil-angle-up"></i>
                                        +4,6%
                                    </h4>
                                    <p class="geex-content__section__content__subtitle">بزرگتر از هفته گذشته</p>
                                </div>
                                <div class="geex-content__section__content__top__right">
                                    <h4 class="geex-content__section__content__price">146,196,000 <small>تومان</small></h4>
                                </div>
                            </div>
                            <div id="income-chart" class="column-chart"></div>
                        </div>
                    </div>
                    <div class="geex-content__section geex-content__expense-count">
                        <div class="geex-content__section__header">
                            <div class="geex-content__section__header__title-part">
                                <h4 class="geex-content__section__header__title">هزینه</h4>
                            </div>
                        </div>
                        <div class="geex-content__section__content">
                            <div class="geex-content__section__content__top">
                                <div class="geex-content__section__content__top__left">
                                    <h4 class="geex-content__section__content__amount decrement">
                                        <i class="uil uil-angle-down"></i>
                                        -2.5%
                                    </h4>
                                    <p class="geex-content__section__content__subtitle">بزرگتر از هفته گذشته</p>
                                </div>
                                <div class="geex-content__section__content__top__right">
                                    <h4 class="geex-content__section__content__price">74,586,000 <small>تومان</small></h4>
                                </div>
                            </div>
                            <div id="expense-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="geex-content__section geex-content__transaction">
                    <div class="geex-content__section__header">
                        <div class="geex-content__section__header__title-part">
                            <h4 class="geex-content__section__header__title">همه تراکنش‌ها</h4>
                        </div>
                    </div>
                    <div class="geex-content__section__content">
                        <div class="transaction-content">
                            <div class="transaction-type">
                                <div class="transaction-type__single decrement">
                                    <div class="transaction-type__single__icon">
                                        <i class="uil uil-arrow-down"></i>
                                    </div>
                                    <div class="transaction-type__single__content">
                                        <h4 class="transaction-type__single__content__title">انتقال پی پال</h4>
                                        <p class="transaction-type__single__content__subtitle">24 نوامبر 2020 ساعت 2:45 ق.ظ</p>
                                    </div>
                                </div>
                                <div class="transaction-type__single increment">
                                    <div class="transaction-type__single__icon">
                                        <i class="uil uil-arrow-up"></i>
                                    </div>
                                    <div class="transaction-type__single__content">
                                        <h4 class="transaction-type__single__content__title">حواله بانکی</h4>
                                        <p class="transaction-type__single__content__subtitle">5 سپتامبر 2020 در 11:56 ق.ظ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="geex-content__widget">
                <div class="geex-content__widget__single mb-20">
                    <div class="geex-content__widget__single__mastercard">
                        <div class="geex-content__widget__single__mastercard__top">
                            <div class="single-content mb-30">
                                <div class="geex-content__widget__single__mastercard__top__content">
                                    <p class="geex-content__widget__single__mastercard__top__subtitle">موجودی شما</p>
                                    <h2 class="geex-content__widget__single__mastercard__top__title">876,525,000 <small>تومان</small></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    if (typeof ApexCharts !== 'undefined' && document.getElementById('income-chart')) {
        var incomeOptions = {
            series: [{
                name: 'درآمد',
                data: [30, 40, 35, 50, 49, 60, 70]
            }],
            chart: {
                type: 'area',
                height: 200,
                toolbar: { show: false }
            },
            colors: ['#10b981'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: { categories: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'] }
        };
        new ApexCharts(document.querySelector("#income-chart"), incomeOptions).render();
    }

    
    if (typeof ApexCharts !== 'undefined' && document.getElementById('expense-chart')) {
        var expenseOptions = {
            series: [{
                name: 'هزینه',
                data: [20, 30, 25, 40, 35, 50, 45]
            }],
            chart: {
                type: 'area',
                height: 200,
                toolbar: { show: false }
            },
            colors: ['#ef4444'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: { categories: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'] }
        };
        new ApexCharts(document.querySelector("#expense-chart"), expenseOptions).render();
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


