/**
 * Internship Page Interactive Modules
 * Handles application modals, tracking tabs, and submission handlers.
 */
export function initInternship() {
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    function switchLacakTab(tab) {
        const btnId = document.getElementById('tab-lacak-id');
        const btnEmail = document.getElementById('tab-lacak-email');
        const groupId = document.getElementById('form-lacak-id-group');
        const groupEmail = document.getElementById('form-lacak-email-group');
        if (!btnId || !btnEmail || !groupId || !groupEmail) return;

        if (tab === 'id') {
            btnId.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm cursor-pointer';
            btnEmail.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer';
            groupId.classList.remove('hidden');
            groupEmail.classList.add('hidden');
        } else {
            btnEmail.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all bg-white dark:bg-[#131D36] text-[#0284c7] dark:text-cyan-400 shadow-sm cursor-pointer';
            btnId.className =
                'py-2 px-3 rounded-lg font-bold text-xs transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer';
            groupEmail.classList.remove('hidden');
            groupId.classList.add('hidden');
        }
    }

    function handleFormSubmit(e, modalId, message) {
        e.preventDefault();
        alert(message);
        closeModal(modalId);
    }

    function searchStatus(e) {
        e.preventDefault();
        const inputId = document.getElementById('lookup-input-id');
        const query = inputId ? inputId.value : '';
        const result = document.getElementById('modal-timeline-result');
        if (result) {
            result.classList.remove('hidden');
            alert('Memperbarui data pelacakan untuk: ' + query);
        }
    }

    // Attach to window so inline onclick handlers in Blade continue working smoothly
    window.openModal = openModal;
    window.closeModal = closeModal;
    window.switchLacakTab = switchLacakTab;
    window.handleFormSubmit = handleFormSubmit;
    window.searchStatus = searchStatus;

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal('modal-daftar-smk');
            closeModal('modal-daftar-mahasiswa');
            closeModal('modal-lacak-status');
        }
    });
}

