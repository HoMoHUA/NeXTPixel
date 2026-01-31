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
    <title>درباره ما | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwindcss.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/anime.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
    <script src="/assets/js/vendor/vanta.waves.min.js" defer></script>
    <script src="/assets/js/vendor/lottie-player.min.js" defer></script>
</head>
<body class="overflow-x-hidden">

    <nav class="ios-glass-header sticky top-0 z-50 flex justify-between items-center py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
        <div class="text-2xl font-bold text-white flex items-center space-x-reverse space-x-2">
            <img src="/assets/img/NeXTPixel.png" alt="NeXTPixel" class="h-8 w-8 md:h-10 md:w-10 object-contain">
            <a href="index.php" class="gradient-text font-bold">NextPixel</a>
        </div>
        <div class="hidden md:flex items-center space-x-6 space-x-reverse">
            <a href="index.php" class="hover:text-blue-400 transition">صفحه اصلی</a>
            <a href="services.php" class="hover:text-blue-400 transition">خدمات</a>
            <a href="portfolio.php" class="hover:text-blue-400 transition">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition">تماس با ما</a>
            <a href="about.php" class="text-blue-400 font-medium">درباره ما</a>
            
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
            <a href="services.php" class="hover:text-blue-400 transition text-white">خدمات</a>
            <a href="portfolio.php" class="hover:text-blue-400 transition text-white">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition text-white">تماس با ما</a>
            <a href="about.php" class="text-blue-400 font-medium">درباره ما</a>
            
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

    <section class="min-h-[70vh] flex items-center relative overflow-hidden about-hero-3d">
        <div class="absolute inset-0 about-hero-3d-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60 z-10"></div>
        
        <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl about-3d-element" style="animation-delay: 0s;"></div>
        <div class="absolute top-40 right-20 w-40 h-40 bg-purple-500/20 rounded-full blur-3xl about-3d-element" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-32 left-1/4 w-36 h-36 bg-amber-500/20 rounded-full blur-3xl about-3d-element" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto px-4 z-20 relative py-20">
            <div class="text-center about-3d-content">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight about-3d-title">
                    پیکسلِ بعدی شما از اینجا شروع می‌شود
                </h1>
            </div>
        </div>
    </section>

    <section class="py-20 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="mb-20" data-aos="fade-up">
                <div class="liquid-glass p-8 md:p-12 rounded-2xl liquid-morph max-w-4xl mx-auto">
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed mb-6">
                        NextPixel فقط یک نام یا ترکیب اتفاقی حروف نیست؛ پشت این نام دو روایت وجود دارد.
                    </p>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed mb-6">
                        اول، الهام از جسارت و نوآوری شرکتی به نام NeXT که استیو جابز آن را برای شکستن قالب‌های قدیمی به‌وجود آورد. دوم، «پیکسل بعدی» – همان نقطه‌ی کوچک اما حیاتی که تصویر ناتمام کسب‌وکار شما را کامل می‌کند. ما آماده‌ایم تا آن پیکسل بعدی باشیم.
                    </p>
                </div>
            </div>

            <div class="mb-20" data-aos="fade-up">
                <div class="glass-effect p-8 md:p-12 rounded-2xl liquid-morph">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-blue-900/30 rounded-lg flex items-center justify-center ml-6">
                            <i data-feather="zap" class="w-8 h-8 text-blue-400"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold gradient-text">چه کار می‌کنیم؟</h2>
                    </div>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed">
                        ما در NextPixel مجموعه‌ای گسترده از خدمات را ارائه می‌دهیم، اما تخصص اصلی‌مان طراحی و توسعه‌ی فروشگاه‌های اینترنتی و سایت‌های فروشگاهی است. علاوه بر آن، سیستم‌های اتوماسیون هوشمند می‌سازیم، چت‌بات‌های حرفه‌ای برای مشاوره و فروش پیاده‌سازی می‌کنیم و تجربه‌های دیجیتالی را طراحی می‌کنیم که با نگاه به آینده شکل گرفته‌اند. اگر پروژه‌ی شما نیاز به یک راهکار اختصاصی، مدرن و مقیاس‌پذیر دارد، این‌جا درست آمده‌اید.
                    </p>
                </div>
            </div>

            <div class="mb-20" data-aos="fade-up">
                <div class="glass-effect p-8 md:p-12 rounded-2xl liquid-morph">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-purple-900/30 rounded-lg flex items-center justify-center ml-6">
                            <i data-feather="heart" class="w-8 h-8 text-purple-400"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold gradient-text">به چه باور داریم؟</h2>
                    </div>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed mb-6">
                        وسواس ما به کیفیت و طراحی بی‌نظیر است. هر طرح و هر خط کدی باید آن‌قدر سنجیده و زیبا باشد که رضایت شما را به‌همراه داشته باشد.
                    </p>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed mb-6">
                        ما عاشق سیستم‌سازی هستیم؛ یعنی حذف مسیرهای طولانی، ساده‌سازی فرایندها و رساندن پروژه‌ها در زمان کوتاه‌تر.
                    </p>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed">
                        خلاقیت برای ما مرزی ندارد و باور داریم که همیشه می‌توان پیکسل‌های بهتری کنار هم چید.
                    </p>
                </div>
            </div>

            <div class="mb-20" data-aos="fade-up">
                <div class="glass-effect p-8 md:p-12 rounded-2xl liquid-morph">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-amber-900/30 rounded-lg flex items-center justify-center ml-6">
                            <i data-feather="star" class="w-8 h-8 text-amber-400"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold gradient-text">چرا ما؟</h2>
                    </div>
                    <p class="text-lg md:text-xl text-gray-300 leading-relaxed">
                        اگر به‌دنبال شریکی هستید که ایده‌ی شما را با وسواس و نگاه تازه به واقعیت تبدیل کند، NextPixel نقطه‌ی شروع شماست. ما به‌عنوان تیمی جوان و پرانرژی، نه در سایه‌ی گذشته بلکه بر پایه‌ی آینده‌ای که می‌سازیم تعریف می‌شویم.
                    </p>
                </div>
            </div>
            
            <div class="mb-20" data-aos="fade-up">
                <div class="text-center mb-10 md:mb-16">
                      <h2 class="text-2xl md:text-4xl font-bold gradient-text mb-4">تیم متخصص ما</h2>
                      <p class="text-gray-400 text-sm md:text-base max-w-2xl mx-auto px-4">تیمی خلاق و پیشرو که پشت هر پیکسل از موفقیت شما ایستاده است</p>
                </div>
                
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 max-w-7xl mx-auto px-4 relative items-stretch lg:items-start">
                    
                    <div class="flex flex-col w-full lg:w-1/3">
                        
                        <div class="z-20 mb-2 relative flex justify-center">
                             <div class="team-glass-card leader p-6 md:p-10 text-center w-full max-w-sm md:max-w-md transform transition-all duration-300 hover:scale-105" data-tilt>
                                 <div class="member-img-box">
                                     <img src="https://nextpixel.top/src/team/Kheirdoost.png" alt="Member" class="member-img">
                                 </div>
                                 <h3 class="member-name">امید خیردوست</h3>
                                 <span class="member-role">بنیانگذار و مدیر اجرایی</span>
                                 <p class="text-gray-300 text-xs md:text-sm mb-4 leading-relaxed px-2 hidden md:block">
                                     5 سال سابقه در پشتیبانی محصولات نرم‌افزاری و هوش مصنوعی و برگزار کننده دوره‌های استراتژی فروش
                                 </p>
                                 <div class="social-links flex justify-center gap-3 md:gap-4 mt-2">
                                     <a href="#" class="rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all">
                                         <i data-feather="linkedin" class="w-4 h-4 md:w-5 md:h-5"></i>
                                     </a>
                                     <a href="#" class="rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all">
                                         <i data-feather="instagram" class="w-4 h-4 md:w-5 md:h-5"></i>
                                     </a>
                                 </div>
                             </div>
                        </div>

                        <div class="desktop-connector-h">
                            <div class="desktop-line-vertical"></div>
                            <div class="desktop-line-horizontal" style="left: 20%; right: 20%;"></div>
                        </div>

                        <div class="mobile-branch-wrapper w-full">
                            <div class="grid team-grid-responsive grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                                
                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Ahmadi.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">طاها احمدی</h3>
                                        <span class="member-role">کارشناس فروش</span>
                                    </div>
                                </div>

                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Naseri.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">یگانه ناصری</h3>
                                        <span class="member-role">کارشناس فروش</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col w-full lg:w-2/3 mt-8 lg:mt-0">
                        
                        <div class="z-20 mb-2 relative flex justify-center">
                             <div class="team-glass-card leader p-6 md:p-10 text-center w-full max-w-sm md:max-w-md transform transition-all duration-300 hover:scale-105" data-tilt>
                                 <div class="member-img-box">
                                     <img src="https://nextpixel.top/src/team/HoMo.png" alt="Member" class="member-img">
                                 </div>
                                 <h3 class="member-name">حجت ملاحسینی</h3>
                                 <span class="member-role">مدیر فنی و سرپرست طراحان</span>
                                 <p class="text-gray-300 text-xs md:text-sm mb-4 leading-relaxed px-2 hidden md:block">
                                     7 سال سابقه طراحی UI/UX، مدرس رسمی دوره CS50 هاروارد و 2 سال سابقه تدریس تخصصی مهندسی معکوس و طراحی دیجیتال
                                 </p>
                                 <div class="social-links flex justify-center gap-3 md:gap-4 mt-2">
                                     <a href="HoMoHUA" class="rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all">
                                         <i data-feather="github" class="w-4 h-4 md:w-5 md:h-5"></i>
                                     </a>
                                     <a href="#" class="rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all">
                                         <i data-feather="linkedin" class="w-4 h-4 md:w-5 md:h-5"></i>
                                     </a>
                                 </div>
                             </div>
                        </div>

                        <div class="desktop-connector-h">
                            <div class="desktop-line-vertical"></div>
                            <div class="desktop-line-horizontal" style="left: 5%; right: 5%;"></div>
                        </div>

                        <div class="mobile-branch-wrapper w-full">
                            <div class="grid team-grid-responsive grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2 lg:gap-3">
                                
                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Mousavi.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">اسرا موسوی</h3>
                                        <span class="member-role">طراح ارشد و ناظر</span>
                                    </div>
                                </div>

                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Hasani.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">مروه حسنی</h3>
                                        <span class="member-role">فرانت اند کار</span>
                                    </div>
                                </div>

                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Aghamiri.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">متین آقامیری</h3>
                                        <span class="member-role">بک اند و مشاور سئو</span>
                                    </div>
                                </div>

                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Hojatpanah.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">مهدیار حجت پناه</h3>
                                        <span class="member-role">طراح رابط کاربری</span>
                                    </div>
                                </div>
                                
                                <div class="relative w-full">
                                    <div class="sub-connector-up hidden lg:block"></div>
                                    <div class="mobile-connector"></div>
                                    <div class="team-glass-card p-4 text-center w-full hover:bg-slate-800/50 transition-colors" data-tilt>
                                        <div class="member-img-box">
                                            <img src="https://nextpixel.top/src/team/Mohhamadi.png" alt="Member" class="member-img">
                                        </div>
                                        <h3 class="member-name">مبینا محمدی</h3>
                                        <span class="member-role">سئو آنالیست</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>

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

            const teamCards = document.querySelectorAll('[data-tilt]');
            
            if (window.matchMedia("(hover: hover)").matches) {
                teamCards.forEach(card => {
                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        
                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;
                        
                        const rotateX = ((y - centerY) / centerY) * -10; 
                        const rotateY = ((x - centerX) / centerX) * 10;
                        
                        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                    });

                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
                    });
                });
            }

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

            const aboutHero3D = document.querySelector('.about-hero-3d');
            if (aboutHero3D && window.innerWidth > 768) {
                aboutHero3D.addEventListener('mousemove', (e) => {
                    const { clientX, clientY } = e;
                    const { width, height, left, top } = aboutHero3D.getBoundingClientRect();
                    const x = (clientX - left - width / 2) / width;
                    const y = (clientY - top - height / 2) / height;
                    
                    const elements = aboutHero3D.querySelectorAll('.about-3d-element');
                    const title = aboutHero3D.querySelector('.about-3d-title');
                    const content = aboutHero3D.querySelector('.about-3d-content');
                    
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
                
                aboutHero3D.addEventListener('mouseleave', () => {
                    const elements = aboutHero3D.querySelectorAll('.about-3d-element');
                    const title = aboutHero3D.querySelector('.about-3d-title');
                    const content = aboutHero3D.querySelector('.about-3d-content');
                    
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
                    this.canvasDPI = 1; 
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

                    this.target.style.backdropFilter = `url(#${this.id}_filter) blur(4px) saturate(180%)`;
                    this.target.style.webkitBackdropFilter = `url(#${this.id}_filter) blur(10px) saturate(180%)`;

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

                    const w = this.width;
                    const h = this.height;

                    this.ctx.fillStyle = 'rgba(57, 57, 0, 1)';
                    this.ctx.fillRect(0, 0, w, h);

                    const mx = this.mouse.x * w;
                    const my = this.mouse.y * h;

                    const radius = 200; 
                    if (mx > -radius && mx < w + radius && my > -radius && my < h + radius) {
                        const grd = this.ctx.createRadialGradient(mx, my, 0, mx, my, radius);

                        grd.addColorStop(0, 'rgba(255, 255, 0, 1)'); 
                        grd.addColorStop(1, 'rgba(127, 127, 0, 1)'); 
                        
                        this.ctx.fillStyle = grd;
                        this.ctx.fillRect(0, 0, w, h);
                    }

                    this.feImage.setAttributeNS('http://www.w3.org/1999/xlink', 'href', this.canvas.toDataURL());
                }
            }

            new LiquidGlassHeader('.ios-glass-header');
        });
    </script>
</body>
</html>