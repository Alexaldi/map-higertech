/**
 * Landing Page Interactive Modules
 * Handles 4-Pillar Tab Switcher and landing animations.
 */
export function initPillars() {
    const pillarBtns = document.querySelectorAll('.pillar-btn');
    if (!pillarBtns.length) return;

    const displayTitle = document.getElementById('pillar-display-title');
    const displayBadge = document.getElementById('pillar-display-badge');
    const displayDesc = document.getElementById('pillar-display-desc');
    const displayBody = document.getElementById('pillar-display-body');
    const displayIconBox = document.getElementById('pillar-display-icon-box');
    const displayIconSvg = document.getElementById('pillar-display-icon-svg');

    let activePillarIndex = 0;

    function setActivePillar(index) {
        if (activePillarIndex === index) return;
        activePillarIndex = index;

        pillarBtns.forEach((btn, idx) => {
            if (idx === index) {
                btn.classList.add(
                    'bg-blue-50/90',
                    'dark:bg-blue-900/30',
                    'border-2',
                    'border-blue-500',
                    'dark:border-cyan-500',
                    'pointer-events-none',
                    'cursor-default',
                    'select-none'
                );
                btn.classList.remove(
                    'bg-slate-50',
                    'dark:bg-[#131D36]',
                    'border',
                    'border-slate-200',
                    'dark:border-slate-800',
                    'cursor-pointer'
                );
                btn.setAttribute('aria-selected', 'true');
                btn.setAttribute('tabindex', '-1');
            } else {
                btn.classList.remove(
                    'bg-blue-50/90',
                    'dark:bg-blue-900/30',
                    'border-2',
                    'border-blue-500',
                    'dark:border-cyan-500',
                    'pointer-events-none',
                    'cursor-default',
                    'select-none'
                );
                btn.classList.add(
                    'bg-slate-50',
                    'dark:bg-[#131D36]',
                    'border',
                    'border-slate-200',
                    'dark:border-slate-800',
                    'cursor-pointer'
                );
                btn.setAttribute('aria-selected', 'false');
                btn.removeAttribute('tabindex');
            }
        });

        if (displayBody) {
            displayBody.style.opacity = '0';
            displayBody.style.transform = 'translateY(4px)';
            setTimeout(() => {
                const btn = pillarBtns[index];
                if (!btn) return;

                const title = btn.dataset.title;
                const badge = btn.dataset.badge;
                const desc = btn.dataset.desc;
                const iconColor = btn.dataset.iconColor;
                const bgColor = btn.dataset.bgColor;

                if (displayTitle && title) displayTitle.textContent = title;
                if (displayBadge && badge) {
                    displayBadge.textContent = badge;
                    displayBadge.className = `text-[10px] font-mono uppercase tracking-widest ${iconColor} font-bold block`;
                }
                if (displayDesc && desc) displayDesc.textContent = desc;
                if (displayIconBox && displayIconSvg) {
                    displayIconBox.className = `w-12 h-12 rounded-2xl ${bgColor} ${iconColor} flex items-center justify-center`;
                    const btnSvg = btn.querySelector('svg');
                    if (btnSvg) {
                        displayIconSvg.innerHTML = btnSvg.innerHTML;
                    }
                }
                displayBody.style.opacity = '1';
                displayBody.style.transform = 'translateY(0)';
            }, 120);
        }
    }

    // Set initial active state
    if (pillarBtns[0]) {
        pillarBtns[0].classList.add('pointer-events-none', 'cursor-default', 'select-none');
        pillarBtns[0].setAttribute('aria-selected', 'true');
        pillarBtns[0].setAttribute('tabindex', '-1');
    }

    pillarBtns.forEach((btn, idx) => {
        btn.addEventListener('click', () => setActivePillar(idx));
    });
}

