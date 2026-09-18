import '../css/app.css';
import './theme.js';

// Modal stubs for early user clicks before dynamic module load
window.openModal = window.openModal || function (id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
};
window.closeModal = window.closeModal || function (id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }
};



if (document.querySelector('[data-live-map]')) {
    import('./map/index.js');
}

const previewMapEl = document.querySelector('[data-preview-map]');
if (previewMapEl) {
    if ('IntersectionObserver' in window) {
        const previewObserver = new IntersectionObserver((entries, obs) => {
            if (entries[0].isIntersecting) {
                obs.disconnect();
                import('./map/preview.js').then((module) => {
                    module.initMapPreview();
                });
            }
        }, { rootMargin: '300px 0px' });
        previewObserver.observe(previewMapEl);
    } else {
        import('./map/preview.js').then((module) => {
            module.initMapPreview();
        });
    }
}

// Measure topbar height for native sticky offset (zero-jitter, GPU-accelerated)
let topbarRaf = null;
function updateTopbarHeight() {
    if (topbarRaf) cancelAnimationFrame(topbarRaf);
    topbarRaf = window.requestAnimationFrame(() => {
        const header = document.querySelector('.site-header');
        if (!header) return;
        if (document.querySelector('[data-live-map]')) {
            header.style.setProperty('--topbar-height', '0px');
            return;
        }
        const topbar = document.querySelector('.site-topbar');
        if (topbar) {
            header.style.setProperty('--topbar-height', `${topbar.offsetHeight}px`);
        }
    });
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

function initPageBehaviors() {
    if ('requestIdleCallback' in window) {
        requestIdleCallback(updateTopbarHeight);
    } else {
        setTimeout(updateTopbarHeight, 150);
    }
    window.addEventListener('resize', updateTopbarHeight, { passive: true });
    initBackToTop();
    initScrollReveal();

    if (document.getElementById('pillar-tabs') || document.querySelector('.pillar-btn')) {
        import('./landing.js').then((m) => m.initPillars());
    }

    if (document.querySelector('[data-internship-page]') || document.getElementById('modal-lacak-status')) {
        import('./internship.js').then((m) => m.initInternship());
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPageBehaviors);
} else {
    initPageBehaviors();
}
