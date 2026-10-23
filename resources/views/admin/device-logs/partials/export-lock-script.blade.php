@push('styles')
    <style>
        /* Tombol ekspor yang sedang diproses: warna tetap penuh, tidak bisa diklik */
        .btn-export.is-loading {
            opacity: 1;
            pointer-events: none;
        }

        .btn-export .export-spinner {
            display: inline-block;
            width: 0.75rem;
            height: 0.75rem;
            margin-right: 0.25rem;
            vertical-align: -0.1em;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: export-spin 0.7s linear infinite;
        }

        @keyframes export-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn-export .export-spinner {
                animation-duration: 2s;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Kunci tombol ekspor sementara setelah diklik agar file berat tidak dibuat berulang.
        // Browser tidak memberi sinyal kapan unduhan selesai, jadi tombol dibuka lagi setelah jeda.
        (function() {
            const UNLOCK_AFTER_MS = 8000;

            document.addEventListener('click', function(event) {
                const button = event.target.closest('.btn-export');
                if (!button) return;

                if (button.classList.contains('disabled') || button.classList.contains('is-loading')) {
                    event.preventDefault();
                    return;
                }

                const otherButtons = Array.from(document.querySelectorAll('.btn-export')).filter((el) => el !== button);
                const originalHtml = button.innerHTML;
                const originalTitle = button.getAttribute('title');

                // Kunci setelah navigasi unduhan dimulai. Teks tetap, hanya ikon diganti spinner
                // supaya lebar tombol tidak berubah dan tombol lain tidak bergeser.
                setTimeout(function() {
                    const icon = button.querySelector('i');
                    const spinner = document.createElement('span');
                    spinner.className = 'export-spinner';
                    spinner.setAttribute('aria-hidden', 'true');
                    if (icon) {
                        icon.replaceWith(spinner);
                    } else {
                        button.prepend(spinner);
                    }

                    button.classList.add('is-loading');
                    button.setAttribute('aria-busy', 'true');
                    button.setAttribute('title', 'Menyiapkan file...');

                    otherButtons.forEach(function(el) {
                        el.classList.add('disabled');
                        el.setAttribute('aria-disabled', 'true');
                    });
                }, 0);

                setTimeout(function() {
                    button.classList.remove('is-loading');
                    button.removeAttribute('aria-busy');
                    button.innerHTML = originalHtml;
                    if (originalTitle !== null) {
                        button.setAttribute('title', originalTitle);
                    }

                    otherButtons.forEach(function(el) {
                        el.classList.remove('disabled');
                        el.removeAttribute('aria-disabled');
                    });
                }, UNLOCK_AFTER_MS);
            });
        })();
    </script>
@endpush
