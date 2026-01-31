(function(){
    if (window._npSiteHeaderInit) return; window._npSiteHeaderInit = true;

    document.addEventListener('DOMContentLoaded', () => {
        
        try { if (window.AOS && typeof AOS.init === 'function') AOS.init({ duration: 900, easing: 'ease-out-quart', once: true, mirror: false, anchorPlacement: 'top-center' }); } catch(e){}
        
        try { if (window.feather && typeof feather.replace === 'function') feather.replace(); } catch(e){}

        
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle && mobileMenu) {
            const setBodyScroll = (enabled) => { document.body.style.overflow = enabled ? '' : 'hidden'; };

            const setOpenState = (open) => {
                mobileMenu.classList.toggle('open', open);
                
                mobileMenu.classList.toggle('active', open);
                setBodyScroll(!open);
            };

            const toggleMobileMenu = (force) => {
                if (typeof force === 'boolean') return setOpenState(force);
                setOpenState(!mobileMenu.classList.contains('open') && !mobileMenu.classList.contains('active'));
            };

            menuToggle.addEventListener('click', (e) => { e.preventDefault(); toggleMobileMenu(); });

            
            mobileMenu.querySelectorAll('a').forEach(a => { a.addEventListener('click', () => setOpenState(false)); });

            
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpenState(false); });

            
            mobileMenu.addEventListener('click', (e) => { if (e.target === mobileMenu) setOpenState(false); });
        }

        
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

