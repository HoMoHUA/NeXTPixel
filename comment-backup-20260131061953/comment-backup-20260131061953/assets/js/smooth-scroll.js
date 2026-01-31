// ==========================================
// Smooth Scroll Script
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip empty hashes and data attributes
            if (href === '#' || href.startsWith('#!')) {
                return;
            }
            
            const targetElement = document.querySelector(href);
            
            if (targetElement) {
                e.preventDefault();
                
                // Smooth scroll to element with offset for sticky header
                const headerOffset = 100;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Smooth scroll to top button
    const scrollToTopBtn = document.getElementById('scroll-to-top');
    if (scrollToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                scrollToTopBtn.classList.add('opacity-100');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                scrollToTopBtn.classList.remove('opacity-100');
            }
        });

        scrollToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Smooth scroll parallax effect for background elements
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', () => {
            parallaxElements.forEach(element => {
                const scrollPosition = window.pageYOffset;
                const speed = element.getAttribute('data-parallax') || 0.5;
                element.style.transform = `translateY(${scrollPosition * speed}px)`;
            });
        });
    }

    // Add scroll animation trigger for elements with data-scroll-animate
    const scrollAnimateElements = document.querySelectorAll('[data-scroll-animate]');
    
    if (scrollAnimateElements.length > 0 && 'IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        scrollAnimateElements.forEach(element => {
            observer.observe(element);
        });
    }

    // Mobile menu scroll lock
    const mobileMenu = document.getElementById('mobile-menu');
    const menuBtn = document.getElementById('menu-btn');
    
    if (mobileMenu && menuBtn) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('translate-x-full');
            if (!mobileMenu.classList.contains('translate-x-full')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
            });
        });
    }

    // Smooth scroll for navigation links within page
    document.querySelectorAll('a[href*="#wordpress-content"], a[href*="#services"], a[href*="#features"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const targetId = href.split('#')[1];
            
            if (targetId) {
                e.preventDefault();
                const target = document.getElementById(targetId);
                
                if (target) {
                    const headerOffset = 120;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

// CSS for scroll animations (inject into page if not already present)
if (!document.getElementById('smooth-scroll-styles')) {
    const style = document.createElement('style');
    style.id = 'smooth-scroll-styles';
    style.textContent = `
        html {
            scroll-behavior: smooth;
        }
        
        body {
            scroll-behavior: smooth;
        }
        
        [data-scroll-animate] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        [data-scroll-animate].animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        #scroll-to-top {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        #scroll-to-top:hover {
            transform: translateY(-4px);
        }
    `;
    document.head.appendChild(style);
}
