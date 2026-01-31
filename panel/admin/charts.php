<?php


$pageTitle = 'نمودارها - NextPixel';
$currentPage = 'charts';

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
                    <span class="np-gradient-text">نمودارها</span>
                </h2>
                <p class="geex-content__header__subtitle">نمودارهای آماری و تحلیلی</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                <div class="row">
                    <div class="col-lg-6 mb-40">
                        <div class="geex-content__section geex-content__server-request">
                            <div class="geex-content__section__header">
                                <div class="geex-content__section__header__title-part">
                                    <h4 class="geex-content__section__header__title">درخواست سرور</h4>
                                </div>
                            </div>
                            <div class="geex-content__section__content">
                                <div id="line-chart" class="server-request-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-40">
                        <div class="geex-content__section">
                            <div id="stack-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 md-mb-40">
                        <div class="geex-content__section geex-content__visitor-count">
                            <div class="geex-content__section__header">
                                <div class="geex-content__section__header__title-part">
                                    <h4 class="geex-content__section__header__title">بازدیدکنندگان</h4>
                                </div>
                            </div>
                            <div class="geex-content__section__content">
                                <div class="geex-content__visitor-count__number">
                                    <h2 class="geex-content__visitor-count__number__title">98,425k</h2>
                                    <div class="geex-content__visitor-count__number__text">
                                        <span class="geex-content__visitor-count__number__subtitle">+2.5%</span>
                                    </div>
                                </div>
                                <div id="visitor-chart"></div>
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
    if (typeof ApexCharts !== 'undefined') {
        
        if (document.getElementById('line-chart')) {
            var lineOptions = {
                series: [{
                    name: 'درخواست',
                    data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: { show: false }
                },
                colors: ['#3b82f6'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'] }
            };
            new ApexCharts(document.querySelector("#line-chart"), lineOptions).render();
        }

        
        if (document.getElementById('stack-chart')) {
            var stackOptions = {
                series: [{
                    name: 'سری 1',
                    data: [44, 55, 41, 67, 22, 43]
                }, {
                    name: 'سری 2',
                    data: [13, 23, 20, 8, 13, 27]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: { show: false }
                },
                colors: ['#3b82f6', '#8b5cf6']
            };
            new ApexCharts(document.querySelector("#stack-chart"), stackOptions).render();
        }

        
        if (document.getElementById('visitor-chart')) {
            var visitorOptions = {
                series: [75],
                chart: {
                    type: 'radialBar',
                    height: 200
                },
                colors: ['#10b981'],
                plotOptions: {
                    radialBar: {
                        hollow: { size: '70%' }
                    }
                }
            };
            new ApexCharts(document.querySelector("#visitor-chart"), visitorOptions).render();
        }
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


