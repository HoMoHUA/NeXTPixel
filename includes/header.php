<?php
/**
 * Global Header Include
 * Sticky header with liquid glass effect and logo
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
       Sticky Header with Liquid Glass Effect
       ========================================================= */
    nav.ios-glass-header {
        position: sticky;
        top: 16px;
        z-index: 1000;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(35px) saturate(280%); 
        -webkit-backdrop-filter: blur(35px) saturate(280%);
        border: 2px solid rgba(155, 155, 155, 0.4);
        
        /* Double Reverse Highlight: Top and Bottom Inset Shadows */
        box-shadow: 
            /* Outer soft shadow */
            0 10px 40px -10px rgba(0,0,0,0.5),
            /* Top Highlight Inner (Reverse Top) */
            inset 0 1px 0 0 rgba(255,255,255,0.2),
            /* Bottom Highlight Inner (Reverse Bottom) */
            inset 0 -1px 0 0 rgba(255,255,255,0.2),
            /* Deep Glass Glow */
            inset 0 0 20px rgba(255,255,255,0.05),
            /* Subtle Rim */
            0 0 0 1px rgba(255, 255, 255, 0.03) inset;

        transition: top 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s ease, box-shadow 0.3s ease;
    }
    
    nav.ios-glass-header.scrolled {
        top: 0;
        background: rgba(15, 23, 42, 0.75);
        box-shadow: 
            /* Outer soft shadow */
            0 10px 40px -10px rgba(0,0,0,0.5),
            /* Top Highlight Inner */
            inset 0 1px 0 0 rgba(255,255,255,0.2),
            /* Bottom Highlight Inner */
            inset 0 -1px 0 0 rgba(255,255,255,0.2),
            /* Deep Glass Glow */
            inset 0 0 20px rgba(255,255,255,0.05),
            /* Subtle Rim */
            0 0 0 1px rgba(255, 255, 255, 0.03) inset;
    }

    .header-logo-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .header-logo-img {
        height: 40px;
        width: auto;
        max-width: 100%;
    }

    .header-logo-text {
        font-size: 1.5rem;
        font-weight: bold;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .header-nav-links {
        display: none;
    }

    @media (min-width: 768px) {
        .header-nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-nav-links a {
            color: #f8fafc;
            transition: color 0.3s;
            text-decoration: none;
        }

        .header-nav-links a:hover {
            color: #60a5fa;
        }

        .header-nav-links a.active {
            color: #60a5fa;
            font-weight: 500;
        }
    }

    .header-buttons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-direction: row-reverse;
    }

    .header-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border: none;
        cursor: pointer;
    }

    .header-btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .header-btn-primary:hover {
        background-color: #2563eb;
    }

    .header-btn-success {
        background-color: #16a34a;
        color: white;
    }

    .header-btn-success:hover {
        background-color: #15803d;
    }

    .header-btn-purple {
        background-color: #a855f7;
        color: white;
    }

    .header-btn-purple:hover {
        background-color: #9333ea;
    }

    #menu-btn {
        display: block;
        background: none;
        border: none;
        cursor: pointer;
        z-index: 50;
    }

    @media (min-width: 768px) {
        #menu-btn {
            display: none;
        }
    }
</style>

<nav class="ios-glass-header flex justify-between items-center py-3 md:py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
    <a href="/" class="header-logo-wrapper">
        <img src="/assets/img/NeXTPixel.png" alt="NextPixel" class="header-logo-img">
        <span class="header-logo-text">NextPixel</span>
    </a>
    
    <div class="header-nav-links space-x-reverse">
        <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
        <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
        <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
        <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
        <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
    </div>

    <div class="header-buttons">
        <?php if ($isLoggedIn): ?>
            <?php if ($isN8NAdmin): ?>
                <a href="/n8n-admin.php" class="header-btn header-btn-success">
                    <i data-feather="zap" class="w-4 h-4"></i>
                    مدیریت n8n
                </a>
            <?php endif; ?>
            <a href="/panel/" class="header-btn header-btn-purple">
                <?php echo htmlspecialchars($username); ?> (پنل)
            </a>
        <?php else: ?>
            <a href="/login.php" class="header-btn header-btn-primary">
                ورود
            </a>
        <?php endif; ?>
    </div>

    <button id="menu-btn" class="md:hidden z-50">
        <i data-feather="menu" class="text-white w-7 h-7"></i>
    </button>
</nav>

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
