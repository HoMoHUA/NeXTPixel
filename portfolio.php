<?php
// شروع سشن در ابتدای فایل
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';
$isN8NAdmin = $isLoggedIn; // دسترسی برای همه کاربران لاگین شده
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نمونه کارها | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js" defer></script>
    <script src="https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap');
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            line-height: 1.8;
            overflow-x: hidden;
        }
        .glass-effect {
            background: rgba(15, 23, 42, 0.85);
            -webkit-backdrop-filter: url(#liquid-glass-filter);
            backdrop-filter: url(#liquid-glass-filter);
            border: 1px solid rgba(255, 255, 255, 0.125);
            will-change: transform, backdrop-filter;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .portfolio-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }
        .portfolio-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.3);
        }
        .portfolio-card img {
            transition: transform 0.5s ease;
        }
        .portfolio-card:hover img {
            transform: scale(1.1);
        }
        .filter-btn.active {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            color: white;
        }
        .dynamic-bg {
            background: linear-gradient(45deg, #0f172a, #1e293b, #334155);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .filter-btn:hover {
            transform: translateY(-2px);
        }
        .cta-button {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        /* iOS-Style Liquid Glass Header */
        nav.ios-glass-header {
            position: sticky;
            top: 16px;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: saturate(180%) blur(30px);
            -webkit-backdrop-filter: saturate(180%) blur(30px);
            border: 0.5px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.05) inset,
                        0 -1px 0 0 rgba(0, 0, 0, 0.1) inset,
                        0 8px 32px rgba(0, 0, 0, 0.12),
                        0 0 0 1px rgba(255, 255, 255, 0.03) inset;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        nav.ios-glass-header.scrolled {
            top: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: saturate(200%) blur(40px);
            -webkit-backdrop-filter: saturate(200%) blur(40px);
            border-bottom: 0.5px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.08) inset,
                        0 -1px 0 0 rgba(0, 0, 0, 0.2) inset,
                        0 12px 48px rgba(0, 0, 0, 0.25),
                        0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- SVG Filter for Liquid Glass Effect -->
    <svg style="position: absolute; width: 0; height: 0;">
      <defs>
        <filter id="liquid-glass-filter" color-interpolation-filters="sRGB">
          <feImage href="data:image/svg+xml,%0A%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='512' height='512' filter='url(%23noise)'/%3E%3C/svg%3E" x="0" y="0" width="100%" height="100%" result="map"></feImage>
          <feDisplacementMap in="SourceGraphic" in2="map" scale="15" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
          <feGaussianBlur in="SourceGraphic" stdDeviation="4"></feGaussianBlur>
        </filter>
      </defs>
    </svg>

    <!-- Navigation -->
    <nav class="ios-glass-header flex justify-between items-center py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
        <div class="text-2xl font-bold text-white flex items-center">
            <a href="index.php" class="gradient-text font-bold">NextPixel</a>
        </div>
        <div class="hidden md:flex items-center space-x-6 space-x-reverse">
            <a href="index.php" class="hover:text-blue-400 transition">صفحه اصلی</a>
            <a href="services.php" class="hover:text-blue-400 transition">خدمات</a>
            <a href="about.php" class="hover:text-blue-400 transition">درباره ما</a>
            <a href="portfolio.php" class="text-blue-400 font-medium">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition">تماس با ما</a>

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

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 bg-slate-900/90 glass-effect z-40 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="flex flex-col items-center justify-center h-full space-y-8 text-2xl font-medium">
            <a href="index.php" class="hover:text-blue-400 transition text-white">صفحه اصلی</a>
            <a href="services.php" class="hover:text-blue-400 transition text-white">خدمات</a>
            <a href="about.php" class="hover:text-blue-400 transition text-white">درباره ما</a>
            <a href="portfolio.php" class="text-blue-400 font-medium">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition text-white">تماس با ما</a>
            
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

    <!-- Hero Section -->
    <section class="min-h-[60vh] flex items-center relative overflow-hidden dynamic-bg">
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <div class="container mx-auto px-4 z-20 relative py-20">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">نمونه کارهای <span class="gradient-text">NextPixel</span></h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">برخی از پروژه‌های موفق که با همکاری تیم حرفه‌ای ما اجرا شده‌اند</p>
            </div>
        </div>
    </section>

    <!-- Portfolio Content -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <!-- Filter Buttons -->
            <div id="filter-buttons" class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up">
                <button data-filter="all" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all active">همه</button>
                <button data-filter="store" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">وبسایت فروشگاهی</button>
                <button data-filter="service" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">وبسایت خدماتی</button>
                <button data-filter="landing" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">لندینگ پیج</button>
            </div>

            <!-- Portfolio Grid -->
            <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Portfolio Item 1: HCH Perfume -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="store" data-aos="fade-up">
                    <a href="https://hchperfume.ir" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                        <img src="/src/hchperfume.png" alt="سایت عطر هات چاکلت" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">عطر هات چاکلت</h3>
                            <span class="text-xs bg-blue-900/30 text-blue-400 px-3 py-1 rounded-full whitespace-nowrap">فروشگاهی</span>
                        </div>
                        <p class="text-gray-400 mb-4">عرضه انواع عطر های وارداتی بدون واسطه و اولین تست هوشمند شخصیت شناسی عطر</p>
                        <a href="https://hchperfume.ir" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Portfolio Item 2: Radepa Shoes -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="store" data-aos="fade-up">
                    <a href="https://radepamashhad.ir/" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                        <img src="/src/radepamashhad.png" alt="سایت کفش ردپا مشهد" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">کفش ردپا مشهد</h3>
                            <span class="text-xs bg-blue-900/30 text-blue-400 px-3 py-1 rounded-full whitespace-nowrap">فروشگاهی</span>
                        </div>
                        <p class="text-gray-400 mb-4">نمایندگی رسمی کفش ردپا در مشهد و ارائه بهترین و با کیفیت ترین ها </p>
                        <a href="https://radepamashhad.ir" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Portfolio Item 3: Aasbad Bicycles -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="store" data-aos="fade-up">
                    <a href="https://aasbad.ir" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                        <img src="/src/aasbad.png" alt="فروشگاه دوچرخه آس باد" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">دوچرخه آس باد</h3>
                            <span class="text-xs bg-blue-900/30 text-blue-400 px-3 py-1 rounded-full whitespace-nowrap">فروشگاهی</span>
                        </div>
                        <p class="text-gray-400 mb-4">مرکز فروش و تعمیرات تخصصی دوچرخه</p>
                         <a href="https://aasbad.ir" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Portfolio Item 4: Mahnaz Helmi Beauty -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="service" data-aos="fade-up">
                    <a href="https://mahnazhelmi.ir" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                        <img src="/src/mahnazbeauty.png" alt="مجموعه زیبایی مهناز حلمی" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">زیبایی مهناز حلمی</h3>
                            <span class="text-xs bg-purple-900/30 text-purple-400 px-3 py-1 rounded-full whitespace-nowrap">خدماتی</span>
                        </div>
                        <p class="text-gray-400 mb-4">ارائه دهنده خدمات تخصصی زیبایی و آرایشی در فریمان</p>
                        <a href="https://mahnazhelmi.ir" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Portfolio Item 5: jahanphone -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="service" data-aos="fade-up">
                    <a href="https://JahanPhone.ir" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                       <img src="/src/jahanphone.png" alt="جهان فون" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">عرضه انواع گجت</h3>
                            <span class="text-xs bg-purple-900/30 text-purple-400 px-3 py-1 rounded-full whitespace-nowrap">خدماتی</span>
                        </div>
                        <p class="text-gray-400 mb-4">ارائه بروز ترین گجت ها و چت بات تعمیر آنلاین گوشی با هوش مصنوعی</p>
                        <a href="https://wpun.ir" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Portfolio Item 6: NextPixel Landing -->
                <div class="portfolio-card glass-effect rounded-2xl" data-category="landing" data-aos="fade-up">
                     <a href="https://hojat.sbs/" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                       <img src="/src/npixel.png" alt="لندینگ پیج نکست پیکسل" class="w-full h-56 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold">لندینگ نکست پیکسل</h3>
                            <span class="text-xs bg-amber-900/30 text-amber-400 px-3 py-1 rounded-full whitespace-nowrap">لندینگ</span>
                        </div>
                        <p class="text-gray-400 mb-4">صفحه فرود و معرفی خدمات مجموعه نکست پیکسل</p>
                        <a href="https://hojat.sbs" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center">
                            مشاهده وبسایت
                            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="glass-effect p-8 md:p-12 rounded-2xl text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">آماده شروع پروژه هستید؟</h2>
                <p class="text-gray-300 mb-8 max-w-2xl mx-auto">برای دریافت مشاوره رایگان و شروع همکاری با ما، با ما در تماس باشید</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                    <a href="contact.php" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105">تماس با ما</a>
                    <a href="services.php" class="border border-blue-400 text-blue-400 hover:bg-blue-400/10 px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105">مشاهده خدمات</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Mobile Menu Toggle ---
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = menuBtn.querySelector('i');

            const toggleMenu = () => {
                const isMenuOpen = !mobileMenu.classList.contains('translate-x-full');
                mobileMenu.classList.toggle('translate-x-full');
                
                if (isMenuOpen) {
                    menuIcon.setAttribute('data-feather', 'menu');
                } else {
                    menuIcon.setAttribute('data-feather', 'x');
                }
                feather.replace({ width: '28px', height: '28px' });
            };

            menuBtn.addEventListener('click', toggleMenu);
            
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', toggleMenu);
            });

            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                mirror: false
            });

            // Initialize Feather Icons
            feather.replace();

            // === iOS Glass Header Scroll Effect ===
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

            // --- Portfolio Filter Logic ---
            const filterButtons = document.querySelectorAll('#filter-buttons .filter-btn');
            const portfolioItems = document.querySelectorAll('#portfolio-grid .portfolio-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    portfolioItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        const shouldShow = filterValue === 'all' || filterValue === itemCategory;
                        
                        anime({
                            targets: item,
                            opacity: shouldShow ? [0, 1] : [1, 0],
                            scale: shouldShow ? [0.9, 1] : 0.9,
                            duration: 400,
                            easing: 'easeOutQuad',
                            begin: () => {
                                if (shouldShow) {
                                    item.style.display = 'block';
                                }
                            },
                            complete: () => {
                                if (!shouldShow) {
                                    item.style.display = 'none';
                                }
                            }
                        });
                    });
                });
            });
        });

    </script>
</body>
</html>
