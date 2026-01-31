(function(){
    if (window._npSiteHeaderInit) return; window._npSiteHeaderInit = true;

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize AOS if available
        try { if (window.AOS && typeof AOS.init === 'function') AOS.init({ duration: 900, easing: 'ease-out-quart', once: true, mirror: false, anchorPlacement: 'top-center' }); } catch(e){}
        // Initialize Feather if available
        try { if (window.feather && typeof feather.replace === 'function') feather.replace(); } catch(e){}

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle && mobileMenu) {
            const setBodyScroll = (enabled) => { document.body.style.overflow = enabled ? '' : 'hidden'; };

            const setOpenState = (open) => {
                mobileMenu.classList.toggle('open', open);
                // compatibility: some pages use .active
                mobileMenu.classList.toggle('active', open);
                setBodyScroll(!open);
            };

            const toggleMobileMenu = (force) => {
                if (typeof force === 'boolean') return setOpenState(force);
                setOpenState(!mobileMenu.classList.contains('open') && !mobileMenu.classList.contains('active'));
            };

            menuToggle.addEventListener('click', (e) => { e.preventDefault(); toggleMobileMenu(); });

            // Close when clicking a link inside mobile menu
            mobileMenu.querySelectorAll('a').forEach(a => { a.addEventListener('click', () => setOpenState(false)); });

            // Close with Escape key
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpenState(false); });

            // Close when clicking backdrop (outside content)
            mobileMenu.addEventListener('click', (e) => { if (e.target === mobileMenu) setOpenState(false); });
        }

        // Header Scroll Detection
        const header = document.getElementById('main-header');
        if (header) {
            const onScroll = () => {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        }

        // Active link highlighting
        try {
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
        } catch (e) {}
    });
})();
