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

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <style>
        /* Header Styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(15, 23, 42, 0.85);
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 0;
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        header.scrolled {
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1280px;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        @media (min-width: 768px) {
            .header-container {
                padding: 1rem 2rem;
            }
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .header-logo img {
            height: 40px;
            width: auto;
            max-width: 100%;
            transition: transform 0.3s;
        }

        .header-logo:hover img {
            transform: scale(1.05);
        }

        .header-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .header-logo-text {
                font-size: 1.1rem;
            }
        }

        .header-nav {
            display: none;
        }

        @media (min-width: 768px) {
            .header-nav {
                display: flex;
                align-items: center;
                gap: 2rem;
                flex: 1;
                margin: 0 2rem;
            }

            .header-nav a {
                color: #f8fafc;
                text-decoration: none;
                font-weight: 500;
                font-size: 0.95rem;
                transition: all 0.3s;
                position: relative;
                padding-bottom: 0.25rem;
            }

            .header-nav a::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                transition: width 0.3s;
            }

            .header-nav a:hover::after,
            .header-nav a.active::after {
                width: 100%;
            }

            .header-nav a:hover,
            .header-nav a.active {
                color: #60a5fa;
            }
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        @media (max-width: 767px) {
            .header-actions {
                gap: 0.25rem;
            }
        }

        .header-btn {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.8rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.3s;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .header-btn {
                padding: 0.5rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        .header-btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .header-btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }

        .header-btn-success {
            background-color: #16a34a;
            color: white;
        }

        .header-btn-success:hover {
            background-color: #15803d;
            transform: translateY(-2px);
        }

        .header-btn-purple {
            background-color: #a855f7;
            color: white;
        }

        .header-btn-purple:hover {
            background-color: #9333ea;
            transform: translateY(-2px);
        }

        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            transition: all 0.3s;
            padding: 0;
        }

        .menu-toggle:hover {
            transform: scale(1.1);
        }

        @media (min-width: 768px) {
            .menu-toggle {
                display: none;
            }
        }

        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            top: 70px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 999;
            overflow-y: auto;
        }

        .mobile-menu.active {
            display: flex;
            flex-direction: column;
            animation: slideInFromTop 0.3s ease-out forwards;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-menu-content {
            padding: 2rem 1.5rem;
        }

        .mobile-menu-section {
            margin-bottom: 2rem;
        }

        .mobile-menu-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .mobile-menu-links a {
            color: #f8fafc;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            font-weight: 500;
        }

        .mobile-menu-links a:hover,
        .mobile-menu-links a.active {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            transform: translateX(-0.5rem);
        }

        .mobile-menu-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .mobile-menu-buttons .header-btn {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1rem;
        }

        @media (min-width: 768px) {
            .mobile-menu {
                display: none !important;
            }
        }
    </style>

    <!-- Header -->
    <header class="header-main" id="main-header">
        <div class="header-container">
            <a href="/" class="header-logo">
                <img src="/assets/img/NeXTPixel.png" alt="NeXTPixel" />
                <span class="header-logo-text">NeXTPixel</span>
            </a>

            <nav class="header-nav" id="desktop-nav">
                <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
                <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
                <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
                <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
                <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
            </nav>

            <div class="header-actions">
                <?php if ($isLoggedIn): ?>
                    <?php if ($isN8NAdmin): ?>
                        <a href="/n8n-admin.php" class="header-btn header-btn-success" title="مدیریت n8n">
                            <i data-feather="zap" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">n8n</span>
                        </a>
                    <?php endif; ?>
                    <a href="/panel/" class="header-btn header-btn-purple">
                        <span class="hidden sm:inline"><?php echo htmlspecialchars($username); ?></span>
                        <span class="sm:hidden"><?php echo substr(htmlspecialchars($username), 0, 1); ?></span>
                    </a>
                <?php else: ?>
                    <a href="/login.php" class="header-btn header-btn-primary">
                        ورود
                    </a>
                <?php endif; ?>

                <button class="menu-toggle" id="menu-toggle" aria-label="منو">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-section">
                <div class="mobile-menu-section-title">القائمة</div>
                <div class="mobile-menu-links">
                    <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
                    <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
                    <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
                    <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
                    <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
                </div>
            </div>

            <?php if (!$isLoggedIn): ?>
            <div class="mobile-menu-section">
                <div class="mobile-menu-buttons">
                    <a href="/login.php" class="header-btn header-btn-primary">
                        ورود
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <main style="padding-top: 70px;">
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

        // Header Scroll Detection with smooth animation
        let headerScrollTimeout;
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            if (window.scrollY > 100) {
                if (!header.classList.contains('scrolled')) {
                    header.classList.add('scrolled');
                }
            } else {
                if (header.classList.contains('scrolled')) {
                    header.classList.remove('scrolled');
                }
            }
        }, { passive: true });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-menu-links a');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('header') && !e.target.closest('.mobile-menu')) {
                mobileMenu.classList.remove('active');
            }
        });

        // Active link highlighting
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        const navLinks = document.querySelectorAll('.header-nav a, .mobile-menu-links a');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === '/' && (currentPage === '' || currentPage === 'index.php')) {
                link.classList.add('active');
            } else if (href === `/${currentPage}` || href === currentPage) {
                link.classList.add('active');
            }
        });
