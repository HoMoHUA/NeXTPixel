<?php
/**
 * Global Header Include - Refined Version
 * Sticky header with liquid glass effect, logo, mobile menu
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';
$isN8NAdmin = $isLoggedIn;

// Determine current page for active link highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<style>
    /* =========================================================
       Global Header Styles
       ========================================================= */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background: rgba(15, 23, 42, 0.5);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    header.scrolled {
        background: rgba(15, 23, 42, 0.8);
        border-bottom-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
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

    /* Desktop Navigation */
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

    /* Header Buttons */
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

    /* Mobile Menu Button */
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

    /* Mobile Menu */
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

    /* Responsive */
    @media (min-width: 768px) {
        .mobile-menu {
            display: none !important;
        }
    }

    /* Liquid Glass Header Effect */
    .liquid-header-bg {
        position: absolute;
        inset: 0;
        z-index: -1;
        background: rgba(15, 23, 42, 0.4);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<header class="header-main" id="main-header">
    <div class="header-container">
        <!-- Logo -->
        <a href="/" class="header-logo">
            <img src="/assets/img/NeXTPixel.png" alt="NextPixel" />
            <span class="header-logo-text">NextPixel</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav" id="desktop-nav">
            <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
            <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
            <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
            <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
            <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
        </nav>

        <!-- Actions & Mobile Menu Button -->
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
        <!-- Navigation Links -->
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

        <!-- Auth Section -->
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

<script>
    // Header sticky behavior
    const header = document.getElementById('main-header');
    let lastScrollY = 0;

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        
        if (scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScrollY = scrollY;
    }, { passive: true });

    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : 'auto';
        });

        // Close menu when clicking on a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Active link highlighting
    function updateActiveLink() {
        const currentFile = window.location.pathname.split('/').pop() || 'index.php';
        document.querySelectorAll('#desktop-nav a, #mobile-menu a').forEach(link => {
            const href = link.getAttribute('href');
            if (href === '/' && currentFile === '' || href.includes(currentFile)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    updateActiveLink();
</script>

<script>
    // Scroll-based header styling
    const header = document.querySelector('.ios-glass-header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // Liquid Glass Header Effect
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

            this.target.style.backdropFilter = `url(#${this.id}_filter) blur(35px) saturate(280%)`;
            this.target.style.webkitBackdropFilter = `url(#${this.id}_filter) blur(35px) saturate(280%)`;

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
            window.addEventListener('mousemove', (e) => {
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

    // Initialize Liquid Glass Header
    new LiquidGlassHeader('.ios-glass-header');
</script>
