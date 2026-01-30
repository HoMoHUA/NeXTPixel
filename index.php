<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';
$isN8NAdmin = $isLoggedIn;

if (isset($_POST['logout'])) {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>نکست پیکسل | طراحی وبسایت حرفه‌ای، فروشگاهی و سئو</title>
    <meta name="description" content="نکست پیکسل: طراحی تخصصی سایت فروشگاهی و شرکتی با وردپرس و کدنویسی اختصاصی. با بهینه‌سازی سئو، فروش خود را چند برابر کنید. دریافت مشاوره رایگان.">
    <link rel="canonical" href="https://nextpixel.top/">
    
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://nextpixel.top/">
    <meta property="og:title" content="NextPixel | طراحی وبسایت حرفه‌ای، فروشگاهی و سئو">
    <meta property="og:description" content="طراحی تخصصی سایت فروشگاهی و شرکتی. با بهینه‌سازی سئو، فروش خود را چند برابر کنید.">
    <meta property="og:image" content="https://nextpixel.ir/static/social-preview.jpg">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://nextpixel.top">
    <meta property="twitter:title" content="NextPixel | طراحی وبسایت حرفه‌ای، فروشگاهی و سئو">
    <meta property="twitter:description" content="طراحی تخصصی سایت فروشگاهی و شرکتی. با بهینه‌سازی سئو، فروش خود را چند برابر کنید.">
    <meta property="twitter:image" content="https://nextpixel.ir/static/social-preview.jpg">

    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwindcss.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
    <script src="/assets/js/vendor/lottie-player.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/vanta.globe.min.js" defer></script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "NextPixel",
      "url": "https://nextpixel.ir/",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+98-935-350-3747",
        "contactType": "customer service"
      },
      "sameAs": [
        "https://www.instagram.com/hoseinih3",
        "https://www.linkedin.com/in/hoseinih1"
      ]
    }
    </script>
</head>
<body class="overflow-x-hidden">
<div id="video-preloader">
    <div class="progress-bar-container">
        <div id="progress-bar-fill"></div>
    </div>
    
    <video id="preloader-video-mobile" class="video-player" muted playsinline></video>
    <video id="preloader-video-desktop" class="video-player" muted playsinline></video>
</div>

    <header>
        <nav class="ios-glass-header sticky top-0 z-50 flex justify-between items-center py-3 md:py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
            <a href="/" class="text-2xl font-bold text-white flex items-center space-x-reverse space-x-2">
                <img src="/assets/img/NeXTPixel.png" alt="NeXTPixel" class="h-8 w-8 md:h-10 md:w-10 object-contain">
                <span class="text-white font-bold" style="font-weight: 900;">NextPixel</span>
            </a>
            <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                <a href="services.php" class="hover:text-blue-400 transition">خدمات</a>
                <a href="about.php" class="hover:text-blue-400 transition">درباره ما</a>
                <a href="portfolio.php" class="hover:text-blue-400 transition">نمونه کارها</a>
                <a href="contact.php" class="hover:text-amber-400 transition">تماس با ما</a>
                
                <?php if ($isLoggedIn): ?>
                    <?php if ($isN8NAdmin): ?>
                        <a href="n8n-admin.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full font-medium transition-all text-sm">
                            <i data-feather="zap" class="w-4 h-4 inline ml-1"></i>
                            مدیریت n8n
                        </a>
                    <?php endif; ?>
                    <?php
                    $userRole = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
                    $panelLink = '/panel/';
                    
                    if ($userRole) {
                        switch ($userRole) {
                            case 'customer':
                            case 'client':
                                $panelLink = '/panel/client/index.php';
                                break;
                            case 'seller':
                                $panelLink = '/panel/seller/dashboard.php';
                                break;
                            case 'designer':
                                $panelLink = '/panel/designer/index.php';
                                break;
                            case 'admin':
                                $panelLink = '/panel/index.php';
                                break;
                            default:
                                $panelLink = '/panel/index.php';
                                break;
                        }
                    }
                    ?>
                    <a href="<?php echo $panelLink; ?>" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full font-medium transition-all text-sm">
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
                <a href="services.php" class="hover:text-blue-400 transition text-white">خدمات</a>
                <a href="about.php" class="hover:text-blue-400 transition text-white">درباره ما</a>
                <a href="portfolio.php" class="hover:text-blue-400 transition text-white">نمونه کارها</a>
                <a href="contact.php" class="hover:text-amber-400 transition text-white">تماس با ما</a>
                
                <?php if ($isLoggedIn): ?>
                    <?php if ($isN8NAdmin): ?>
                        <a href="n8n-admin.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full text-xl transition-all mb-4">
                            مدیریت n8n
                        </a>
                    <?php endif; ?>
                    <?php
                    $userRole = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
                    $panelLink = '/panel/';
                    
                    if ($userRole) {
                        switch ($userRole) {
                            case 'customer':
                            case 'client':
                                $panelLink = '/panel/client/index.php';
                                break;
                            case 'seller':
                                $panelLink = '/panel/seller/dashboard.php';
                                break;
                            case 'designer':
                                $panelLink = '/panel/designer/index.php';
                                break;
                            case 'admin':
                                $panelLink = '/panel/index.php';
                                break;
                            default:
                                $panelLink = '/panel/index.php';
                                break;
                        }
                    }
                    ?>
                    <a href="<?php echo $panelLink; ?>" class="cta-button text-white px-6 py-3 rounded-full text-xl">
                        پنل کاربری (<?php echo htmlspecialchars($username); ?>)
                    </a>
                <?php else: ?>
                    <a href="login.php" class="cta-button text-white px-6 py-3 rounded-full text-xl">
                        ورود اعضا
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div id="hero-3d-container" class="min-h-screen flex flex-col relative overflow-hidden -mt-[88px]">
            <div class="absolute inset-0 hero-3d-bg"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60 z-10"></div>
            
            <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl hero-3d-element" style="animation-delay: 0s;"></div>
            <div class="absolute top-40 right-20 w-40 h-40 bg-purple-500/20 rounded-full blur-3xl hero-3d-element" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-32 left-1/4 w-36 h-36 bg-pink-500/20 rounded-full blur-3xl hero-3d-element" style="animation-delay: 2s;"></div>
            
            <div class="container mx-auto px-4 z-20 relative flex-grow flex items-center pt-[88px]">
                <div class="text-center w-full py-20 hero-3d-content">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight hero-3d-title">
                        <span class="hero-3d-word" style="animation-delay: 0.1s;">فروش</span>
                        <span class="hero-3d-word" style="animation-delay: 0.2s;">خود</span>
                        <span class="hero-3d-word" style="animation-delay: 0.3s;">را</span>
                        <span class="hero-3d-word gradient-text" style="animation-delay: 0.4s;">چند</span>
                        <span class="hero-3d-word gradient-text" style="animation-delay: 0.5s;">برابر</span>
                        <span class="hero-3d-word gradient-text" style="animation-delay: 0.6s;">کنید</span>
                        <br class="hidden sm:inline">
                        <span class="hero-3d-word" style="animation-delay: 0.7s;">با</span>
                        <span class="hero-3d-word" style="animation-delay: 0.8s;">ایجاد</span>
                        <span class="hero-3d-word" style="animation-delay: 0.9s;">پلتفرم</span>
                        <span class="hero-3d-word" style="animation-delay: 1s;">فروش</span>
                        <span class="hero-3d-word" style="animation-delay: 1.1s;">هوشمند</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto hero-3d-text">طراحی اختصاصی سایت فروشگاهی با افزایش ۳۰۰% نرخ تبدیل، سئوی حرفه‌ای برای دیده شدن در گوگل و رابط کاربری جذاب برای مشتریان شما.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse mt-6 hero-3d-buttons">
                        <a href="#contact" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105 hero-3d-btn">دریافت مشاوره رایگان</a>
                        <a href="services.php" class="border border-blue-400 text-blue-400 hover:bg-blue-400/10 px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105 hero-3d-btn">بررسی پلن ها</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main>
        <section id="services" class="py-20 bg-gradient-to-b from-slate-900/50 via-slate-900/30 to-slate-900/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                        <span class="gradient-text">خدمات تخصصی</span> ما
                    </h2>
                    <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto px-4 leading-relaxed">
                        با تیم حرفه‌ای NextPixel، کسب و کار خود را به سطح جدیدی ببرید. از طراحی وبسایت تا اتوماسیون هوشمند فرآیندها
                    </p>
                    <a href="services.php" class="inline-flex items-center mt-6 text-blue-400 hover:text-blue-300 transition-all group">
                        <span>مشاهده پلن‌های قیمت‌گذاری</span>
                        <i data-feather="arrow-left" class="w-5 h-5 mr-2 inline group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-8">
                    
                    <article class="glass-effect p-6 lg:p-8 rounded-2xl service-card-3d magnetic-hover group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center mb-6 icon-glow group-hover:scale-110 transition-transform">
                                <i data-feather="layout" class="w-7 h-7 lg:w-8 lg:h-8 text-blue-400"></i>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold mb-3 group-hover:text-blue-300 transition-colors">طراحی وبسایت با وردپرس</h3>
                            <p class="text-sm lg:text-base text-gray-400 leading-relaxed">طراحی سایت اختصاصی و حرفه‌ای با سیستم مدیریت محتوای وردپرس، کاملا ریسپانسیو و بهینه‌شده.</p>
                        </div>
                    </article>

                    <article class="glass-effect p-6 lg:p-8 rounded-2xl service-card-3d magnetic-hover group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-full blur-2xl transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-xl flex items-center justify-center mb-6 icon-glow group-hover:scale-110 transition-transform">
                                <i data-feather="code" class="w-7 h-7 lg:w-8 lg:h-8 text-purple-400"></i>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold mb-3 group-hover:text-purple-300 transition-colors">برنامه نویسی اختصاصی</h3>
                            <p class="text-sm lg:text-base text-gray-400 leading-relaxed">توسعه نرم‌افزارهای وب و موبایل با آخرین تکنولوژی‌ها و معماری‌های مقیاس‌پذیر.</p>
                        </div>
                    </article>

                    <article class="glass-effect p-6 lg:p-8 rounded-2xl service-card-3d magnetic-hover group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-green-500/10 rounded-full blur-2xl transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center mb-6 icon-glow group-hover:scale-110 transition-transform">
                                <i data-feather="zap" class="w-7 h-7 lg:w-8 lg:h-8 text-green-400"></i>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold mb-3 group-hover:text-green-300 transition-colors">اتوماسیون n8n</h3>
                            <p class="text-sm lg:text-base text-gray-400 leading-relaxed">اتوماسیون هوشمند فرآیندهای کسب و کار شما با قدرتمندترین پلتفرم workflow. یکپارچه‌سازی سیستم‌ها بدون نیاز به کدنویسی.</p>
                        </div>
                    </article>

                    <article class="glass-effect p-6 lg:p-8 rounded-2xl service-card-3d magnetic-hover group relative overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-pink-500/10 rounded-full blur-2xl transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-pink-500/20 to-rose-600/20 rounded-xl flex items-center justify-center mb-6 icon-glow group-hover:scale-110 transition-transform">
                                <i data-feather="trending-up" class="w-7 h-7 lg:w-8 lg:h-8 text-pink-400"></i>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold mb-3 group-hover:text-pink-300 transition-colors">سئو و بهینه‌سازی</h3>
                            <p class="text-sm lg:text-base text-gray-400 leading-relaxed">بهبود رتبه سایت در نتایج جستجو و افزایش ترافیک ارگانیک با استراتژی‌های سئوی حرفه‌ای و طراحی UI/UX کاربرپسند.</p>
                        </div>
                    </article>

                    <article class="glass-effect p-6 lg:p-8 rounded-2xl service-card-3d magnetic-hover group relative overflow-hidden" data-aos="fade-up" data-aos-delay="500">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-full blur-2xl transform group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 rounded-xl flex items-center justify-center mb-6 icon-glow group-hover:scale-110 transition-transform">
                                <i data-feather="message-circle" class="w-7 h-7 lg:w-8 lg:h-8 text-indigo-400"></i>
                            </div>
                            <h3 class="text-lg lg:text-xl font-bold mb-3 group-hover:text-indigo-300 transition-colors">چت بات هوشمند</h3>
                            <p class="text-sm lg:text-base text-gray-400 leading-relaxed">ارائه خدمات 24/7 به مشتریان با هوش مصنوعی پیشرفته. پاسخگویی خودکار و افزایش نرخ تبدیل.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="about" class="py-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0 px-4" data-aos="fade-right">
                        <div class="glass-effect liquid-morph overflow-hidden">
                            <img src="https://nextpixel.top/src/nextpixelteam.png" alt="تیم نکست پیکسل" class="rounded-2xl w-full h-auto object-cover">
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pr-10" data-aos="fade-left">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">تیم حرفه‌ای NextPixel</h2>
                        <p class="text-gray-400 mb-6 leading-relaxed">ما در NextPixel با ترکیب خلاقیت و تکنولوژی، راه‌حل‌های دیجیتالی منحصر به فردی ارائه می‌دهیم. تیم ما متشکل از طراحان، توسعه‌دهندگان و متخصصان سئو است که با سال‌ها تجربه در صنعت وب، آماده تبدیل ایده‌های شما به واقعیت هستند.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio" class="py-20 bg-slate-900/50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">نمونه کارهای ما</h2>
                    <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto px-4">برخی از پروژه‌های انجام شده توسط تیم NextPixel</p>
                </div>
                <div id="portfolioContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="col-span-full text-center text-gray-400 py-8">درحال بارگیری...</div>
                </div>
                <div class="text-center mt-12" data-aos="fade-up">
                    <a href="portfolio.php" class="inline-flex items-center text-blue-400 hover:text-blue-300">
                        مشاهده همه نمونه کارها
                        <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetch('/api/get-portfolios.php?action=featured&limit=6')
                    .then(r => r.json())
                    .then(portfolios => {
                        const container = document.getElementById('portfolioContainer');
                        if (portfolios.error || portfolios.length === 0) {
                            container.innerHTML = '<div class="col-span-full text-center text-gray-400 py-8">هیچ نمونه کاری پیدا نشد</div>';
                            return;
                        }
                        container.innerHTML = portfolios.slice(0, 6).map((p, i) => `
                            <div class="group relative overflow-hidden rounded-2xl" data-aos="fade-up" data-aos-delay="${(i % 3) * 100}">
                                <img src="${p.thumbnail}" alt="${p.image_alt_text || p.title}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110" onerror="this.src='/assets/img/placeholder.png'">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6 opacity-0 group-hover:opacity-100 transition duration-300">
                                    <h3 class="text-xl font-bold text-white mb-2">${p.title}</h3>
                                    <p class="text-sm text-gray-200">${p.description || ''}</p>
                                </div>
                            </div>
                        `).join('');
                        if (window.AOS) AOS.refresh();
                    })
                    .catch(e => console.log('Portfolio load error:', e));
            });
        </script>
        </section>

        <section id="contact" class="py-20">
            <div class="container mx-auto px-4">
                <div class="glass-effect rounded-2xl p-8 md:p-12">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10" data-aos="fade-right">
                            <h2 class="text-3xl md:text-3xl font-bold mb-6 px-4">آماده شروع پروژه هستید؟</h2>
                            <p class="text-gray-400 mb-6 leading-relaxed px-4">برای دریافت مشاوره رایگان و استعلام قیمت، فرم روبرو را پر کنید یا از طریق راه‌های ارتباطی زیر با ما در تماس باشید.</p>
                            <div class="space-y-3 px-4">
                               <div class="flex items-center">
                                    <div class="bg-blue-900/30 rounded-lg p-2 mr-4"><i data-feather="mail" class="w-6 h-6 text-blue-400"></i></div>
                                    <div><a href="mailto:project@hojat.sbs" class="font-medium hover:text-blue-300">project@hojat.sbs</a></div>
                               </div>
                               <div class="flex items-center">
                                    <div class="bg-purple-900/30 rounded-lg p-2 mr-4"><i data-feather="phone" class="w-6 h-6 text-purple-400"></i></div>
                                    <div>
                                        <a href="tel:09150575061" class="font-medium hover:text-purple-300" dir="ltr">0915 057 5061</a>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="md:w-1/2 px-4" data-aos="fade-left">
                            <form class="space-y-6">
                                <div>
                                    <label for="name" class="block mb-2 font-medium">نام و نام خانوادگی</label>
                                    <input type="text" id="name" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="نام شما">
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 font-medium">ایمیل</label>
                                    <input type="email" id="email" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="example@email.com">
                                </div>
                                <div>
                                    <label for="message" class="block mb-2 font-medium">پیام شما</label>
                                    <textarea id="message" rows="4" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="توضیحات پروژه..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-medium transition-all transform hover:scale-105 flex items-center justify-center">
                                    ارسال پیام <i data-feather="send" class="w-5 h-5 mr-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12 bg-slate-900/80">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="mr-2 bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">NextPixel</span>
                    </div>
                    <p class="text-gray-400 text-sm md:text-base max-w-md">تبدیل ایده‌های خلاقانه به تجربه‌های دیجیتالی ماندگار.</p>
                </div>
                <div class="flex space-x-6 space-x-reverse">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Instagram"><i data-feather="instagram" class="w-6 h-6"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Twitter"><i data-feather="twitter" class="w-6 h-6"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="LinkedIn"><i data-feather="linkedin" class="w-6 h-6"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Telegram"><i data-feather="send" class="w-6 h-6"></i></a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 mb-4 md:mb-0">© 2025 NextPixel. تمام حقوق محفوظ است.</p>
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
        
        <div id="chat-window" class="fixed bottom-24 left-4 right-4 md:left-6 md:right-auto z-[2000] w-auto max-w-sm h-[70vh] max-h-[500px] transition-all duration-300 ease-in-out opacity-0 translate-y-4 pointer-events-none">
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

            AOS.init({
                duration: 900,
                easing: 'ease-out-quart',
                once: true,
                mirror: false,
                anchorPlacement: 'top-center'
            });

            feather.replace();

            const header = document.querySelector('.ios-glass-header');
            if (header) {
                let lastScroll = 0;
                const updateHeaderState = () => {
                    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
                    if (currentScroll > 50) {
                        if (!header.classList.contains('scrolled')) {
                            header.classList.add('scrolled');
                            const h = header.getBoundingClientRect().height;
                            document.body.style.paddingTop = `${h}px`;
                        }
                    } else {
                        if (header.classList.contains('scrolled')) {
                            header.classList.remove('scrolled');
                            document.body.style.paddingTop = '0px';
                        }
                    }
                    lastScroll = currentScroll;
                };

                window.addEventListener('scroll', updateHeaderState, { passive: true });
                window.addEventListener('resize', () => {
                    if (header.classList.contains('scrolled')) {
                        const h = header.getBoundingClientRect().height;
                        document.body.style.paddingTop = `${h}px`;
                    }
                });

                updateHeaderState();
            }

            const hero3DContainer = document.getElementById('hero-3d-container');
            if (hero3DContainer && window.innerWidth > 768) {
                hero3DContainer.addEventListener('mousemove', (e) => {
                    const { clientX, clientY } = e;
                    const { width, height, left, top } = hero3DContainer.getBoundingClientRect();
                    const x = (clientX - left - width / 2) / width;
                    const y = (clientY - top - height / 2) / height;
                    
                    const elements = hero3DContainer.querySelectorAll('.hero-3d-element');
                    const title = hero3DContainer.querySelector('.hero-3d-title');
                    const content = hero3DContainer.querySelector('.hero-3d-content');
                    
                    elements.forEach((el, index) => {
                        const speed = (index + 1) * 0.1;
                        el.style.transform = `translate3d(${x * 30 * speed}px, ${y * 30 * speed}px, ${y * 50 * speed}px) rotateY(${x * 5}deg)`;
                    });
                    
                    if (title) {
                        title.style.transform = `translateZ(${y * 30}px) rotateY(${x * 2}deg)`;
                    }
                    
                    if (content) {
                        content.style.transform = `translateZ(${y * 20}px) rotateX(${y * 1}deg)`;
                    }
                });
                
                hero3DContainer.addEventListener('mouseleave', () => {
                    const elements = hero3DContainer.querySelectorAll('.hero-3d-element');
                    const title = hero3DContainer.querySelector('.hero-3d-title');
                    const content = hero3DContainer.querySelector('.hero-3d-content');
                    
                    elements.forEach(el => {
                        el.style.transform = '';
                    });
                    if (title) title.style.transform = '';
                    if (content) content.style.transform = '';
                });
            }

            class LiquidGlassHeader {
                constructor(targetSelector) {
                    this.target = document.querySelector(targetSelector);
                    if (!this.target) return;

                    this.id = 'liquid-header-' + Math.random().toString(36).substr(2, 9);
                    this.mouse = { x: 0.5, y: 0.5 };
                    this.mouseUsed = false;
                    
                    this.init();
                }

                init() {
                    const rect = this.target.getBoundingClientRect();
                    this.width = rect.width;
                    this.height = rect.height;
                    this.setupSVG();
                    this.setupCanvas();

                    this.target.style.backdropFilter = `url(#${this.id}_filter) blur(3px) saturate(180%)`;
                    this.target.style.webkitBackdropFilter = `url(#${this.id}_filter) blur(20px) saturate(180%)`;

                    this.setupEvents();
                    this.update();
                }

                setupSVG() {
                    this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    this.svg.style.cssText = 'position:fixed; top:0; left:0; pointer-events:none; z-index:9998; height:0; width:0;';
                    
                    const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
                    const filter = document.createElementNS('http://www.w3.org/2000/svg', 'filter');
                    filter.setAttribute('id', `${this.id}_filter`);
                    filter.setAttribute('filterUnits', 'userSpaceOnUse');
                    filter.setAttribute('colorInterpolationFilters', 'sRGB');
                    filter.setAttribute('x', '0');
                    filter.setAttribute('y', '0');
                    filter.setAttribute('width', this.width);
                    filter.setAttribute('height', this.height);

                    this.feImage = document.createElementNS('http://www.w3.org/2000/svg', 'feImage');
                    this.feImage.setAttribute('result', 'map');
                    this.feImage.setAttribute('width', this.width);
                    this.feImage.setAttribute('height', this.height);

                    this.feDisplacementMap = document.createElementNS('http://www.w3.org/2000/svg', 'feDisplacementMap');
                    this.feDisplacementMap.setAttribute('in', 'SourceGraphic');
                    this.feDisplacementMap.setAttribute('in2', 'map');
                    this.feDisplacementMap.setAttribute('scale', '40'); 
                    this.feDisplacementMap.setAttribute('xChannelSelector', 'R');
                    this.feDisplacementMap.setAttribute('yChannelSelector', 'G');

                    filter.appendChild(this.feImage);
                    filter.appendChild(this.feDisplacementMap);
                    defs.appendChild(filter);
                    this.svg.appendChild(defs);
                    document.body.appendChild(this.svg);
                }

                setupCanvas() {
                    this.canvas = document.createElement('canvas');
                    this.canvas.width = this.width;
                    this.canvas.height = this.height;
                    this.ctx = this.canvas.getContext('2d');
                }

                setupEvents() {
                    window.addEventListener('scroll', (e) => {
                        const rect = this.target.getBoundingClientRect();
                        this.mouse.x = (e.clientX - rect.left) / rect.width;
                        this.mouse.y = (e.clientY - rect.top) / rect.height;
                        this.mouseUsed = true;
                    });
                    
                    window.addEventListener('mousemove', (e) => {
                         const rect = this.target.getBoundingClientRect();
                         if(e.clientY < rect.bottom + 50) { 
                             this.mouse.x = (e.clientX - rect.left) / rect.width;
                             this.mouse.y = (e.clientY - rect.top) / rect.height;
                             this.mouseUsed = true;
                         }
                    });

                    window.addEventListener('resize', () => {
                        const rect = this.target.getBoundingClientRect();
                        this.width = rect.width;
                        this.height = rect.height;
                        
                        const filter = document.getElementById(`${this.id}_filter`);
                        if(filter) {
                            filter.setAttribute('width', this.width);
                            filter.setAttribute('height', this.height);
                        }
                        this.feImage.setAttribute('width', this.width);
                        this.feImage.setAttribute('height', this.height);

                        this.canvas.width = this.width;
                        this.canvas.height = this.height;
                        this.mouseUsed = true;
                    });
                }

                update() {
                    requestAnimationFrame(() => this.update());
                    
                    if(!this.mouseUsed) return; 

                    const w = this.width;
                    const h = this.height;
                    
                    this.ctx.fillStyle = 'rgba(127, 127, 0, 1)';
                    this.ctx.fillRect(0, 0, w, h);

                    const mx = this.mouse.x * w;
                    const my = this.mouse.y * h;
                    const radius = 200;

                    const grd = this.ctx.createRadialGradient(mx, my, 0, mx, my, radius);
                    grd.addColorStop(0, 'rgba(255, 255, 0, 1)');
                    grd.addColorStop(1, 'rgba(127, 127, 0, 1)');
                    
                    this.ctx.fillStyle = grd;
                    this.ctx.fillRect(0, 0, w, h);

                    this.feImage.setAttributeNS('http://www.w3.org/1999/xlink', 'href', this.canvas.toDataURL());
                }
            }

            new LiquidGlassHeader('.ios-glass-header');

            const chatToggleBtn = document.getElementById('chat-toggle-btn');
            const chatCloseBtn = document.getElementById('chat-close-btn');
            const chatWindow = document.getElementById('chat-window');
            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatSubmitBtn = document.getElementById('chat-submit-btn');

            let messages = []; 
            let isLoading = false;

            const GEMINI_API_KEY = '';

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

                const apiUrl = `https:

                const geminiContents = history
                    .filter(msg => msg.role !== 'system') 
                    .map(msg => ({
                        role: msg.role === 'assistant' ? 'model' : 'user',
                        parts: [{ text: msg.content }]
                    }));

                try {
                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            contents: geminiContents,
                            systemInstruction: {
                                parts: [{ text: SYSTEM_PROMPT }]
                            }
                        })
                    });

                    if (!response.ok) {
                        const errData = await response.json();
                        throw new Error(`API Error (${response.status}): ${errData.error.message}`);
                    }

                    const data = await response.json();

                    const aiResponse = data.candidates?.[0]?.content?.parts?.[0]?.text || "";
                    
                    chatBox.removeChild(chatBox.lastChild); 

                    if (aiResponse.includes('[START_LEAD_SUMMARY]')) {
                        const summaryStartIndex = aiResponse.indexOf('[START_LEAD_SUMMARY]');
                        const summary = aiResponse.substring(summaryStartIndex);
                        await saveLeadToFile(summary);

                        const userMessage = aiResponse.substring(0, summaryStartIndex).trim();
                        if (userMessage) {
                            addMessage('assistant', userMessage);
                            messages.push({ role: 'assistant', content: userMessage });
                        }
                    } else {
                        addMessage('assistant', aiResponse);
                        messages.push({ role: 'assistant', content: aiResponse });
                    }

                } catch (err) {
                    console.error("Error calling Gemini API:", err);
                    chatBox.removeChild(chatBox.lastChild);
                    let errorMessage = `متاسفانه خطایی رخ داد. (${err.message})`;
                    
                    if (err.message.includes('Failed to fetch') || err.message.includes('NetworkError')) {
                        errorMessage = "خطا در ارتباط با سرور. اگر در ایران هستید، لطفا اتصال VPN خود را بررسی کنید.";
                    }
                    
                    addMessage('assistant', errorMessage);
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
                     const welcomeMsg = "سلام! من یونیکس هستم، دستیار هوشمند NextPixel. چطور می‌تونم کمکتون کنم؟";
                     addMessage('assistant', welcomeMsg);
                     messages.push({ role: 'assistant', content: welcomeMsg });
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

const preloader = document.getElementById('video-preloader');
const progressBarFill = document.getElementById('progress-bar-fill');
const progressBarContainer = document.querySelector('.progress-bar-container');
const videoMobile = document.getElementById('preloader-video-mobile');
const videoDesktop = document.getElementById('preloader-video-desktop');
const videoSrcMobile = "src/preloadm.mp4";
const videoSrcDesktop = "src/preload.mp4";

let videoToPlay = null;
let videoSrc = "";

if (window.innerWidth <= 768) {
    videoToPlay = videoMobile;
    videoSrc = videoSrcMobile;
} else {
    videoToPlay = videoDesktop;
    videoSrc = videoSrcDesktop;
}

let preloaderSkipped = false;
const videoRequest = new XMLHttpRequest();

const safetyTimeout = setTimeout(() => {
    console.log('Preloader timeout (5s) reached. Skipping video.');
    preloaderSkipped = true;
    videoRequest.abort();
    hidePreloader();
}, 13000); 
const hidePreloader = () => {
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 1500);
    }
};

videoRequest.open('GET', videoSrc, true);
videoRequest.responseType = 'blob';

videoRequest.addEventListener('progress', (e) => {
    if (e.lengthComputable) {
        const percentComplete = (e.loaded / e.total) * 100;
        if (progressBarFill) {
            progressBarFill.style.width = percentComplete + '%';
        }
    }
});

videoRequest.addEventListener('load', () => {
    if (preloaderSkipped) return; 
    
    clearTimeout(safetyTimeout); 
    
    if ((videoRequest.status === 200 || videoRequest.status === 206) && videoToPlay) {
        const blob = videoRequest.response;
        const videoURL = URL.createObjectURL(blob);
        
        videoToPlay.src = videoURL;

        if (progressBarContainer) {
            progressBarContainer.style.opacity = '0';
        }

        videoToPlay.style.display = 'block';

        const playPromise = videoToPlay.play();

        if (playPromise !== undefined) {
            playPromise.then(() => {

                videoToPlay.addEventListener('ended', hidePreloader);
                videoToPlay.addEventListener('error', (e) => {
                    console.error('Error during video playback:', e);
                    hidePreloader(); 
                });
            }).catch(error => {
                
                console.warn("Video autoplay was blocked, skipping video.", error);
                hidePreloader();
            });
        }
    } else {
        
        hidePreloader();
    }
});

videoRequest.addEventListener('error', () => {
    console.error('XHR error loading video.');
    clearTimeout(safetyTimeout);
    hidePreloader();
});

videoRequest.send();

window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.parallax-element');
    parallaxElements.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

document.querySelectorAll('.magnetic-hover').forEach(element => {
    element.addEventListener('mousemove', (e) => {
        const rect = element.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        element.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px) scale(1.05)`;
    });
    element.addEventListener('mouseleave', () => {
        element.style.transform = 'translate(0, 0) scale(1)';
    });
});

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const textRevealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, observerOptions);

document.querySelectorAll('.text-reveal').forEach(el => {
    textRevealObserver.observe(el);
});

function createParticles() {
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles';
    const heroContainer = document.querySelector('#hero-3d-container');
    if (heroContainer) {
        heroContainer.appendChild(particlesContainer);
    }
    
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 20 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
        particlesContainer.appendChild(particle);
    }
}

if (window.innerWidth > 768) {
    createParticles();
}

document.querySelectorAll('.cta-button').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        btn.style.animation = 'pulse-glow 1s ease-in-out infinite';
    });
    btn.addEventListener('mouseleave', () => {
        btn.style.animation = '';
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });

});

document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px) scale(1.02)`;
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = '';
    });
});

    </script>
</body>
</html>