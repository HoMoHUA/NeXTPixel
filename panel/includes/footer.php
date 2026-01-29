<!-- inject:js-->
<script src="/panel/assets/vendor/js/jquery/jquery-3.5.1.min.js"></script>
<script src="/panel/assets/vendor/js/jquery/jquery-ui.js"></script>
<script src="/panel/assets/vendor/js/bootstrap/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper@11.2.6/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.0/dist/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" referrerpolicy="origin"></script>
<script src="/panel/assets/js/main.js"></script>
<!-- endinject-->

<script>
// مدیریت submenu برای sidebar
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.geex-sidebar__menu__item.has-children > .geex-sidebar__menu__link');
    
    menuItems.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentItem = this.parentElement;
            const submenu = parentItem.querySelector('.geex-sidebar__submenu');
            
            // بستن سایر submenu ها
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
            
            // باز/بسته کردن submenu فعلی
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
    
    // باز نگه داشتن submenu اگر صفحه فعال است
    const activeSubmenu = document.querySelector('.geex-sidebar__menu__item.has-children.active');
    if (activeSubmenu) {
        const submenu = activeSubmenu.querySelector('.geex-sidebar__submenu');
        if (submenu) {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            submenu.style.padding = '8px 0';
        }
    }
    
    // ========================================
    // مدیریت منوی موبایل
    // ========================================
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    
    function openMobileMenu() {
        mobileMenu.classList.add('active');
        mobileMenuOverlay.classList.add('active');
        mobileMenuToggle.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // انیمیشن آیتم‌های منو توسط CSS انجام می‌شود
    }
    
    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        document.body.style.overflow = '';
        
        // انیمیشن‌ها توسط CSS انجام می‌شوند
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
    
    // بستن منو با کلید ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // مدیریت submenu در منوی موبایل
    const mobileSubmenuItems = document.querySelectorAll('.np-mobile-menu__item--has-submenu > .np-mobile-menu__link--parent');
    
    mobileSubmenuItems.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentItem = this.parentElement;
            const submenu = parentItem.querySelector('.np-mobile-menu__submenu');
            
            // بستن سایر submenu ها
            document.querySelectorAll('.np-mobile-menu__item--has-submenu').forEach(function(item) {
                if (item !== parentItem) {
                    item.classList.remove('active');
                    const otherSubmenu = item.querySelector('.np-mobile-menu__submenu');
                    if (otherSubmenu) {
                        otherSubmenu.style.maxHeight = '0';
                    }
                }
            });
            
            // باز/بسته کردن submenu فعلی
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
    
    // بستن منو هنگام کلیک روی لینک
    const mobileMenuLinks = document.querySelectorAll('.np-mobile-menu__link:not(.np-mobile-menu__link--parent)');
    mobileMenuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            setTimeout(() => {
                closeMobileMenu();
            }, 150);
        });
    });
    
    // باز نگه داشتن submenu فعال در منوی موبایل
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

