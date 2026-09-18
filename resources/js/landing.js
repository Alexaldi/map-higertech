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

    function setActivePillar(index, shouldFocus = false) {
        if (activePillarIndex === index && !shouldFocus) return;
        activePillarIndex = index;

        pillarBtns.forEach((btn, idx) => {
            if (idx === index) {
                btn.classList.add(
                    'bg-blue-50/90',
                    'dark:bg-blue-900/30',
                    'border-2',
                    'border-blue-500',
                    'dark:border-cyan-500',
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
                btn.setAttribute('tabindex', '0');
                if (shouldFocus) btn.focus();
            } else {
                btn.classList.remove(
                    'bg-blue-50/90',
                    'dark:bg-blue-900/30',
                    'border-2',
                    'border-blue-500',
                    'dark:border-cyan-500',
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
                btn.setAttribute('tabindex', '-1');
            }
        });

        if (displayBody) {
            displayBody.setAttribute('aria-labelledby', `pillar-tab-${index}`);
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

    // Set initial active state & keyboard navigation
    pillarBtns.forEach((btn, idx) => {
        if (idx === 0) {
            btn.setAttribute('aria-selected', 'true');
            btn.setAttribute('tabindex', '0');
        } else {
            btn.setAttribute('aria-selected', 'false');
            btn.setAttribute('tabindex', '-1');
        }

        btn.addEventListener('click', () => setActivePillar(idx));

        btn.addEventListener('keydown', (e) => {
            let targetIndex = null;
            if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                e.preventDefault();
                targetIndex = (idx + 1) % pillarBtns.length;
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                e.preventDefault();
                targetIndex = (idx - 1 + pillarBtns.length) % pillarBtns.length;
            } else if (e.key === 'Home') {
                e.preventDefault();
                targetIndex = 0;
            } else if (e.key === 'End') {
                e.preventDefault();
                targetIndex = pillarBtns.length - 1;
            }

            if (targetIndex !== null) {
                setActivePillar(targetIndex, true);
            }
        });
    });
}

