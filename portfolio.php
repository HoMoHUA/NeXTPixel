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
    <title>نمونه کارها | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwindcss.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
    <script src="/assets/js/vendor/anime.min.js" defer></script>
    <script src="/assets/js/vendor/three.min.js" defer></script>
    <script src="/assets/js/vendor/scrollreveal.min.js" defer></script>
    <script src="/assets/js/vendor/vanta.globe.min.js" defer></script>
    <script src="/assets/js/vendor/vanta.waves.min.js" defer></script>
    <script src="/assets/js/vendor/lottie-player.min.js" defer></script>
>>>>>>> Stashed changes
</head>
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
        <div class="text-2xl font-bold text-white flex items-center space-x-reverse space-x-2">
            <img src="/assets/img/NeXTPixel.png" alt="NeXTPixel" class="h-8 w-8 md:h-10 md:w-10 object-contain">
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
            </div>

            <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="col-span-full text-center text-gray-400 py-8">درحال بارگیری پروژه‌ها...</div>
            </div>

            <div id="demo-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
                <div class="bg-slate-900 border border-blue-500/20 rounded-2xl p-8 max-w-md w-full mx-4">
                    <h3 class="text-2xl font-bold text-white mb-4">نوع دمو را انتخاب کنید</h3>
                    <div id="demo-options" class="space-y-3"></div>
                    <button onclick="closeDemoModal()" class="w-full mt-6 bg-slate-700 hover:bg-slate-600 text-white py-2 rounded-lg transition">بستن</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        let allPortfolios = [];
        let currentFilter = 'all';

        document.addEventListener('DOMContentLoaded', () => {
            loadPortfolios();
            setupFilterButtons();
        });

        function loadPortfolios() {
            fetch('/api/get-portfolios.php?action=list')
                .then(r => r.json())
                .then(portfolios => {
                    allPortfolios = portfolios;
                    
                    // Load categories dynamically
                    const categories = [...new Set(portfolios.map(p => p.category))];
                    updateFilterButtons(categories);
                    
                    renderPortfolios(portfolios);
                })
                .catch(e => {
                    console.log('Error loading portfolios:', e);
                    document.getElementById('portfolio-grid').innerHTML = '<div class="col-span-full text-center text-gray-400 py-8">خطا در بارگیری پروژه‌ها</div>';
                });
        }

        function updateFilterButtons(categories) {
            const container = document.getElementById('filter-buttons');
            const buttons = Array.from(container.querySelectorAll('button'));
            
            const categoryMap = {
                'store': 'وبسایت فروشگاهی',
                'service': 'وبسایت خدماتی',
                'landing': 'لندینگ پیج',
                'other': 'سایر'
            };

            categories.forEach(cat => {
                if (!buttons.find(b => b.dataset.filter === cat)) {
                    const btn = document.createElement('button');
                    btn.className = 'filter-btn glass-effect px-6 py-3 rounded-full font-medium transition-all';
                    btn.textContent = categoryMap[cat] || cat;
                    btn.dataset.filter = cat;
                    btn.addEventListener('click', (e) => {
                        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                        e.target.classList.add('active');
                        currentFilter = cat;
                        renderPortfolios(allPortfolios);
                    });
                    container.appendChild(btn);
                }
            });
        }

        function setupFilterButtons() {
            document.getElementById('filter-buttons').addEventListener('click', (e) => {
                if (e.target.classList.contains('filter-btn')) {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                    currentFilter = e.target.dataset.filter;
                    renderPortfolios(allPortfolios);
                }
            });
        }

        function renderPortfolios(portfolios) {
            let filtered = portfolios;
            if (currentFilter !== 'all') {
                filtered = portfolios.filter(p => p.category === currentFilter);
            }

            if (filtered.length === 0) {
                document.getElementById('portfolio-grid').innerHTML = '<div class="col-span-full text-center text-gray-400 py-8">هیچ پروژه‌ای پیدا نشد</div>';
                return;
            }

            document.getElementById('portfolio-grid').innerHTML = filtered.map(p => {
                const categoryColors = {
                    'store': { bg: 'bg-blue-900/30', text: 'text-blue-400', label: 'فروشگاهی' },
                    'service': { bg: 'bg-purple-900/30', text: 'text-purple-400', label: 'خدماتی' },
                    'landing': { bg: 'bg-amber-900/30', text: 'text-amber-400', label: 'لندینگ' },
                    'other': { bg: 'bg-gray-900/30', text: 'text-gray-400', label: 'سایر' }
                };
                const colors = categoryColors[p.category] || categoryColors['other'];
                
                return `
                    <div class="portfolio-card glass-effect rounded-2xl overflow-hidden" data-category="${p.category}">
                        <img src="${p.thumbnail}" alt="${p.image_alt_text || p.title}" class="w-full h-56 object-cover" onerror="this.src='/assets/img/placeholder.png'">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold">${p.title}</h3>
                                <span class="text-xs ${colors.bg} ${colors.text} px-3 py-1 rounded-full whitespace-nowrap">${colors.label}</span>
                            </div>
                            <p class="text-gray-400 mb-4 text-sm">${p.description || ''}</p>
                            <div class="flex gap-2">
                                ${p.project_url ? `<a href="${p.project_url}" target="_blank" rel="noopener noreferrer" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center text-sm transition">وبسایت</a>` : ''}
                                ${(p.demo_type === 'internal' || p.demo_type === 'both') && p.internal_demo_url ? `<button onclick="openDemoModal('${p.id}', '${p.internal_demo_url}')" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg text-center text-sm transition">دمو محلی</button>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function openDemoModal(id, demoUrl) {
            const modal = document.getElementById('demo-modal');
            const options = document.getElementById('demo-options');
            
            options.innerHTML = `
                <div class="space-y-3">
                    <p class="text-gray-300 text-sm mb-4">برای مشاهده دمو، آدرس‌های موجود را انتخاب کنید:</p>
                    <button onclick="openDemo('${demoUrl}')" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition">
                        دمو محلی
                    </button>
                    <p class="text-gray-400 text-xs text-center">نیاز به IP سرور دارد</p>
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeDemoModal() {
            document.getElementById('demo-modal').classList.add('hidden');
        }

        function openDemo(url) {
            if (url.startsWith('/')) {
                // Local demo - use current host
                window.open(window.location.protocol + '//' + window.location.host + url, '_blank');
            } else {
                window.open(url, '_blank');
            }
            closeDemoModal();
        }

        document.getElementById('demo-modal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('demo-modal')) {
                closeDemoModal();
            }
        });
    </script>

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
