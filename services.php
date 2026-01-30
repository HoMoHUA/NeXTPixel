<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';
$isN8NAdmin = $isLoggedIn; 
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwind.min.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/anime.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
>>>>>>> Stashed changes

    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwind.min.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/anime.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
</head>
<body class="overflow-x-hidden">
    
    <svg style="position: absolute; width: 0; height: 0;">
      <defs>
        <filter id="liquid-glass-filter" color-interpolation-filters="sRGB">
          <feImage href="data:image/svg+xml,%0A%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='512' height='512' filter='url(%23noise)'/%3E%3C/svg%3E" x="0" y="0" width="100%" height="100%" result="map"></feImage>
          <feDisplacementMap in="SourceGraphic" in2="map" scale="15" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
          <feGaussianBlur in="SourceGraphic" stdDeviation="4"></feGaussianBlur>
        </filter>
      </defs>
    </svg>

    <nav class="ios-glass-header sticky top-0 z-50 flex justify-between items-center py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
        <div class="text-2xl font-bold text-white flex items-center">
             <a href="index.php" class="gradient-text font-bold">NextPixel</a>
        </div>
        <div class="hidden md:flex items-center space-x-6 space-x-reverse">
            <a href="index.php" class="hover:text-blue-400 transition">صفحه اصلی</a>
            <a href="about.php" class="hover:text-blue-400 transition">درباره ما</a>
            <a href="portfolio.php" class="hover:text-blue-400 transition">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition">تماس با ما</a>
            <a href="services.php" class="text-blue-400 font-medium">خدمات</a>
            
            <?php if ($isLoggedIn): ?>
                <?php if ($isN8NAdmin): ?>
                    <a href="n8n-admin.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full font-medium transition-all text-sm">
                        <i data-feather="zap" class="w-4 h-4 inline ml-1"></i>
                        مدیریت n8n
                    </a>
                <?php endif; ?>
                <a href="admin/" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full font-medium transition-all text-sm">
                    <?php echo htmlspecialchars($username); ?> (پنل)
                </a>
            <?php else: ?>
                <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-medium transition-all text-sm">
                    ورود
                </a>
            <?php endif; ?>
        </div>
        <button id="menu-btn" class="md:hidden z-50">
            <i data-feather="menu" class="text-white w-7 h-7"></i>
        </button>
    </nav>

    <div id="mobile-menu" class="fixed inset-0 bg-slate-900/90 glass-effect z-40 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="flex flex-col items-center justify-center h-full space-y-8 text-2xl font-medium">
             <a href="index.php" class="hover:text-blue-400 transition text-white">صفحه اصلی</a>
             <a href="about.php" class="hover:text-blue-400 transition text-white">درباره ما</a>
             <a href="portfolio.php" class="hover:text-blue-400 transition text-white">نمونه کارها</a>
             <a href="contact.php" class="hover:text-amber-400 transition text-white">تماس با ما</a>
             <a href="services.php" class="text-blue-400 font-medium">خدمات</a>
             
             <?php if ($isLoggedIn): ?>
                 <?php if ($isN8NAdmin): ?>
                     <a href="n8n-admin.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full text-xl transition-all mb-4">
                         مدیریت n8n
                     </a>
                 <?php endif; ?>
                 <a href="admin/" class="cta-button text-white px-6 py-3 rounded-full text-xl">
                     پنل کاربری (<?php echo htmlspecialchars($username); ?>)
                 </a>
             <?php else: ?>
                 <a href="login.php" class="cta-button text-white px-6 py-3 rounded-full text-xl">
                     ورود اعضا
                 </a>
             <?php endif; ?>
        </div>
    </div>

    <section class="hero-gradient flex items-center justify-center relative overflow-hidden py-20 px-4">
        <div class="container mx-auto z-20 relative">
            <div class="text-center max-w-5xl mx-auto pt-20 pb-20" data-aos="fade-up">
                <h1 class="hero-title mb-6 text-white leading-tight">
                    قدرت فروشگاه خود را<br>
                    <span class="gradient-text">کاملاً خودکار</span> کنید
                </h1>
                <p class="hero-subtitle mb-12 max-w-2xl mx-auto text-white">
                    NextPixel موتور پیشنهاد هوشمند خودکار شماست که هر تعامل مشتری را به درآمد تبدیل می‌کند
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#wordpress-content" class="hero-cta-primary text-white px-8 py-4 rounded-full font-bold text-base sm:text-lg min-w-[180px] sm:min-w-[200px] text-center">
                        مشاهده خدمات
                    </a>
                    <a href="contact.php" class="hero-cta-secondary text-white px-8 py-4 rounded-full font-bold text-base sm:text-lg min-w-[180px] sm:min-w-[200px] text-center">
                        مشاوره رایگان
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="container mx-auto px-4">
            <div class="glass-effect p-2 rounded-full flex justify-center items-center gap-2 max-w-4xl mx-auto flex-wrap" data-aos="fade-up">
                <button data-target="wordpress-content" class="tab-btn flex-1 py-3 px-4 rounded-full font-bold text-sm md:text-lg active min-w-[120px]">سایت وردپرسی</button>
                <button data-target="custom-content" class="tab-btn flex-1 py-3 px-4 rounded-full font-bold text-sm md:text-lg min-w-[120px]">برنامه نویسی اختصاصی</button>
                <button data-target="n8n-content" class="tab-btn flex-1 py-3 px-4 rounded-full font-bold text-sm md:text-lg min-w-[120px]">اتوماسیون n8n</button>
                <button data-target="seo-content" class="tab-btn flex-1 py-3 px-4 rounded-full font-bold text-sm md:text-lg min-w-[120px]">سئوی اختصاصی</button>
                <button data-target="chatbot-content" class="tab-btn flex-1 py-3 px-4 rounded-full font-bold text-sm md:text-lg min-w-[120px]">چت بات هوشمند</button>
            </div>
        </div>
    </section>

    <div id="wordpress-content" class="tab-content active">
        
        <section class="service-hero-section py-24 bg-gradient-to-b from-slate-900/40 via-blue-900/10 to-slate-900/40">
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-16" data-aos="fade-up">
                    <div class="inline-block mb-6">
                        <div class="service-icon-large bg-gradient-to-br from-blue-500/20 to-purple-500/20 mx-auto border-2 border-blue-500/30">
                            <i data-feather="layout" class="w-12 h-12 text-blue-400"></i>
                        </div>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-6">
                        طراحی سایت <span class="gradient-text">وردپرسی</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        با قدرتمندترین سیستم مدیریت محتوا، وبسایت خود را در سریع‌ترین زمان ممکن راه‌اندازی کنید
                    </p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                    <div data-aos="fade-right">
                        <div class="service-stats justify-start">
                            <div class="stat-item relative">
                                <div class="service-number-badge">۱</div>
                                <div class="stat-number text-4xl">۴۰٪+</div>
                                <div class="text-gray-300 text-base mt-2 font-medium">از وبسایت‌های جهان</div>
                            </div>
                            <div class="stat-item relative">
                                <div class="service-number-badge">۲</div>
                                <div class="stat-number text-4xl">۵۰K+</div>
                                <div class="text-gray-300 text-base mt-2 font-medium">افزونه رایگان</div>
                            </div>
                            <div class="stat-item relative">
                                <div class="service-number-badge">۳</div>
                                <div class="stat-number text-4xl">۱۰۰٪</div>
                                <div class="text-gray-300 text-base mt-2 font-medium">سفارشی‌سازی</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                        <div class="service-feature-card card-float p-6 rounded-xl relative" data-aos="fade-up" data-aos-delay="50">
                            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center mb-4">
                                <i data-feather="zap" class="w-6 h-6 text-yellow-400"></i>
                            </div>
                            <h3 class="font-bold mb-2 text-lg">راه‌اندازی سریع</h3>
                            <p class="text-sm text-gray-400">سایت شما در کمتر از یک هفته آماده می‌شود</p>
                            <span class="mini-badge">زمان تحویل ۷ روزه</span>
                        </div>
                        <div class="service-feature-card card-float p-6 rounded-xl relative" data-aos="fade-up" data-aos-delay="100">
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4">
                                <i data-feather="shield" class="w-6 h-6 text-green-400"></i>
                            </div>
                            <h3 class="font-bold mb-2 text-lg">امنیت بالا</h3>
                            <p class="text-sm text-gray-400">به‌روزرسانی‌های امنیتی منظم</p>
                            <span class="mini-badge">پشتیبانی امنیتی</span>
                        </div>
                        <div class="service-feature-card card-float p-6 rounded-xl relative" data-aos="fade-up" data-aos-delay="150">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4">
                                <i data-feather="smartphone" class="w-6 h-6 text-blue-400"></i>
                            </div>
                            <h3 class="font-bold mb-2 text-lg">ریسپانسیو</h3>
                            <p class="text-sm text-gray-400">سازگار با تمام دستگاه‌ها</p>
                            <span class="mini-badge">Mobile First</span>
                        </div>
                        <div class="service-feature-card card-float p-6 rounded-xl relative" data-aos="fade-up" data-aos-delay="200">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                                <i data-feather="trending-up" class="w-6 h-6 text-purple-400"></i>
                            </div>
                            <h3 class="font-bold mb-2 text-lg">سئو محور</h3>
                            <p class="text-sm text-gray-400">بهینه برای موتورهای جستجو</p>
                            <span class="mini-badge">Core Web Vitals</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 pb-20">
            <div class="container mx-auto px-4">
                 <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">پلن‌های طراحی سایت وردپرسی</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">راهکارهای بهینه و سریع برای حضور آنلاین شما با قدرتمندترین سیستم مدیریت محتوا.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="plan-card p-6 rounded-2xl flex flex-col magnetic-hover float-animation" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">Pixel One (نرمال)</h3>
                            <p class="text-sm text-gray-400 mb-4">برای شروع کسب و کارها</p>
                            <div class="price-display">۸,۷۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی وبسایت با قالب آماده حرفه‌ای</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>دامنه .IR رایگان (۱ ساله)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هاست رایگان ۱ ماهه (سرور ایرانی)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>نصب و راه‌اندازی کامل وردپرس</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی برای موبایل (ریسپانسیو)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئو بیسیک (بهینه‌سازی اولیه)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>آموزش کار با پنل مدیریت</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی فنی ۱ ماهه رایگان</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>اتصال به شبکه‌های اجتماعی</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col magnetic-hover float-animation float-animation-delay-1" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">Pixel Grow (پرو)</h3>
                            <p class="text-sm text-gray-400 mb-4">برای کسب و کارهای در حال رشد</p>
                            <div class="price-display">۱۶,۲۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی وبسایت فروشگاهی/خدماتی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بازطراحی و سفارشی‌سازی قالب</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>دامنه .IR و .COM رایگان (۱ ساله)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هاست رایگان ۳ ماهه (سرور پرسرعت)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئو پیشرفته + بهینه‌سازی سرعت</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی صفحه محصولات/خدمات</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>نصب افزونه‌های ضروری (ووکامرس/ویری)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی UX/UI برای تبدیل بیشتر</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی فنی ۲ ماهه رایگان</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>اتصال به شبکه‌های اجتماعی</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card popular-plan p-6 rounded-2xl flex flex-col magnetic-hover float-animation float-animation-delay-2" data-aos="fade-up" data-aos-delay="300">
                         <div class="relative text-center mb-6">
                            <div class="absolute -top-10 right-1/2 transform translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                                    محبوب‌ترین
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 pt-2">Pixel Pro (پرو مکس)</h3>
                            <p class="text-sm text-gray-400 mb-4">بهترین انتخاب برای بهترین‌ها</p>
                            <div class="price-display">۲۵,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>فروشگاه پیشرفته / پلتفرم خدماتی کامل</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی صفر تا صد UI/UX اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هاست رایگان ۶ ماهه (سرور اختصاصی)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>دامنه .IR و .COM رایگان (۱ ساله)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئو پیشرفته + استراتژی محتوا</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به شبکه‌های اجتماعی (اینستاگرام، تلگرام)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سیستم پرداخت آنلاین (درگاه‌های معتبر)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی صفحه فرود (Landing Page) اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی Core Web Vitals</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی فنی ۴ ماهه رایگان</span></li>
                        </ul>
                        <button class="w-full mt-auto cta-button text-white py-3 rounded-lg font-medium">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">Infinity Pixel (الترا مکس)</h3>
                             <p class="text-sm text-gray-400 mb-4">راه حل جامع و نامحدود</p>
                            <div class="price-display !text-2xl">تماس بگیرید</div>
                            <p class="text-gray-400 text-sm">برای دریافت قیمت سفارشی</p>
                        </div>
                         <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پلتفرم اختصاصی شما (وردپرس سفارشی)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی صفر تا صد VIP با تیم اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تعداد صفحات و محصولات نامحدود</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هاست رایگان ۱ ساله (سرور اختصاصی پرسرعت)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئو کامل + استراتژی محتوای بلندمدت</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به تمام شبکه‌های اجتماعی و پیام‌رسان‌ها</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سیستم مدیریت سفارشات پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی کامل سرعت و عملکرد</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی چندزبانه (در صورت نیاز)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی فنی ۶ ماهه VIP رایگان</span></li>
                        </ul>
                        <a href="contact.php" class="w-full mt-auto text-center bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">درخواست مشاوره</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-slate-900/50 to-slate-900/20" id="custom-plan-wordpress">
             <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">پلن سفارشی وردپرس</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">پلن خود را بر اساس نیازهای خاص کسب و کارتان تنظیم کنید</p>
                </div>
                 <div class="glass-effect rounded-2xl p-8 md:p-12" data-aos="fade-up">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-8" id="wordpress-calculator-inputs">
                            <h3 class="text-2xl font-bold gradient-text">تنظیمات پلن</h3>
                            
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="text-center mb-8 glass-effect p-8 rounded-2xl sticky top-28">
                                <h3 class="text-2xl font-bold mb-4">قیمت نهایی</h3>
                                <div id="wp-final-price" class="price-display text-5xl mb-2">۰</div>
                                <p class="text-gray-400">تومان</p>
                            </div>
                             <div class="space-y-4 mt-auto">
                                <button class="w-full cta-button text-white py-4 rounded-lg font-medium text-lg">درخواست مشاوره رایگان</button>
                                <button id="generate-wp-proposal-btn" class="w-full border-2 border-purple-500 text-purple-300 font-bold py-3 rounded-lg hover:bg-purple-500/20 transition-all flex items-center justify-center">
                                    ✨ دریافت پیشنهاد هوشمند
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="custom-content" class="tab-content">
        
        <section class="service-hero-section py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-slate-900/50 to-blue-900/30"></div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-20" data-aos="fade-up">
                    <div class="inline-block mb-8">
                        <div class="service-icon-large bg-gradient-to-br from-purple-500/30 to-pink-500/30 mx-auto border-2 border-purple-500/40">
                            <i data-feather="code" class="w-12 h-12 text-purple-400"></i>
                        </div>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-6">
                        برنامه نویسی <span class="gradient-text">اختصاصی</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8 leading-relaxed">
                        راهکارهای قدرتمند و مقیاس‌پذیر با کدنویسی سفارشی برای نیازهای منحصر به فرد شما
                    </p>
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-purple-500/20 rounded-full border border-purple-500/30">
                        <i data-feather="sparkles" class="w-5 h-5 text-purple-400"></i>
                        <span class="text-purple-300 font-medium">از API تا اپلیکیشن‌های کامل</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-right" data-aos-delay="80">
                        <div class="absolute top-4 right-4 w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-blue-400 text-xs font-bold">01</span>
                        </div>
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30">
                            <i data-feather="server" class="w-10 h-10 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Backend Development</h3>
                        <p class="text-gray-400 leading-relaxed">API های RESTful و GraphQL، معماری میکروسرویس، و سیستم‌های مقیاس‌پذیر</p>
                        <div class="mt-6 pt-6 border-t border-slate-700 flex flex-col gap-2">
                            <span class="text-sm text-blue-400 font-medium">Node.js • Python • PHP</span>
                            <span class="mini-badge">Scalable APIs</span>
                        </div>
                    </div>
                    <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-up" data-aos-delay="140">
                        <div class="absolute top-4 right-4 w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-purple-400 text-xs font-bold">02</span>
                        </div>
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-purple-500/30">
                            <i data-feather="monitor" class="w-10 h-10 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Frontend Development</h3>
                        <p class="text-gray-400 leading-relaxed">React، Vue، Next.js و رابط‌های کاربری مدرن و تعاملی</p>
                        <div class="mt-6 pt-6 border-t border-slate-700 flex flex-col gap-2">
                            <span class="text-sm text-purple-400 font-medium">React • Vue • Next.js</span>
                            <span class="mini-badge">UX Focused</span>
                        </div>
                    </div>
                    <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-left" data-aos-delay="200">
                        <div class="absolute top-4 right-4 w-8 h-8 bg-pink-500/20 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-pink-400 text-xs font-bold">03</span>
                        </div>
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-pink-500/30">
                            <i data-feather="smartphone" class="w-10 h-10 text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Mobile Backend</h3>
                        <p class="text-gray-400 leading-relaxed">API های اختصاصی برای اپلیکیشن‌های موبایل iOS و Android</p>
                        <div class="mt-6 pt-6 border-t border-slate-700 flex flex-col gap-2">
                            <span class="text-sm text-pink-400 font-medium">REST API • GraphQL</span>
                            <span class="mini-badge">Low latency</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 pb-20">
            <div class="container mx-auto px-4">
                 <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">پلن‌های برنامه نویسی اختصاصی</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">راهکارهای قدرتمند و مقیاس‌پذیر با کدنویسی سفارشی برای نیازهای منحصر به فرد شما.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">پایه بک‌اند</h3>
                            <p class="text-sm text-gray-400 mb-4">برای MVP و وب اپلیکیشن‌های کوچک</p>
                            <div class="price-display">۱۵,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>توسعه API (RESTful)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی دیتابیس (MySQL/PostgreSQL)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سیستم احراز هویت کاربران</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به CMS headless</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>ویژگی‌های Real-time</span></li>
                             <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>فرانت‌اند اختصاصی</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card popular-plan p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="200">
                        <div class="relative text-center mb-6">
                            <div class="absolute -top-10 right-1/2 transform translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                                    پیشنهادی
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 pt-2">پیشرفته بک‌اند</h3>
                            <p class="text-sm text-gray-400 mb-4">برای اپلیکیشن‌های مقیاس‌پذیر</p>
                            <div class="price-display">۳۰,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پایه</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>معماری مقیاس‌پذیر</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ویژگی‌های Real-time (WebSockets)</span></li>
                             <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>امنیت پیشرفته (OAuth2)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>راه اندازی CI/CD</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>فرانت‌اند اختصاصی</span></li>
                        </ul>
                        <button class="w-full mt-auto cta-button text-white py-3 rounded-lg font-medium">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">جامع فول‌استک</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار کامل نرم‌افزاری</p>
                            <div class="price-display">۵۰,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>فرانت‌اند اختصاصی (React / Vue)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پیاده‌سازی کامل UI/UX</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی عملکرد (SSR/SSG)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تست End-to-End</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">راهکار سازمانی</h3>
                             <p class="text-sm text-gray-400 mb-4">برای سیستم‌های بزرگ و پیچیده</p>
                            <div class="price-display !text-2xl">تماس بگیرید</div>
                            <p class="text-gray-400 text-sm">برای دریافت پروپوزال فنی</p>
                        </div>
                         <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>معماری میکروسرویس</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>زیرساخت ابری اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>Load Balancing و High Availability</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مشاوره و راهبری فنی</span></li>
                             <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی و نگهداری بلندمدت</span></li>
                        </ul>
                        <a href="contact.php" class="w-full mt-auto text-center bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">درخواست مشاوره</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-slate-900/50 to-slate-900/20" id="custom-plan-coding">
             <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">پلن سفارشی برنامه نویسی</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">نیازمندی‌های فنی پروژه خود را مشخص کنید تا برآورد هزینه دریافت کنید.</p>
                </div>
                 <div class="glass-effect rounded-2xl p-8 md:p-12" data-aos="fade-up">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-8" id="coding-calculator-inputs">
                             <h3 class="text-2xl font-bold gradient-text">مشخصات فنی پروژه</h3>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="text-center mb-8 glass-effect p-8 rounded-2xl sticky top-28">
                                <h3 class="text-2xl font-bold mb-4">برآورد هزینه</h3>
                                <div id="coding-final-price" class="price-display text-5xl mb-2">۰</div>
                                <p class="text-gray-400">تومان</p>
                            </div>
                             <div class="space-y-4 mt-auto">
                                <button class="w-full cta-button text-white py-4 rounded-lg font-medium text-lg">درخواست مشاوره فنی</button>
                                <button id="generate-custom-proposal-btn" class="w-full border-2 border-purple-500 text-purple-300 font-bold py-3 rounded-lg hover:bg-purple-500/20 transition-all flex items-center justify-center">
                                    ✨ دریافت طرح اولیه فنی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="n8n-content" class="tab-content">
        
        <section class="service-hero-section py-24 bg-gradient-to-b from-green-900/20 via-slate-900/50 to-blue-900/20">
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-16" data-aos="fade-up">
                        <div class="inline-block mb-8">
                            <div class="service-icon-large bg-gradient-to-br from-green-500/30 to-emerald-500/30 mx-auto border-2 border-green-500/40">
                                <i data-feather="zap" class="w-12 h-12 text-green-400"></i>
                            </div>
                        </div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-6">
                            اتوماسیون <span class="gradient-text">n8n</span>
                        </h2>
                        <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed">
                            فرآیندهای کسب و کار خود را بدون نیاز به کدنویسی خودکار کنید
                        </p>
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-green-500/20 rounded-full border border-green-500/30">
                            <i data-feather="zap" class="w-5 h-5 text-green-400"></i>
                            <span class="text-green-300 font-medium">قدرتمندترین پلتفرم workflow</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        <div class="service-feature-card card-float p-8 rounded-xl relative group" data-aos="fade-right" data-aos-delay="60">
                            <div class="absolute top-4 left-4 w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-green-400 text-lg font-bold">1</span>
                            </div>
                            <div class="flex items-start gap-4 pt-8">
                                <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="refresh-cw" class="w-7 h-7 text-green-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2 text-lg">همگام‌سازی خودکار</h3>
                                    <p class="text-gray-400 leading-relaxed">داده‌های شما بین تمام سیستم‌ها به صورت خودکار همگام می‌شود</p>
                                    <div class="mt-3"><span class="mini-badge">Zero Touch</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="service-feature-card card-float p-8 rounded-xl relative group" data-aos="fade-left" data-aos-delay="120">
                            <div class="absolute top-4 left-4 w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-blue-400 text-lg font-bold">2</span>
                            </div>
                            <div class="flex items-start gap-4 pt-8">
                                <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="link" class="w-7 h-7 text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2 text-lg">اتصال به ۴۰۰+ سرویس</h3>
                                    <p class="text-gray-400 leading-relaxed">از CRM تا شبکه‌های اجتماعی، همه چیز را به هم متصل کنید</p>
                                    <div class="mt-3"><span class="mini-badge">400+ Integrations</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="service-feature-card card-float p-8 rounded-xl relative group" data-aos="fade-right" data-aos-delay="180">
                            <div class="absolute top-4 left-4 w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-purple-400 text-lg font-bold">3</span>
                            </div>
                            <div class="flex items-start gap-4 pt-8">
                                <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="clock" class="w-7 h-7 text-purple-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2 text-lg">صرفه‌جویی در زمان</h3>
                                    <p class="text-gray-400 leading-relaxed">ساعات کاری تیم شما را برای کارهای مهم‌تر آزاد کنید</p>
                                    <div class="mt-3"><span class="mini-badge">+60% وقت آزاد</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="service-feature-card card-float p-8 rounded-xl relative group" data-aos="fade-left" data-aos-delay="240">
                            <div class="absolute top-4 left-4 w-10 h-10 bg-pink-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-pink-400 text-lg font-bold">4</span>
                            </div>
                            <div class="flex items-start gap-4 pt-8">
                                <div class="w-14 h-14 bg-pink-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="trending-up" class="w-7 h-7 text-pink-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-2 text-lg">افزایش بهره‌وری</h3>
                                    <p class="text-gray-400 leading-relaxed">کارایی کسب و کار خود را تا ۱۰ برابر افزایش دهید</p>
                                    <div class="mt-3"><span class="mini-badge">+10x Efficiency</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 pb-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">خدمات اتوماسیون n8n</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">اتوماسیون هوشمند فرآیندهای کسب و کار شما با قدرتمندترین پلتفرم workflow</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">اتوماسیون پایه</h3>
                            <p class="text-sm text-gray-400 mb-4">برای فرآیندهای ساده و ابتدایی</p>
                            <div class="price-display">۱۲,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی و پیاده‌سازی ۵ workflow</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال سرویس‌های اصلی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی ۳ ماهه</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>API سفارشی</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>پردازش پیشرفته داده</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">اتوماسیون پیشرفته</h3>
                            <p class="text-sm text-gray-400 mb-4">برای فرآیندهای پیچیده کسب و کار</p>
                            <div class="price-display">۲۰,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی و پیاده‌سازی ۱۰ workflow</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به ۱۵+ سرویس</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پردازش پیشرفته داده</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>Webhook و API سفارشی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی ۶ ماهه</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>معماری Enterprise</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card popular-plan p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="300">
                        <div class="relative text-center mb-6">
                            <div class="absolute -top-10 right-1/2 transform translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                                    محبوب‌ترین
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 pt-2">اتوماسیون پرو</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار کامل برای کسب و کارهای بزرگ</p>
                            <div class="price-display">۳۵,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی و پیاده‌سازی نامحدود workflow</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به تمام سرویس‌ها</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>معماری Enterprise</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>API و Webhook پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پردازش Real-time داده</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مانیتورینگ و لاگ‌گیری</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی ۱۲ ماهه</span></li>
                        </ul>
                        <button class="w-full mt-auto cta-button text-white py-3 rounded-lg font-medium">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">اتوماسیون سازمانی</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار سفارشی برای سازمان‌های بزرگ</p>
                            <div class="price-display !text-2xl">تماس بگیرید</div>
                            <p class="text-gray-400 text-sm">برای دریافت پروپوزال</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>راهکار کامل سفارشی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>معماری توزیع‌شده</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>High Availability</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>امنیت پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مشاوره و راهبری</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی اختصاصی</span></li>
                        </ul>
                        <a href="contact.php" class="w-full mt-auto text-center bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">درخواست مشاوره</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-slate-900/50 to-slate-900/20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">کاربردهای n8n</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">چگونه می‌توانیم کسب و کار شما را با n8n متحول کنیم؟</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="zap" class="w-8 h-8 text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">اتوماسیون فروش</h3>
                        <p class="text-gray-400">اتصال خودکار CRM، ایمیل، شبکه‌های اجتماعی و سیستم‌های پرداخت برای مدیریت هوشمند فروش</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-purple-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="users" class="w-8 h-8 text-purple-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">مدیریت مشتری</h3>
                        <p class="text-gray-400">همگام‌سازی خودکار داده‌های مشتری بین سیستم‌ها و ارسال نوتیفیکیشن‌های هوشمند</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-16 h-16 bg-green-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="layers" class="w-8 h-8 text-green-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">یکپارچه‌سازی سیستم‌ها</h3>
                        <p class="text-gray-400">اتصال و همگام‌سازی انواع سیستم‌های داخلی و خارجی بدون نیاز به کدنویسی</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="seo-content" class="tab-content">
        
        <section class="service-hero-section py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-900/20 via-yellow-900/10 to-slate-900/50"></div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1" data-aos="fade-right">
                        <div class="inline-block mb-8">
                            <div class="service-icon-large bg-gradient-to-br from-orange-500/30 to-yellow-500/30 border-2 border-orange-500/40">
                                <i data-feather="search" class="w-12 h-12 text-orange-400"></i>
                            </div>
                        </div>
                        <h2 class="text-5xl md:text-6xl font-bold mb-6">
                            سئوی <span class="gradient-text">اختصاصی</span>
                        </h2>
                        <p class="text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed">
                            در صفحه اول گوگل دیده شوید. با استراتژی‌های سئوی حرفه‌ای، ترافیک ارگانیک سایت خود را افزایش دهید
                        </p>
                        <div class="space-y-5">
                            <div class="service-feature-card card-float p-5 rounded-xl flex items-center gap-4" data-aos="fade-right" data-aos-delay="80">
                                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="check" class="w-6 h-6 text-green-400"></i>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-gray-300 text-lg font-medium">بهینه‌سازی On-Page و Technical SEO</span>
                                    <span class="mini-badge">CWV + Schema</span>
                                </div>
                            </div>
                            <div class="service-feature-card card-float p-5 rounded-xl flex items-center gap-4" data-aos="fade-right" data-aos-delay="140">
                                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="check" class="w-6 h-6 text-green-400"></i>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-gray-300 text-lg font-medium">استراتژی محتوای هدفمند و لینک‌سازی</span>
                                    <span class="mini-badge">Topic Clusters</span>
                                </div>
                            </div>
                            <div class="service-feature-card card-float p-5 rounded-xl flex items-center gap-4" data-aos="fade-right" data-aos-delay="200">
                                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i data-feather="check" class="w-6 h-6 text-green-400"></i>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-gray-300 text-lg font-medium">گزارش‌دهی منظم و تحلیل عملکرد</span>
                                    <span class="mini-badge">Analytics & KPI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2" data-aos="fade-left">
                        <div class="service-visual-element relative">
                            <div class="relative z-10">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="service-feature-card text-center p-8 rounded-xl">
                                        <div class="text-5xl font-bold gradient-text mb-3">۹۳٪</div>
                                        <div class="text-gray-300 font-medium">از ترافیک وب</div>
                                    </div>
                                    <div class="service-feature-card text-center p-8 rounded-xl">
                                        <div class="text-5xl font-bold gradient-text mb-3">۷۵٪</div>
                                        <div class="text-gray-300 font-medium">کاربران صفحه اول</div>
                                    </div>
                                    <div class="service-feature-card text-center p-8 rounded-xl">
                                        <div class="text-5xl font-bold gradient-text mb-3">۱۰x</div>
                                        <div class="text-gray-300 font-medium">بازگشت سرمایه</div>
                                    </div>
                                    <div class="service-feature-card text-center p-8 rounded-xl">
                                        <div class="text-5xl font-bold gradient-text mb-3">۲۴/۷</div>
                                        <div class="text-gray-300 font-medium">ترافیک ارگانیک</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 pb-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">خدمات سئوی اختصاصی</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">بهینه‌سازی سایت شما برای موتورهای جستجو و افزایش ترافیک ارگانیک با استراتژی‌های سئوی حرفه‌ای</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">سئوی پایه</h3>
                            <p class="text-sm text-gray-400 mb-4">برای شروع و بهینه‌سازی اولیه</p>
                            <div class="price-display">۸,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>آنالیز و بررسی کامل سایت</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی On-Page SEO</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ساخت و بهینه‌سازی XML Sitemap</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی سرعت سایت</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ارائه گزارش ماهانه</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>لینک‌سازی خارجی (Link Building)</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>استراتژی محتوای اختصاصی</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">سئوی پیشرفته</h3>
                            <p class="text-sm text-gray-400 mb-4">برای کسب و کارهای در حال رشد</p>
                            <div class="price-display">۱۸,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پایه</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>استراتژی محتوای اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>لینک‌سازی خارجی حرفه‌ای</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی Technical SEO</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئوی محلی (Local SEO)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی Schema Markup</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>سئوی بین‌المللی</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card popular-plan p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="300">
                        <div class="relative text-center mb-6">
                            <div class="absolute -top-10 right-1/2 transform translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                                    محبوب‌ترین
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 pt-2">سئوی پرو</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار کامل برای برندهای بزرگ</p>
                            <div class="price-display">۳۲,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سئوی بین‌المللی (i18n SEO)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>استراتژی محتوای فصلی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی Core Web Vitals</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تحلیل رقبا (Competitor Analysis)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>لینک‌سازی PR و Guest Posting</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>گزارش هفتگی و مشاوره مستمر</span></li>
                        </ul>
                        <button class="w-full mt-auto cta-button text-white py-3 rounded-lg font-medium">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">سئوی سازمانی</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار سفارشی برای سازمان‌های بزرگ</p>
                            <div class="price-display !text-2xl">تماس بگیرید</div>
                            <p class="text-gray-400 text-sm">برای دریافت پروپوزال</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>راهکار کامل سفارشی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تیم اختصاصی سئو</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>استراتژی چندزبانه</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>بهینه‌سازی E-A-T</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مدیریت بحران سئو</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مشاوره و راهبری مستمر</span></li>
                        </ul>
                        <a href="contact.php" class="w-full mt-auto text-center bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">درخواست مشاوره</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-slate-900/50 to-slate-900/20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">مزایای سئوی اختصاصی</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">چگونه سئوی حرفه‌ای می‌تواند کسب و کار شما را متحول کند؟</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-orange-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="trending-up" class="w-8 h-8 text-orange-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">افزایش ترافیک ارگانیک</h3>
                        <p class="text-gray-400">بهبود رتبه در نتایج گوگل و افزایش طبیعی بازدیدکنندگان بدون نیاز به تبلیغات</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-yellow-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="target" class="w-8 h-8 text-yellow-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">تبدیل بیشتر</h3>
                        <p class="text-gray-400">جذب مخاطبان هدفمند و افزایش نرخ تبدیل با بهینه‌سازی تجربه کاربری</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-16 h-16 bg-green-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="dollar-sign" class="w-8 h-8 text-green-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">بازگشت سرمایه (ROI)</h3>
                        <p class="text-gray-400">سئو یک سرمایه‌گذاری بلندمدت است که با گذشت زمان بازدهی بیشتری دارد</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="chatbot-content" class="tab-content">
        
        <section class="service-hero-section py-24 bg-gradient-to-b from-indigo-900/20 via-purple-900/20 to-slate-900/40">
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-20" data-aos="fade-up">
                    <div class="inline-block mb-8">
                        <div class="service-icon-large bg-gradient-to-br from-indigo-500/30 to-purple-500/30 mx-auto border-2 border-indigo-500/40">
                            <i data-feather="message-circle" class="w-12 h-12 text-indigo-400"></i>
                        </div>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-6">
                        چت بات <span class="gradient-text">هوشمند</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-8 leading-relaxed">
                        با هوش مصنوعی پیشرفته، به مشتریان خود ۲۴/۷ خدمات ارائه دهید
                    </p>
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-500/20 rounded-full border border-indigo-500/30">
                        <i data-feather="sparkles" class="w-5 h-5 text-indigo-400"></i>
                        <span class="text-indigo-300 font-medium">هر تعاملی را به فرصت فروش تبدیل کنید</span>
                    </div>
                </div>
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                        <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-right" data-aos-delay="80">
                            <div class="absolute -top-4 right-1/2 transform translate-x-1/2">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">AI</span>
                                </div>
                            </div>
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/40">
                                <i data-feather="brain" class="w-12 h-12 text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">هوش مصنوعی GPT</h3>
                            <p class="text-gray-400 mb-6 leading-relaxed">پاسخ‌های طبیعی و هوشمند با استفاده از آخرین تکنولوژی AI</p>
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/20 rounded-full">
                                <i data-feather="arrow-right" class="w-4 h-4 text-blue-400"></i>
                                <span class="text-sm text-blue-400 font-medium">یادگیری مستمر</span>
                            </div>
                        </div>
                        <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-up" data-aos-delay="140">
                            <div class="absolute -top-4 right-1/2 transform translate-x-1/2">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">CH</span>
                                </div>
                            </div>
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-purple-500/40">
                                <i data-feather="globe" class="w-12 h-12 text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">چند کاناله</h3>
                            <p class="text-gray-400 mb-6 leading-relaxed">اتصال به وبسایت، تلگرام، واتساپ و اینستاگرام</p>
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500/20 rounded-full">
                                <i data-feather="arrow-right" class="w-4 h-4 text-purple-400"></i>
                                <span class="text-sm text-purple-400 font-medium">همه جا در دسترس</span>
                            </div>
                        </div>
                        <div class="service-feature-card card-float p-10 rounded-2xl text-center relative group" data-aos="fade-left" data-aos-delay="200">
                            <div class="absolute -top-4 right-1/2 transform translate-x-1/2">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">3x</span>
                                </div>
                            </div>
                            <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-500/40">
                                <i data-feather="trending-up" class="w-12 h-12 text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-4">تبدیل بیشتر</h3>
                            <p class="text-gray-400 mb-6 leading-relaxed">افزایش نرخ تبدیل تا ۳ برابر با پاسخگویی فوری</p>
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/20 rounded-full">
                                <i data-feather="arrow-right" class="w-4 h-4 text-green-400"></i>
                                <span class="text-sm text-green-400 font-medium">۳x نرخ تبدیل</span>
                            </div>
                        </div>
                    </div>
                    <div class="service-feature-card p-10 rounded-2xl" data-aos="fade-up">
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                                        <i data-feather="star" class="w-6 h-6 text-indigo-400"></i>
                                    </div>
                                    <h3 class="text-3xl font-bold">چرا چت بات هوشمند؟</h3>
                                </div>
                                <ul class="space-y-4 text-gray-300">
                                    <li class="flex items-start gap-4">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-feather="check-circle" class="w-5 h-5 text-green-400"></i>
                                        </div>
                                        <span class="text-lg">کاهش ۷۰٪ هزینه‌های پشتیبانی</span>
                                    </li>
                                    <li class="flex items-start gap-4">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-feather="check-circle" class="w-5 h-5 text-green-400"></i>
                                        </div>
                                        <span class="text-lg">پاسخگویی فوری در کمتر از ۱ ثانیه</span>
                                    </li>
                                    <li class="flex items-start gap-4">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-feather="check-circle" class="w-5 h-5 text-green-400"></i>
                                        </div>
                                        <span class="text-lg">جمع‌آوری خودکار اطلاعات مشتریان (Lead Generation)</span>
                                    </li>
                                    <li class="flex items-start gap-4">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-feather="check-circle" class="w-5 h-5 text-green-400"></i>
                                        </div>
                                        <span class="text-lg">ادغام با CRM و سیستم مدیریت سفارشات</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="w-full md:w-80 h-64 service-visual-element flex items-center justify-center rounded-2xl">
                                <div class="relative z-10">
                                    <i data-feather="message-square" class="w-32 h-32 text-indigo-400/60"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-10 pb-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">خدمات چت بات هوشمند</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">ارائه خدمات 24/7 به مشتریان خود با هوش مصنوعی پیشرفته و پاسخگویی خودکار</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">چت بات پایه</h3>
                            <p class="text-sm text-gray-400 mb-4">برای پاسخگویی اولیه</p>
                            <div class="price-display">۶,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>طراحی و پیاده‌سازی چت بات هوشمند</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پاسخگویی به سوالات متداول (FAQ)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به وبسایت یا تلگرام</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>رابط کاربری زیبا و کاربرپسند</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی و نگهداری ۳ ماهه</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>ادغام با سیستم CRM</span></li>
                            <li class="flex items-start opacity-50"><div class="feature-icon bg-red-500/20 mr-3"><i data-feather="x" class="w-4 h-4 text-red-400"></i></div><span>یادگیری از تعاملات (Machine Learning)</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">چت بات پیشرفته</h3>
                            <p class="text-sm text-gray-400 mb-4">برای کسب و کارهای فعال</p>
                            <div class="price-display">۱۵,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پایه</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هوش مصنوعی پیشرفته (GPT-based)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ادغام با سیستم CRM و مدیریت سفارشات</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>چندزبانه (فارسی، انگلیسی و ...)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>اتصال به واتساپ و اینستاگرام</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>یادگیری از تعاملات مشتریان</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>گزارش‌دهی و آنالیتیکس</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی و نگهداری ۶ ماهه</span></li>
                        </ul>
                        <button class="w-full mt-auto bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">انتخاب پلن</button>
                    </div>

                    <div class="plan-card popular-plan p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="300">
                        <div class="relative text-center mb-6">
                            <div class="absolute -top-10 right-1/2 transform translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                                    محبوب‌ترین
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 pt-2">چت بات پرو</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار کامل برای برندهای بزرگ</p>
                            <div class="price-display">۲۸,۰۰۰,۰۰۰</div>
                            <p class="text-gray-400 text-sm">تومان / شروع از</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>تمام ویژگی‌های پلن پیشرفته</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>هوش مصنوعی اختصاصی و سفارشی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پاسخگویی صوتی (Voice Chat)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ادغام کامل با تمام سیستم‌ها</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مدیریت پیشرفته دستیار مجازی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی از تصویر و فایل</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>استخراج Lead و تحلیل رفتار کاربر</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی و نگهداری ۱۲ ماهه</span></li>
                        </ul>
                        <button class="w-full mt-auto cta-button text-white py-3 rounded-lg font-medium">انتخاب پلن</button>
                    </div>

                    <div class="plan-card p-6 rounded-2xl flex flex-col" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold mb-2">چت بات سازمانی</h3>
                            <p class="text-sm text-gray-400 mb-4">راهکار سفارشی برای سازمان‌های بزرگ</p>
                            <div class="price-display !text-2xl">تماس بگیرید</div>
                            <p class="text-gray-400 text-sm">برای دریافت پروپوزال</p>
                        </div>
                        <ul class="space-y-3 mb-8 text-sm flex-grow">
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>راهکار کامل سفارشی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>چند چت بات همزمان (Multi-bot)</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>سیستم یادگیری ماشین اختصاصی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>ادغام با تمام کانال‌های ارتباطی</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>مدیریت مرکز تماس هوشمند</span></li>
                            <li class="flex items-start"><div class="feature-icon bg-green-500/20 mr-3"><i data-feather="check" class="w-4 h-4 text-green-400"></i></div><span>پشتیبانی اختصاصی 24/7</span></li>
                        </ul>
                        <a href="contact.php" class="w-full mt-auto text-center bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">درخواست مشاوره</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-slate-900/50 to-slate-900/20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">مزایای چت بات هوشمند</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">چگونه چت بات می‌تواند کسب و کار شما را متحول کند؟</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="clock" class="w-8 h-8 text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">پاسخگویی 24/7</h3>
                        <p class="text-gray-400">ارائه خدمات به مشتریان در تمام ساعات شبانه‌روز بدون نیاز به حضور نیروی انسانی</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-purple-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="trending-up" class="w-8 h-8 text-purple-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">افزایش نرخ تبدیل</h3>
                        <p class="text-gray-400">راهنمایی هوشمند مشتریان و تبدیل بازدیدکنندگان به مشتری با پاسخگویی سریع و دقیق</p>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-16 h-16 bg-green-900/30 rounded-lg flex items-center justify-center mb-6">
                            <i data-feather="dollar-sign" class="w-8 h-8 text-green-400"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4">کاهش هزینه‌ها</h3>
                        <p class="text-gray-400">کاهش چشمگیر هزینه‌های پشتیبانی و استخدام نیروی انسانی با استفاده از چت بات</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer class="py-12 bg-slate-900/80">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="text-2xl font-bold text-white mb-4">
                        <span class="gradient-text">NextPixel</span>
                    </div>
                    <p class="text-gray-400 text-sm md:text-base max-w-md">تبدیل ایده‌های خلاقانه به تجربه‌های دیجیتالی ماندگار</p>
                </div>
                <div class="flex space-x-6 space-x-reverse">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Instagram"><i data-feather="instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Twitter"><i data-feather="twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="LinkedIn"><i data-feather="linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Telegram"><i data-feather="send"></i></a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 mb-4 md:mb-0">© ۲۰۲۵ NextPixel. تمام حقوق محفوظ است.</p>
                <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                    <div class="flex space-x-6 space-x-reverse text-gray-500">
                        <a href="#" class="hover:text-blue-400 transition">قوانین و مقررات</a>
                        <a href="#" class="hover:text-blue-400 transition">حریم خصوصی</a>
                    </div>
                    <div>
                     <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=700549&Code=w6jBNPtaQgNYlnyy2yvTqfLF9aoFJmxT'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=700549&Code=w6jBNPtaQgNYlnyy2yvTqfLF9aoFJmxT' alt='' style='cursor:pointer' code='w6jBNPtaQgNYlnyy2yvTqfLF9aoFJmxT'></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div id="chatbot-container">
        
        <div class="fixed bottom-6 left-6 z-[999]">
            <button id="chat-toggle-btn"
                class="cta-button text-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform animate-pulse"
                aria-label="Toggle Chatbot">
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                    <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.15l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.15 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.74c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div id="chat-window" class="fixed bottom-24 left-4 right-4 md:left-6 md:right-auto z-[1000] w-auto max-w-sm h-[70vh] max-h-[500px] transition-all duration-300 ease-in-out opacity-0 translate-y-4 pointer-events-none">
            <div class="glass-effect w-full h-full rounded-2xl flex flex-col shadow-2xl">
                
                <header class="p-4 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-center gradient-text">دستیار هوشمند NextPixel</h3>
                    <button id="chat-close-btn" class="text-slate-400 hover:text-white">
                         <i data-feather="x" class="w-6 h-6"></i>
                    </button>
                </header>

                <div id="chat-box" class="flex-1 p-4 space-y-4 overflow-y-auto">
                    
                </div>

                <footer class="p-4 border-t border-slate-700">
                    <form id="chat-form" class="flex items-center gap-2">
                        <input 
                            id="chat-input"
                            type="text"
                            placeholder="پیام خود را بنویسید..."
                            class="flex-1 bg-slate-800/80 border border-slate-700 rounded-full px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        <button type="submit" id="chat-submit-btn" class="cta-button text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 disabled:opacity-50">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                            </svg>
                        </button>
                    </form>
                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = menuBtn.querySelector('i');
            const toggleMenu = () => { mobileMenu.classList.toggle('translate-x-full'); const isMenuOpen = !mobileMenu.classList.contains('translate-x-full'); menuIcon.setAttribute('data-feather', isMenuOpen ? 'x' : 'menu'); feather.replace({ width: '28px', height: '28px' }); };
            menuBtn.addEventListener('click', toggleMenu);
            mobileMenu.querySelectorAll('a').forEach(link => link.addEventListener('click', toggleMenu));
            
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.dataset.target;
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    tabContents.forEach(content => content.classList.toggle('active', content.id === targetId));
                    AOS.refresh();
                });
            });
            AOS.init({ duration: 800, easing: 'ease-out-quart', once: true });

            const header = document.querySelector('.ios-glass-header');
            if (header) {
                let lastScroll = 0;
                window.addEventListener('scroll', () => {
                    const currentScroll = window.pageYOffset;
                    if (currentScroll > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                    lastScroll = currentScroll;
                });
            }

            const createCalculator = (containerId, config, priceElementId) => {
                const container = document.getElementById(containerId);
                const priceElement = document.getElementById(priceElementId);
                if (!container || !priceElement) return () => ({});
                
                let state = {};

                config.options.forEach(item => {
                    let itemHtml = `<div class="space-y-3 mb-6"><label class="font-medium block">${item.label}</label>`;
                    if (item.type === 'buttons') {
                        itemHtml += `<div id="${item.id}" class="grid grid-cols-2 sm:grid-cols-3 gap-2">`;
                        item.choices.forEach((opt, index) => {
                            itemHtml += `<button data-key="${item.key}" data-value="${opt.value}" class="option-button py-2 px-4 rounded-lg text-sm sm:text-base ${index === 0 ? 'active' : ''}">${opt.text}</button>`;
                        });
                        itemHtml += `</div>`;
                    } else if (item.type === 'slider') {
                         itemHtml += `
                            <div class="flex justify-between items-center mb-2">
                                <span id="${item.id}-value" class="text-blue-400 font-bold">${item.choices[item.default]}</span>
                            </div>
                            <input type="range" id="${item.id}" data-key="${item.key}" min="0" max="${item.choices.length - 1}" value="${item.default}" class="slider">
                            <div class="flex justify-between text-xs text-gray-400 mt-2">
                                <span>${item.choices[0]}</span>
                                <span>${item.choices[item.choices.length - 1]}</span>
                            </div>`;
                    } else if (item.type === 'checkbox') {
                         itemHtml += `<div class="space-y-2">`;
                         item.choices.forEach(opt => {
                             itemHtml += `
                                <label class="flex items-center space-x-3 space-x-reverse cursor-pointer">
                                    <input type="checkbox" data-key="${opt.key}" class="custom-checkbox">
                                    <span>${opt.text}</span>
                                </label>`;
                         });
                         itemHtml += `</div>`;
                    }
                    itemHtml += `</div>`;
                    container.insertAdjacentHTML('beforeend', itemHtml);
                });
                
                feather.replace();

                const update = () => {
                    state = {};
                    let total = config.basePrice || 0;

                    config.options.forEach(item => {
                        let value;
                        if (item.type === 'buttons') {
                            const activeBtn = container.querySelector(`#${item.id} .active`);
                            value = activeBtn.dataset.value;
                            state[item.label] = activeBtn.textContent.trim();
                        } else if (item.type === 'slider') {
                            const slider = container.querySelector(`#${item.id}`);
                            const valueEl = container.querySelector(`#${item.id}-value`);
                            value = item.choices[slider.value];
                            if(valueEl) valueEl.textContent = value;
                            state[item.label] = value;
                        } else if (item.type === 'checkbox') {
                            let checkedItems = [];
                            item.choices.forEach(opt => {
                                const checkbox = container.querySelector(`[data-key="${opt.key}"]`);
                                if (checkbox.checked) {
                                    checkedItems.push(opt.text);
                                    if (config.prices[opt.key]) {
                                        total += config.prices[opt.key];
                                    }
                                }
                            });
                            if (checkedItems.length > 0) {
                                state[item.label] = checkedItems.join(', ');
                            }
                            return; 
                        }
                        
                        const priceConfig = config.prices[item.key];
                        if (priceConfig && priceConfig[value]) {
                            total += priceConfig[value];
                        }
                    });
                    
                    priceElement.textContent = (total / 1000000).toLocaleString('fa-IR', { minimumFractionDigits: 1, maximumFractionDigits: 2 }) + ' میلیون';
                    anime({ targets: priceElement, scale: [1.05, 1], duration: 300, easing: 'easeOutQuad' });
                };

                container.querySelectorAll('button.option-button').forEach(btn => {
                    btn.addEventListener('click', () => {
                        container.querySelectorAll(`button[data-key="${btn.dataset.key}"]`).forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        update();
                    });
                });
                container.querySelectorAll('input[type="range"], input[type="checkbox"]').forEach(input => {
                    input.addEventListener('input', update);
                });
                
                update(); 
                return () => { update(); return state; };
            };

            const wpConfig = {
                basePrice: 8700000, 
                options: [
                    { id: 'wp_site_type', key: 'siteType', label: '۱. نوع وبسایت', type: 'buttons', choices: [{value: 'service', text: 'خدماتی'}, {value: 'store', text: 'فروشگاهی'}, {value: 'landing', text: 'لندینگ'}] },
                    { id: 'wp_design_level', key: 'design', label: '۲. سطح طراحی', type: 'buttons', choices: [{value: 'template', text: 'قالب آماده'}, {value: 're-design', text: 'بازطراحی قالب'}, {value: 'scratch', text: 'طراحی اختصاصی'}] },
                    { id: 'wp_pages', key: 'pages', label: '۳. تعداد صفحات', type: 'slider', default: 0, choices: ["تا ۵", "تا ۱۰", "تا ۱۵", "تا ۲۰", "نامحدود"]},
                    { id: 'wp_seo', key: 'seo', label: '۴. سطح سئو', type: 'slider', default: 0, choices: ["بیسیک", "پیشرفته", "رتبه یک"]},
                    { id: 'wp_support', key: 'support', label: '۵. مدت پشتیبانی', type: 'slider', default: 0, choices: ["۳ ماه", "۶ ماه", "۱۲ ماه"]},
                    { id: 'wp_features', key: 'features', label: '۶. امکانات ویژه', type: 'checkbox', choices: [
                        {key: 'aiChatbot', text: 'چت بات هوشمند (پایه)'}, 
                        {key: 'social', text: 'اتصال به شبکه‌های مجازی'}
                    ]},
                ],
                prices: { 
                    siteType: {service: 0, store: 2000000, landing: -1000000}, 
                    design: {template: 0, 're-design': 5000000, scratch: 10000000}, 
                    pages: {"تا ۱۰": 1000000, "تا ۱۵": 2000000, "تا ۲۰": 3500000, "نامحدود": 5000000}, 
                    seo: { "پیشرفته": 2500000, "رتبه یک": 6000000}, 
                    support: {"۶ ماه": 1500000, "۱۲ ماه": 2500000}, 
                    aiChatbot: 1200000, 
                    social: 800000 
                }
            };
            const getWpChoices = createCalculator('wordpress-calculator-inputs', wpConfig, 'wp-final-price');

            const codingConfig = {
                basePrice: 15000000,
                options: [
                    { id: 'coding_project_type', key: 'projectType', label: '۱. نوع پروژه', type: 'buttons', choices: [{value: 'api', text: 'API'}, {value: 'webapp', text: 'Web App'}, {value: 'mobile_backend', text: 'Mobile Backend'}] },
                    { id: 'coding_complexity', key: 'complexity', label: '۲. پیچیدگی پروژه', type: 'slider', default: 1, choices: ["پایین", "متوسط", "بالا", "بسیار بالا"]},
                    { id: 'coding_db', key: 'database', label: '۳. پایگاه داده', type: 'buttons', choices: [{value: 'mysql', text: 'MySQL'}, {value: 'postgres', text: 'PostgreSQL'}, {value: 'mongodb', text: 'MongoDB'}]},
                    { id: 'coding_features', key: 'features', label: '۴. ویژگی‌های کلیدی', type: 'checkbox', choices: [{key: 'hasRealtime', text: 'ارتباطات لحظه‌ای (چت، نوتیفیکیشن)'}, {key: 'hasAuth', text: 'سیستم احراز هویت پیشرفته (OAuth)'}]},
                ],
                prices: { projectType: {webapp: 10000000, mobile_backend: 5000000}, complexity: {"متوسط": 15000000, "بالا": 30000000, "بسیار بالا": 50000000}, hasRealtime: 8000000, hasAuth: 5000000 }
            };
            const getCustomChoices = createCalculator('coding-calculator-inputs', codingConfig, 'coding-final-price');

            const modal = document.getElementById('proposal-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const loader = document.getElementById('loader');
            const resultContainer = document.getElementById('proposal-result');

            const openModal = () => modal.classList.remove('hidden');
            const closeModal = () => modal.classList.add('hidden');
            closeModalBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

            async function generateProposal(buttonId, getChoices, systemPrompt) {
                 const generateBtn = document.getElementById(buttonId);
                 if (!generateBtn) return;
                
                 generateBtn.addEventListener('click', async () => {
                    openModal();
                    loader.style.display = 'flex';
                    resultContainer.style.display = 'none';
                    resultContainer.innerHTML = '';
                    try {
                        const userChoices = getChoices();
                        let userQuery = "یک پیشنهاد پروژه برای یک مشتری بنویس که انتخاب‌های زیر را داشته است:\n";
                        for (const key in userChoices) {
                             if (userChoices[key]) userQuery += `- ${key}: ${userChoices[key]}\n`;
                        }
                        userQuery += "\nاین پیشنهاد را با یک مقدمه دلگرم‌کننده شروع کن و در انتها مشتری را به تماس برای نهایی کردن پروژه تشویق کن.";
                        
                        const apiUrl = '/api/generate-proposal.php'; 
                        
                        const payload = { userQuery, systemPrompt };

                        const response = await fetch(apiUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(payload)
                        });

                        if (!response.ok) throw new Error(`API request failed: ${response.status} ${await response.text()}`);
                        
                        const result = await response.json();
                        const text = result.candidates?.[0]?.content?.parts?.[0]?.text;
                        
                        if (text) {
                            let htmlResult = text
                                .replace(/^# (.*$)/gim, '<h2 class="text-xl font-bold gradient-text mb-4">$1</h2>')
                                .replace(/^- (.*$)/gim, '<li class="mb-2 ml-4 list-disc">$1</li>')
                                .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-purple-300">$1</strong>');
                            resultContainer.innerHTML = `<ul class="space-y-2">${htmlResult}</ul>`;
                        } else {
                           resultContainer.textContent = "پاسخی از سرویس هوشمند دریافت نشد. لطفاً دوباره تلاش کنید.";
                        }
                    } catch (error) {
                        console.error("Error calling backend proxy:", error);
                        resultContainer.textContent = "خطا در برقراری ارتباط با سرور. لطفاً از صحت عملکرد فایل پروکسی اطمینان حاصل کنید.";
                    } finally {
                        loader.style.display = 'none';
                        resultContainer.style.display = 'block';
                    }
                });
            }
            const wpSystemPrompt = "شما یک مدیر پروژه خبره در یک شرکت طراحی سایت هستید. وظیفه شما این است که بر اساس انتخاب‌های مشتری، یک پیشنهاد پروژه کوتاه، دوستانه و تشویق‌کننده به زبان فارسی بنویسید. پیشنهاد شما باید شامل خلاصه‌ای از خدمات انتخاب شده، توضیح مختصری از مزایای هر کدام، و یک دید کلی از مراحل بعدی باشد. در انتهای پیشنهاد، همیشه یک پاراگراف دعوت به اقدام (Call to Action) اضافه کن و از مشتری بخواه برای دریافت مشاوره دقیق‌تر و نهایی کردن جزئیات، با ما تماس بگیرد. از لحنی حرفه‌ای اما صمیمی استفاده کنید و پاسخ را با فرمت مارک‌داون ساده ارائه دهید.";
            generateProposal('generate-wp-proposal-btn', getWpChoices, wpSystemPrompt);
            
            const customSystemPrompt = "شما یک معمار نرم‌افزار (Solutions Architect) ارشد در یک شرکت توسعه نرم‌افزار هستید. وظیفه شما این است که بر اساس نیازمندی‌های فنی مشتری، یک طرح اولیه فنی (Technical Proposal) کوتاه، واضح و حرفه‌ای به زبان فارسی بنویسید. این طرح باید شامل خلاصه‌ای از تکنولوژی‌های پیشنهادی، معماری کلی سیستم، و یک نقشه راه (Roadmap) اولیه برای توسعه باشد. در انتهای پیشنهاد، همیشه یک پاراگراف دعوت به اقدام (Call to Action) اضافه کن و از مشتری بخواه برای دریافت مشاوره فنی و بررسی دقیق‌تر معماری، با ما تماس بگیرد. از اصطلاحات فنی به درستی استفاده کنید و پاسخ را با فرمت مارک‌داون ساده ارائه دهید.";
            generateProposal('generate-custom-proposal-btn', getCustomChoices, customSystemPrompt);

            const chatToggleBtn = document.getElementById('chat-toggle-btn');
            const chatCloseBtn = document.getElementById('chat-close-btn');
            const chatWindow = document.getElementById('chat-window');
            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatSubmitBtn = document.getElementById('chat-submit-btn');

            let messages = []; 
            let isLoading = false;

            const OPENAI_API_KEY = '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';

            const SYSTEM_PROMPT = `شما "Unix"، دستیار هوشمند و راهنمای ارشد NextPixelIran هستید.

1.  **شخصیت و لحن:**
    * **هویت:** شما یک متخصص ارشد طراحی وب (هم وردپرس و هم کدنویسی اختصاصی) هستید. شخصیت شما INFJ است؛ یعنی دلسوز، همدل، بسیار باهوش و آینده‌نگر.
    * **لحن:** لحن شما **گرم، صمیمی و دوستانه** است، نه رسمی و خشک. شما مانند یک متخصص فنی هستید که می‌تواند پیچیده‌ترین مسائل را به زبان ساده و محاوره‌ای برای دوست خود توضیح دهد، اما اگر مخاطب فنی باشد، می‌توانید وارد جزئیات عمیق فنی شوید.
    * **هدف:** شما یک فروشنده تهاجمی نیستید. شما یک **مشاور دلسوز** هستید. هدف شما درک عمیق نیاز مشتری و هدایت او به بهترین راه‌حل است.

2.  **استراتژی فروش (SPIN/DISC):**
    * **شروع (مرحله ۱):** گفتگو را با معرفی خودت و **پرسیدن نام مشتری** شروع کن. (مثال: "سلام! من یونیکس هستم، دستیار هوشمند NextPixel. خیلی خوشحالم که اینجا هستید. افتخار آشنایی با چه کسی رو دارم؟")
    * **درک موقعیت (مرحله ۲):** پس از دریافت نام، بلافاصله نوع پروژه را بپرس. (مثال: "سلام [نام مشتری] عزیز! برای چه نوع پروژه‌ای نیاز به راهنمایی دارید؟ مثلاً سایت فروشگاهی، شرکتی، یا یک ایده کاملاً جدید؟")
    * **بررسی مشکل (مرحله ۳ - انشعاب):**
        * **اگر گفت "فروشگاهی":** بپرس: "عالیه! لطفاً بفرمایید حوزه فعالیت فروشگاه شما چیه (مثلاً پوشاک، رستوران و...) و حدوداً چه تعداد محصول دارید؟"
        * **اگر گفت "خدماتی/شرکتی":** بپرس: "بسیار خب. لطفاً بفرمایید کسب‌وکارتون در چه زمینه‌ای هست و حدوداً چه تعداد خدمات یا صفحاتی (مثل درباره ما، تماس با ما) نیاز دارید؟"
    * **پیشنهاد هوشمند (مرحله ۴):**
        * **دستورالعمل:** بر اساس نوع کسب‌وکار مشتری (مثلاً رستوران، فروشگاه پوشاک، کلینیک)، **یک ایده خلاقانه** به او پیشنهاد بده.
        * **توضیح برای مشتری (ساده):** **هرگز** از کلمات فنی مانند 'n8n'، 'API'، 'Webhook' یا 'اتوماسیون' در مکالمه با مشتری استفاده **نکنید**.
        * *مثال (رستوران):* "چه عالی! می‌دونستید می‌تونیم سیستمی براتون طراحی کنیم که به محض ثبت سفارش مشتری در سایت، همون لحظه سفارش به صورت خودکار روی پرینتر آشپزخونه شما چاپ بشه؟"
        * *مثال (پوشاک):* "یه ایده جالب! می‌تونیم اینستاگرام شما رو هوشمند کنیم! هر پستی که می‌گذارید، محصولش مستقیماً در سایت هم موجود بشه و مشتری بتونه خرید کنه."
    * **بررسی نیاز (مرحله ۵):** بر اساس پلن‌ها سوالات بعدی را بپرس. (مثال: "برای طراحی ظاهری، دنبال یک قالب آماده و اقتصادی هستید (مثل پلن Pixel One) یا یک طراحی کاملاً اختصاصی و یونیک (مثل پلن Pixel Pro)؟" یا "موضوع سئو و دیده شدن در گوگل چقدر براتون اولویت داره؟")
* **پلن Infinity Pixel (مهم):**
    * اگر کاربر نیازهای بسیار پیچیده داشت یا در مورد برنامه‌نویسی اختصاصی پرسید، **دقیقاً** از این متن استفاده کن:
    "پلن Infinity Pixel مخصوص لحظه‌هاییه که خلاقیت حد و مرزی نداره 🌌. طبق باور نکست پیکسل، هر برند دنیای خاص خودش رو داره، پس ما توی این پلن دقیقاً همون چیزی رو می‌سازیم که شما توی ذهنتون دارید — نه کمتر، نه بیشتر. به همین خاطر قیمت مشخصی نداره؛ اول یه جلسه‌ی مشاوره‌ی اختصاصی با تیم فنی و طراحانمون برگزار می‌کنیم تا نیازها و رؤیاهای برندتون رو کامل بشناسیم 💬 بعد از اون، طرح و برآورد هزینه دقیق، مخصوص خود شما آماده می‌شه. تمایل دارید برای تنظیم این جلسه مشاوره رایگان راهنمایی‌تون کنم؟"
* **هدف نهایی (CTA):** همیشه مکالمه را به سمت "مشاوره رایگان" هدایت کن.
    * "اطلاعاتی که دادید عالی بود. برای اینکه بتونم دقیق‌ترین پلن رو به شما پیشنهاد بدم، نیاز به چند تا سوال تخصصی‌تر دارم. مایل هستید شماره تماستون رو بگذارید تا یکی از متخصصین ارشد ما با شما تماس بگیره؟"

3.  **وظیفه نهایی (ذخیره اطلاعات برای ادمین - بسیار مهم):**
* پس از اینکه تمام نیازهای کاربر را شناسایی کردی و راه‌حل‌ها را پیشنهاد دادی، و کاربر اطلاعات تماس ارائه داد یا گفتگو به پایان طبیعی خود رسید، باید مکالمه را برای ادمین به این شکل خلاصه کنی:
* شروع خلاصه: [START_LEAD_SUMMARY]
* **نام مشتری:** [نامی که در ابتدای چت پرسیدی]
* **خلاصه نیازهای مشتری:** [خلاصه‌ای دقیق از تمام نیازها و چالش‌های مشتری که در چت مطرح شد، مثلا: فروشگاه پوشاک، حدود ۵۰ محصول]
* **پیشنهاد هوشمند (ایده ساده):** [ایده‌ای که به مشتری پیشنهاد دادی، مثلا: اتصال هوشمند اینستاگرام به سایت]
* **جزئیات فنی (برای ادمین):** [جزئیات فنی پیاده‌سازی آن ایده، مثلا: نیاز به n8n webhook برای خواندن پست‌های جدید اینستاگرام و اتصال به API ووکامرس برای ایجاد محصول]
* **پلن پیشنهادی:** [پلن یا راه‌حل پیشنهادی شما]
* **اطلاعات تماس (در صورت وجود):** [شماره تماس یا ایمیل ارائه شده توسط کاربر]
* پایان خلاصه: [END_LEAD_SUMMARY]
* **دقیقاً** از این فرمت استفاده کن. این یک دستورالعمل سیستمی برای ذخیره‌سازی اطلاعات است و کاربر نباید متوجه این بخش شود. این خلاصه را *بعد* از آخرین پیام خداحافظی خود به کاربر، ارسال کن.
`;

            messages.push({ role: 'system', content: SYSTEM_PROMPT });

            const addMessage = (role, content) => {
                if (role === 'system' || content.includes('[START_LEAD_SUMMARY]')) {
                    return;
                }
                const messageEl = document.createElement('div');
                messageEl.classList.add('chat-bubble', `chat-bubble-${role}`);
                if (content === '...') {
                    messageEl.innerHTML = '<div class="loader-dots"><span>.</span><span>.</span><span>.</span></div>';
                } else {
                    content = content.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    messageEl.innerHTML = content.replace(/\n/g, '<br>');
                }
                chatBox.appendChild(messageEl);
                chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
            };

            const saveLeadToFile = async (summary) => {
                try {
                    const response = await fetch('/api/save-lead.php', { 
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ summary: summary })
                    });
                    if (!response.ok) {
                        console.error('Failed to save lead', await response.text());
                    } else {
                        console.log('Lead saved successfully!');
                    }
                } catch (err) {
                    console.error("Error saving lead:", err);
                }
            };

            const getChatbotResponse = async (history) => {
                isLoading = true;
                chatSubmitBtn.disabled = true;
                addMessage('assistant', '...'); 

                const apiUrl = 'https://api.openai.com/v1/chat/completions';
                
                try {
                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${OPENAI_API_KEY}`
                        },
                        body: JSON.stringify({
                            model: 'gpt-4o', 
                            messages: history, 
                        })
                    });

                    if (!response.ok) {
                        const errData = await response.json();
                        throw new Error(`API Error (${response.status}): ${errData.error.message}`);
                    }

                    const data = await response.json();
                    const aiResponse = data.choices[0].message.content;
                    
                    chatBox.removeChild(chatBox.lastChild); 

                    if (aiResponse.includes('[START_LEAD_SUMMARY]')) {
                        const summary = aiResponse.substring(aiResponse.indexOf('[START_LEAD_SUMMARY]'));
                        await saveLeadToFile(summary);
                        
                        const userMessage = aiResponse.substring(0, aiResponse.indexOf('[START_LEAD_SUMMARY]')).trim();
                        if (userMessage) {
                            addMessage('assistant', userMessage);
                            messages.push({ role: 'assistant', content: userMessage });
                        }
                    } else {
                        addMessage('assistant', aiResponse);
                        messages.push({ role: 'assistant', content: aiResponse });
                    }

                } catch (err) {
                    console.error("Error calling OpenAI API:", err);
                    chatBox.removeChild(chatBox.lastChild);
                    addMessage('assistant', `متاسفانه خطایی رخ داد. اگر در ایران هستید، ممکن است نیاز به VPN داشته باشید. (${err.message})`);
                } finally {
                    isLoading = false;
                    chatSubmitBtn.disabled = false;
                }
            };

            const toggleChatWindow = () => {
                const isOpen = !chatWindow.classList.contains('opacity-0');
                chatWindow.classList.toggle('opacity-0', isOpen);
                chatWindow.classList.toggle('translate-y-4', isOpen);
                chatWindow.classList.toggle('pointer-events-none', isOpen);

                if (!isOpen && messages.length === 1) { 
                    getChatbotResponse(messages); 
                }
            };

            chatToggleBtn.addEventListener('click', toggleChatWindow);
            chatCloseBtn.addEventListener('click', toggleChatWindow);

            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const userInput = chatInput.value.trim();
                if (!userInput || isLoading) return;

                addMessage('user', userInput);
                messages.push({ role: 'user', content: userInput });
                chatInput.value = '';
                
                await getChatbotResponse(messages);
            });
        });
    </script>
</body>

</html>

