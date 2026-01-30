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
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تماس با ما | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<<<<<<< Updated upstream
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwind.min.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
    <script src="/assets/js/vendor/anime.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/vanta.waves.min.js" defer></script>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes
    
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
            background: linear-gradient(90deg, #f59e0b, #ef4444);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.2);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3);
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
>>>>>>> Stashed changes
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
            <a href="index.php" class="gradient-text" style="background: linear-gradient(90deg, #f59e0b, #ef4444); -webkit-background-clip: text; background-clip: text; color: transparent;">NextPixel</a>
        </div>
        <div class="hidden md:flex items-center space-x-6 space-x-reverse">
            <a href="index.php" class="hover:text-amber-400 transition">صفحه اصلی</a>
            <a href="services.php" class="hover:text-amber-400 transition">خدمات</a>
            <a href="about.php" class="hover:text-amber-400 transition">درباره ما</a>
            <a href="portfolio.php" class="hover:text-amber-400 transition">نمونه کارها</a>
            <a href="contact.php" class="text-amber-400 font-medium">تماس با ما</a>
            
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
            <a href="index.php" class="hover:text-amber-400 transition text-white">صفحه اصلی</a>
            <a href="services.php" class="hover:text-amber-400 transition text-white">خدمات</a>
            <a href="about.php" class="hover:text-amber-400 transition text-white">درباره ما</a>
            <a href="portfolio.php" class="hover:text-amber-400 transition text-white">نمونه کارها</a>
            <a href="contact.php" class="text-amber-400 font-medium">تماس با ما</a>

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

    <section class="min-h-[60vh] flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-900/20 to-transparent z-10"></div>
        <div class="container mx-auto px-4 z-20 relative py-20">
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">با ما <span class="gradient-text">در ارتباط باشید</span></h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto">برای مشاوره رایگان و شروع پروژه خود، فرم زیر را پر کنید یا از طریق راه‌های ارتباطی با ما تماس بگیرید</p>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <div class="lg:w-2/5 space-y-8" data-aos="fade-right">
                    <div class="glass-effect p-8 rounded-2xl contact-card transition-all duration-300">
                        <h2 class="text-2xl font-bold mb-6 gradient-text">اطلاعات تماس</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-amber-900/30 rounded-lg p-3 mr-4">
                                    <i data-feather="mail" class="w-6 h-6 text-amber-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">ایمیل</h4>
                                    <a href="mailto:project@hojat.sbs" class="text-gray-400 hover:text-amber-300">project@hojat.sbs</a>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-red-900/30 rounded-lg p-3 mr-4">
                                    <i data-feather="phone" class="w-6 h-6 text-red-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">تلفن</h4>
                                    <a href="tel:09150575061" class="text-gray-400 hover:text-amber-300 block" dir="ltr">0915 057 5061</a>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-amber-900/30 rounded-lg p-3 mr-4">
                                    <i data-feather="map-pin" class="w-6 h-6 text-amber-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">آدرس</h4>
                                    <p class="text-gray-400">مشهد، قاسم آباد، برج ایلما، واحد 202</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-effect p-8 rounded-2xl contact-card transition-all duration-300">
                        <h2 class="text-2xl font-bold mb-6 gradient-text">ساعات کاری</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-300">شنبه تا چهارشنبه</span>
                                <span class="font-medium">9:00 - 17:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">پنجشنبه</span>
                                <span class="font-medium">9:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">جمعه</span>
                                <span class="font-medium text-red-400">تعطیل</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-3/5" data-aos="fade-left">
                    <div class="glass-effect p-8 md:p-12 rounded-2xl">
                        <h2 class="text-2xl font-bold mb-8 gradient-text">فرم تماس</h2>
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block mb-2 font-medium">نام و نام خانوادگی</label>
                                    <input type="text" id="name" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 input-focus transition-all" placeholder="نام شما">
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 font-medium">ایمیل</label>
                                    <input type="email" id="email" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 input-focus transition-all" placeholder="example@email.com">
                                </div>
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 font-medium">شماره تماس</label>
                                <input type="tel" id="phone" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 input-focus transition-all" placeholder="۰۹۱۲۳۴۵۶۷۸۹">
                            </div>
                            <div>
                                <label for="subject" class="block mb-2 font-medium">موضوع</label>
                                <select id="subject" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 input-focus transition-all">
                                    <option value="">انتخاب کنید</option>
                                    <option value="design">طراحی وبسایت</option>
                                    <option value="seo">بهینه‌سازی سئو</option>
                                    <option value="consulting">مشاوره</option>
                                    <option value="other">سایر</option>
                                </select>
                            </div>
                            <div>
                                <label for="message" class="block mb-2 font-medium">پیام شما</label>
                                <textarea id="message" rows="5" class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-3 input-focus transition-all" placeholder="توضیحات پروژه..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-red-500 hover:from-amber-600 hover:to-red-600 text-white py-4 px-6 rounded-lg font-medium transition-all transform hover:scale-[1.02] flex items-center justify-center">
                                ارسال پیام
                                <i data-feather="send" class="w-5 h-5 mr-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="fixed bottom-8 left-8 z-50 hidden md:block">
        <div class="space-y-4">
            <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-full flex items-center justify-center shadow-lg floating" style="animation-delay: 0.2s;">
                <i data-feather="phone" class="w-6 h-6"></i>
            </a>
            <a href="#" class="bg-red-600 hover:bg-red-700 text-white p-4 rounded-full flex items-center justify-center shadow-lg floating" style="animation-delay: 0.4s;">
                <i data-feather="message-square" class="w-6 h-6"></i>
            </a>
            <a href="#" class="bg-gradient-to-br from-amber-500 to-red-500 hover:from-amber-600 hover:to-red-600 text-white p-4 rounded-full flex items-center justify-center shadow-lg floating" style="animation-delay: 0.6s;">
                <i data-feather="mail" class="w-6 h-6"></i>
            </a>
        </div>
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
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition" aria-label="Instagram"><i data-feather="instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition" aria-label="Twitter"><i data-feather="twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition" aria-label="LinkedIn"><i data-feather="linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition" aria-label="Telegram"><i data-feather="send"></i></a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 mb-4 md:mb-0">© ۲۰۲۵ NextPixel. تمام حقوق محفوظ است.</p>
                <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                    <div class="flex space-x-6 space-x-reverse text-gray-500">
                        <a href="#" class="hover:text-amber-400 transition">قوانین و مقررات</a>
                        <a href="#" class="hover:text-amber-400 transition">حریم خصوصی</a>
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
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                mirror: false
            });

            feather.replace();

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
        });
    </script>
</body>
</html>
