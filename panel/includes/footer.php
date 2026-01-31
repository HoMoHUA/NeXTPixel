
<script src="/panel/assets/vendor/js/jquery/jquery-3.5.1.min.js"></script>
<script src="/panel/assets/vendor/js/jquery/jquery-ui.js"></script>
<script src="/panel/assets/vendor/js/bootstrap/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper@11.2.6/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.0/dist/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" referrerpolicy="origin"></script>
<script src="/panel/assets/js/main.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.geex-sidebar__menu__item.has-children > .geex-sidebar__menu__link');
    
    menuItems.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentItem = this.parentElement;
            const submenu = parentItem.querySelector('.geex-sidebar__submenu');

            document.querySelectorAll('.geex-sidebar__menu__item.has-children').forEach(function(item) {
                if (item !== parentItem) {
                    item.classList.remove('active');
                    const otherSubmenu = item.querySelector('.geex-sidebar__submenu');
                    if (otherSubmenu) {
                        otherSubmenu.style.maxHeight = '0';
                        otherSubmenu.style.padding = '0';
                    }
                }
            });

            if (parentItem.classList.contains('active')) {
                parentItem.classList.remove('active');
                if (submenu) {
                    submenu.style.maxHeight = '0';
                    submenu.style.padding = '0';
                }
            } else {
                parentItem.classList.add('active');
                if (submenu) {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    submenu.style.padding = '8px 0';
                }
            }
        });
    });

    const activeSubmenu = document.querySelector('.geex-sidebar__menu__item.has-children.active');
    if (activeSubmenu) {
        const submenu = activeSubmenu.querySelector('.geex-sidebar__submenu');
        if (submenu) {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            submenu.style.padding = '8px 0';
        }
    }

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    
    function openMobileMenu() {
        mobileMenu.classList.add('active');
        mobileMenuOverlay.classList.add('active');
        mobileMenuToggle.classList.add('active');
        document.body.style.overflow = 'hidden';

    }
    
    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        document.body.style.overflow = '';

    }
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileMenu();
        });
    }
    
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
    }
    
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    const mobileSubmenuItems = document.querySelectorAll('.np-mobile-menu__item--has-submenu > .np-mobile-menu__link--parent');
    
    mobileSubmenuItems.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentItem = this.parentElement;
            const submenu = parentItem.querySelector('.np-mobile-menu__submenu');

            document.querySelectorAll('.np-mobile-menu__item--has-submenu').forEach(function(item) {
                if (item !== parentItem) {
                    item.classList.remove('active');
                    const otherSubmenu = item.querySelector('.np-mobile-menu__submenu');
                    if (otherSubmenu) {
                        otherSubmenu.style.maxHeight = '0';
                    }
                }
            });

            if (parentItem.classList.contains('active')) {
                parentItem.classList.remove('active');
                if (submenu) {
                    submenu.style.maxHeight = '0';
                }
            } else {
                parentItem.classList.add('active');
                if (submenu) {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                }
            }
        });
    });

    const mobileMenuLinks = document.querySelectorAll('.np-mobile-menu__link:not(.np-mobile-menu__link--parent)');
    mobileMenuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            setTimeout(() => {
                closeMobileMenu();
            }, 150);
        });
    });

    const activeMobileSubmenu = document.querySelector('.np-mobile-menu__item--has-submenu.active');
    if (activeMobileSubmenu) {
        const submenu = activeMobileSubmenu.querySelector('.np-mobile-menu__submenu');
        if (submenu) {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
        }
    }
});
</script>
</body>
</html>

