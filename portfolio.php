<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';
$isN8NAdmin = $isLoggedIn;

// --- لیست پروژه ها و تنظیمات ---
$portfolioItems = [
    // --- پروژه جدید: فروشگاه مبلمان (معمولی/لینک مستقیم) ---
    [
        'id' => 'furniture_store',
        'title' => 'فروشگاه مبلمان',
        'category' => 'store',
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-orange-900/30',
        'badge_text' => 'text-orange-400',
        'img' => '/src/mobl.png', 
        'url' => 'http://furniture1.armanmc.ir/', 
        'desc' => 'فروشگاه آنلاین مبلمان با طراحی مدرن و رابط کاربری جذاب (React)',
        'ajax' => false // لود معمولی و مستقیم
    ],
    // --- پروژه‌های هوشمند (AJAX - Vercel) ---
    [
        'id' => 'batis_modern',
        'title' => 'باتیس مدرن',
        'category' => 'landing',
        'category_fa' => 'شرکتی',
        'badge_bg' => 'bg-emerald-900/30',
        'badge_text' => 'text-emerald-400',
        'img' => '/src/batis.png', 
        'url' => 'https://batis-modern.vercel.app', 
        'desc' => 'طراحی مدرن و مینیمال با استفاده از تکنولوژی‌های روز دنیا',
        'ajax' => true // لود از طریق سرور (هوشمند)
    ],
    [
        'id' => 'etehad_store',
        'title' => 'فروشگاه اتحاد',
        'category' => 'store',
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-blue-900/30',
        'badge_text' => 'text-blue-400',
        'img' => '/src/etehad.png',
        'url' => 'https://etehad.vercel.app/', 
        'desc' => 'فروشگاه تخصصی لپ‌تاپ استوک با طراحی واکنش‌گرا (React)',
        'ajax' => true // لود از طریق سرور (هوشمند)
    ],
    // --- سایر پروژه‌های معمولی ---
    [
        'id' => 'noormah_bookcity',
        'title' => 'شهر کتاب نورماه',
        'category' => 'store', 
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-indigo-900/30', 
        'badge_text' => 'text-indigo-400',
        'img' => '/src/noormah.png', 
        'url' => 'https://noormahbookcity.ir', 
        'desc' => 'پروژه وردپرسی تمام اختصاصی (طراحی شده از صفر) برای شهر کتاب نورماه',
        'ajax' => false 
    ],
    [
        'id' => 'hchperfume',
        'title' => 'عطر هات چاکلت',
        'category' => 'store',
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-blue-900/30',
        'badge_text' => 'text-blue-400',
        'img' => '/src/hchperfume.png',
        'url' => 'https://hchperfume.ir',
        'desc' => 'عرضه انواع عطر های وارداتی بدون واسطه و اولین تست هوشمند شخصیت شناسی عطر',
        'ajax' => false
    ],
    [
        'id' => 'radepa',
        'title' => 'کفش ردپا مشهد',
        'category' => 'store',
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-blue-900/30',
        'badge_text' => 'text-blue-400',
        'img' => '/src/radepamashhad.png',
        'url' => 'https://radepamashhad.ir/',
        'desc' => 'نمایندگی رسمی کفش ردپا در مشهد و ارائه بهترین و با کیفیت ترین ها',
        'ajax' => false
    ],
    [
        'id' => 'aasbad',
        'title' => 'دوچرخه آس باد',
        'category' => 'store',
        'category_fa' => 'فروشگاهی',
        'badge_bg' => 'bg-blue-900/30',
        'badge_text' => 'text-blue-400',
        'img' => '/src/aasbad.png',
        'url' => 'https://aasbad.ir',
        'desc' => 'مرکز فروش و تعمیرات تخصصی دوچرخه',
        'ajax' => false
    ],
    [
        'id' => 'mahnazhelmi',
        'title' => 'زیبایی مهناز حلمی',
        'category' => 'service',
        'category_fa' => 'خدماتی',
        'badge_bg' => 'bg-purple-900/30',
        'badge_text' => 'text-purple-400',
        'img' => '/src/mahnazbeauty.png',
        'url' => 'https://mahnazhelmi.ir',
        'desc' => 'ارائه دهنده خدمات تخصصی زیبایی و آرایشی در فریمان',
        'ajax' => false
    ],
    [
        'id' => 'jahanphone',
        'title' => 'عرضه انواع گجت',
        'category' => 'service',
        'category_fa' => 'خدماتی',
        'badge_bg' => 'bg-purple-900/30',
        'badge_text' => 'text-purple-400',
        'img' => '/src/jahanphone.png',
        'url' => 'https://JahanPhone.ir',
        'desc' => 'ارائه بروز ترین گجت ها و چت بات تعمیر آنلاین گوشی با هوش مصنوعی',
        'ajax' => false
    ],
    [
        'id' => 'nextpixel_landing',
        'title' => 'لندینگ نکست پیکسل',
        'category' => 'landing',
        'category_fa' => 'لندینگ',
        'badge_bg' => 'bg-amber-900/30',
        'badge_text' => 'text-amber-400',
        'img' => '/src/npixel.png',
        'url' => 'https://hojat.sbs/',
        'desc' => 'صفحه فرود و معرفی خدمات مجموعه نکست پیکسل',
        'ajax' => false
    ]
];
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
            display: flex;
            flex-direction: column;
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
        
        .loading-pulse {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3b82f6;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }

        /* Placeholder styles for AJAX content */
        .ajax-placeholder {
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
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

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <style>
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
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: calc(100vh - 70px);
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.98));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 990;
            overflow-y: auto;
            overflow-x: hidden;
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
    <section class="min-h-[60vh] flex items-center relative overflow-hidden dynamic-bg">
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <div class="container mx-auto px-4 z-20 relative py-20">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">نمونه کارهای <span class="gradient-text">NextPixel</span></h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">برخی از پروژه‌های موفق که با همکاری تیم حرفه‌ای ما اجرا شده‌اند</p>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-4">
            <div id="filter-buttons" class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up">
                <button data-filter="all" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all active">همه</button>
                <button data-filter="store" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">وبسایت فروشگاهی</button>
                <button data-filter="service" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">وبسایت خدماتی</button>
                <button data-filter="landing" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">لندینگ پیج</button>
                <button data-filter="react" class="filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all">وب اپلیکیشن (React)</button>
            </div>

            <div id="loading-indicator" class="text-center mb-8" style="display: none;">
                <div class="loading-pulse"></div>
                <span class="mr-2 text-blue-400">در حال دریافت پروژه‌های هوشمند از سرور...</span>
            </div>

            <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($portfolioItems as $item): ?>
                    <?php if ($item['ajax']): ?>
                        <!-- AJAX Placeholder for <?php echo htmlspecialchars($item['title']); ?> -->
                        <div id="project-<?php echo htmlspecialchars($item['id']); ?>" 
                             class="portfolio-card glass-effect rounded-2xl ajax-placeholder" 
                             data-category="<?php echo htmlspecialchars($item['category']); ?>" 
                             data-aos="fade-up"
                             data-project-id="<?php echo htmlspecialchars($item['id']); ?>">
                            <div class="loading-pulse"></div>
                            <p class="mt-4 text-gray-500 text-sm">در حال بارگذاری <?php echo htmlspecialchars($item['title']); ?>...</p>
                        </div>
                    <?php else: ?>
                        <!-- Static Item: <?php echo htmlspecialchars($item['title']); ?> -->
                        <div class="portfolio-card glass-effect rounded-2xl" data-category="<?php echo htmlspecialchars($item['category']); ?>" data-aos="fade-up">
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">
                                <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-56 object-cover">
                            </a>
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold"><?php echo htmlspecialchars($item['title']); ?></h3>
                                    <span class="text-xs <?php echo $item['badge_bg']; ?> <?php echo $item['badge_text']; ?> px-3 py-1 rounded-full whitespace-nowrap"><?php echo htmlspecialchars($item['category_fa']); ?></span>
                                </div>
                                <p class="text-gray-400 mb-4 flex-grow"><?php echo htmlspecialchars($item['desc']); ?></p>
                                <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center mt-auto">
                                    مشاهده وبسایت
                                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

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
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                mirror: false
            });

            feather.replace();

            const header = document.getElementById('main-header');
            if (header) {
                window.addEventListener('scroll', () => {
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
            }

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

            loadInternalProjects();
        });

        function loadInternalProjects() {
            const container = document.getElementById('ajax-projects-container');
            const loader = document.getElementById('loading-projects');
            
            // Note: In this version, we are using placeholders in the grid, 
            // so we might target specific divs instead of a single container.
            // But let's keep the existing logic compatible.
            
            // Check if we have placeholders waiting for data
            const placeholders = document.querySelectorAll('.ajax-placeholder');
            if (placeholders.length === 0) return;

            if(loader) loader.style.display = 'block';

            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'load_internal_projects.php', true);
            
            xhr.onload = function() {
                if(loader) loader.style.display = 'none';
                if (xhr.status === 200) {
                    try {
                        const projectsData = JSON.parse(xhr.responseText);
                        
                        placeholders.forEach(placeholder => {
                            const projectId = placeholder.getAttribute('data-project-id');
                            if (projectsData[projectId]) {
                                placeholder.outerHTML = projectsData[projectId];
                            } else {
                                placeholder.innerHTML = '<p class="text-red-400">خطا در بارگذاری</p>';
                            }
                        });

                        feather.replace();
                        initFilters();
                        
                        // Initialize iframe loaders if any
                        if (typeof initIframeLoaders === 'function') {
                            initIframeLoaders();
                        }
                        
                        setTimeout(() => {
                            AOS.refresh();
                        }, 500);
                    } catch(e) {
                        console.error('JSON Error', e);
                    }
                } else {
                    console.error('Failed to load internal projects');
                }
            };
            
            xhr.onerror = function() {
                if(loader) loader.style.display = 'none';
                console.error('Network error occurred');
            };

            xhr.send();
        }

        // ... existing initIframeLoaders and initFilters ...
        function initIframeLoaders() {
            const containers = document.querySelectorAll('.iframe-container');
            containers.forEach(container => {
                if (container.dataset.loaded === 'true') return;
                container.dataset.loaded = 'true';

                const iframe = container.querySelector('iframe');
                const progressBar = container.querySelector('.progress-bar');
                
                if (!iframe || !progressBar) return;

                let width = 0;
                const interval = setInterval(() => {
                    if (width < 90) {
                        width += Math.random() * 10;
                        if (width > 90) width = 90;
                        progressBar.style.width = width + '%';
                    }
                }, 200);

                iframe.onload = () => {
                    clearInterval(interval);
                    progressBar.style.width = '100%';
                    iframe.classList.remove('opacity-0');
                    setTimeout(() => {
                        if(progressBar.parentElement) progressBar.parentElement.style.opacity = '0';
                    }, 500);
                };
            });
        }

        function initFilters() {
            const filterButtons = document.querySelectorAll('#filter-buttons .filter-btn');
            
            filterButtons.forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            const newFilterButtons = document.querySelectorAll('#filter-buttons .filter-btn');

            newFilterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    newFilterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');
                    const allPortfolioItems = document.querySelectorAll('#portfolio-grid .portfolio-card');

                    allPortfolioItems.forEach(item => {
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
                                    item.style.display = 'flex';
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
        }
    </script>
</body>
</html>