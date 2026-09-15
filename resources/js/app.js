import '../css/app.css';
import './theme.js';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';

if (document.querySelector('[data-live-map]')) {
    import('./map/index.js');
}

if (document.querySelector('[data-preview-map]')) {
    import('./map/preview.js').then((module) => {
        module.initMapPreview();
    });
}

// Measure topbar height for native sticky offset (zero-jitter, GPU-accelerated)
function updateTopbarHeight() {
    const topbar = document.querySelector('.site-topbar');
    if (topbar) {
        document.documentElement.style.setProperty('--topbar-height', `${topbar.offsetHeight}px`);
    }
}

// Floating Back-To-Top button
function initBackToTop() {
    const backToTopBtn = document.getElementById('btn-back-to-top');
    if (!backToTopBtn) return;

    let ticking = false;

    const onScroll = () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const y = window.scrollY || window.pageYOffset || 0;

                if (y > 350) {
                    backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                    backToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                } else {
                    backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                }

                ticking = false;
            });
            ticking = true;
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Elegant, lightweight scroll reveal animation (one-shot, GPU-composited)
function initScrollReveal() {
    const reveals = document.querySelectorAll('.scroll-reveal, .scroll-reveal-scale');
    if (!reveals.length) return;

    if (!('IntersectionObserver' in window)) {
        reveals.forEach(el => el.classList.add('is-revealed'));
        return;
    }

    const revealObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                obs.unobserve(entry.target);
            }
        });
    }, {
        rootMargin: '0px 0px -40px 0px',
        threshold: 0.1
    });

    reveals.forEach(el => revealObserver.observe(el));
}

// Active navigation indicator on scroll (Scrollspy)
function initScrollSpy() {
    const navItems = document.querySelectorAll('[data-nav-target]');
    if (!navItems.length) return;

    // If on /map page, map link is permanently marked active
    if (document.querySelector('[data-live-map]')) return;

    const targetIds = ['hero', 'workstation', 'map-section', 'articles', 'contact', 'internship'];
    const sections = targetIds
        .map(id => document.getElementById(id))
        .filter(Boolean);

    if (!sections.length) return;

    function setActiveNav(activeId) {
        navItems.forEach(item => {
            const target = item.getAttribute('data-nav-target');
            const isActive = target === activeId;
            item.classList.toggle('is-active', isActive);
            if (item.tagName === 'A') {
                if (isActive) {
                    item.setAttribute('aria-current', 'page');
                } else {
                    item.removeAttribute('aria-current');
                }
            }
        });
    }

    const spyObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setActiveNav(entry.target.id);
            }
        });
    }, {
        rootMargin: '-20% 0px -65% 0px',
        threshold: 0
    });

    sections.forEach(sec => spyObserver.observe(sec));

    window.addEventListener('scroll', () => {
        if (window.scrollY < 120) {
            setActiveNav('hero');
        }
    }, { passive: true });
}

function initPageBehaviors() {
    updateTopbarHeight();
    window.addEventListener('resize', updateTopbarHeight, { passive: true });
    initBackToTop();
    initScrollReveal();
    initScrollSpy();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPageBehaviors);
} else {
    initPageBehaviors();
}
