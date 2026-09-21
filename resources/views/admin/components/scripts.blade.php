<!-- JQUERY JS -->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('admin/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="{{ asset('admin/assets/plugins/select2/select2.full.min.js') }}"></script>

<!-- INTERNAL Data tables js-->
<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

<!-- SIDE-MENU JS-->
<script src="{{ asset('admin/assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- SIDEBAR JS -->
<script src="{{ asset('admin/assets/plugins/sidebar/sidebar.js') }}"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="{{ asset('admin/assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/p-scroll/pscroll.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/p-scroll/pscroll-1.js') }}"></script>

<!-- DASHBOARD ONLY CHARTS & SCRIPTS -->
@if (request()->routeIs('admin.dashboard'))
    <!-- SPARKLINE JS-->
    <script src="{{ asset('admin/assets/js/jquery.sparkline.min.js') }}"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="{{ asset('admin/assets/js/circle-progress.min.js') }}"></script>

    <!-- CHARTJS CHART JS-->
    <script src="{{ asset('admin/assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/chart/utils.js') }}"></script>

    <!-- PIETY CHART JS-->
    <script src="{{ asset('admin/assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/peitychart/peitychart.init.js') }}"></script>

    <!-- ECHART JS-->
    <script src="{{ asset('admin/assets/plugins/echarts/echarts.js') }}"></script>

    <!-- APEXCHART JS -->
    <script src="{{ asset('admin/assets/js/apexcharts.js') }}"></script>

    <!-- INDEX JS (Dashboard only) -->
    <script src="{{ asset('admin/assets/js/index1.js') }}"></script>
@endif

<!-- CUSTOM JS -->
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>

<!-- sweetalert (LOCAL - no CDN hangs) -->
<script src="{{ asset('admin/assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

<!-- GUARANTEE GLOBAL-LOADER DISMISSAL -->
<script>
    (function() {
        function dismissLoader() {
            var loader = document.getElementById('global-loader');
            if (loader && loader.style.display !== 'none') {
                if (window.jQuery) {
                    window.jQuery(loader).fadeOut('normal');
                } else {
                    loader.style.transition = 'opacity 0.25s ease';
                    loader.style.opacity = '0';
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 250);
                }
            }
        }
        if (document.readyState === 'complete') {
            setTimeout(dismissLoader, 100);
        } else {
            window.addEventListener('load', dismissLoader);
            setTimeout(dismissLoader, 800);
        }
    })();
</script>

<!-- PWA -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js', { scope: '/admin/' }).catch((err) => {
                console.warn('Service worker registration failed:', err);
            });
        });
    }
</script>
<script>
    let deferredInstallPrompt = null;

    const getInstallButton = () => {
        return document.querySelector('#pwa-install-btn');
    };

    const getInstallTitle = () => {
        return document.querySelector('#pwa-install-title');
    };

    const getInstallDescription = () => {
        return document.querySelector('#pwa-install-description');
    };

    const isStandalone = () => {
        return window.matchMedia('(display-mode: standalone)').matches
            || window.navigator.standalone === true;
    };

    const isIOS = () => {
        const userAgent = window.navigator.userAgent.toLowerCase();

        return /iphone|ipad|ipod/.test(userAgent)
            || (
                userAgent.includes('macintosh')
                && window.navigator.maxTouchPoints > 1
            );
    };

    const hideInstallButton = () => {
        const button = getInstallButton();

        if (button) {
            button.classList.add('d-none');
        }
    };

    const showInstallButton = () => {
        const button = getInstallButton();

        if (button) {
            button.classList.remove('d-none');
        }
    };

    const setIOSButton = () => {
        const title = getInstallTitle();
        const description = getInstallDescription();

        if (title) {
            title.textContent = 'Cara Install Aplikasi';
        }

        if (description) {
            description.textContent = 'Tambahkan ke Home Screen';
        }
    };

    const setNormalInstallButton = () => {
        const title = getInstallTitle();
        const description = getInstallDescription();

        if (title) {
            title.textContent = 'Install Aplikasi';
        }

        if (description) {
            description.textContent = 'Tambahkan ke Home Screen';
        }
    };

    const showIOSInstallGuide = () => {
        if (document.querySelector('#pwa-ios-install-modal')) {
            document.querySelector('#pwa-ios-install-modal').classList.remove('d-none');
            return;
        }

        const modal = document.createElement('div');

        modal.id = 'pwa-ios-install-modal';

        modal.innerHTML = `
            <div
                style="
                    position: fixed;
                    inset: 0;
                    z-index: 9999;
                    display: flex;
                    align-items: flex-end;
                    justify-content: center;
                    padding: 1rem;
                    background: rgba(0, 0, 0, 0.45);
                "
            >
                <div
                    style="
                        width: 100%;
                        max-width: 420px;
                        padding: 1.25rem;
                        border-radius: 1rem;
                        background: #fff;
                        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.2);
                    "
                >
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Install Aplikasi</h5>

                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            id="pwa-ios-close"
                        >
                            <i class="fe fe-x"></i>
                        </button>
                    </div>

                    <p class="text-muted mb-3">
                        Untuk menambahkan aplikasi ke iPhone atau iPad:
                    </p>

                    <div class="mb-3">
                        <strong>1. Tekan tombol Share</strong>
                        <p class="small text-muted mb-0">
                            Gunakan tombol Share di Safari.
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong>2. Pilih "Add to Home Screen"</strong>
                        <p class="small text-muted mb-0">
                            Ikuti menu yang tersedia di Safari.
                        </p>
                    </div>

                    <div>
                        <strong>3. Tambahkan sebagai Web App</strong>
                        <p class="small text-muted mb-0">
                            Jika muncul opsi "Open as Web App", biarkan aktif.
                        </p>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        document
            .querySelector('#pwa-ios-close')
            ?.addEventListener('click', () => {
                modal.classList.add('d-none');
            });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('d-none');
            }
        });
    };

    window.addEventListener('beforeinstallprompt', (event) => {
        if (isIOS()) {
            return;
        }

        event.preventDefault();

        deferredInstallPrompt = event;

        if (!isStandalone()) {
            setNormalInstallButton();
            showInstallButton();
        }
    });

    window.addEventListener('appinstalled', () => {
        deferredInstallPrompt = null;

        hideInstallButton();
    });

    document.addEventListener('click', async (event) => {
        const button = event.target.closest('#pwa-install-btn');

        if (!button) {
            return;
        }

        if (isIOS()) {
            showIOSInstallGuide();
            return;
        }

        if (!deferredInstallPrompt) {
            return;
        }

        const promptEvent = deferredInstallPrompt;

        deferredInstallPrompt = null;

        const result = await promptEvent.prompt();

        if (result.outcome === 'accepted') {
            hideInstallButton();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (isStandalone()) {
            hideInstallButton();
            return;
        }

        if (isIOS()) {
            setIOSButton();
            showInstallButton();
            return;
        }

        if (deferredInstallPrompt) {
            setNormalInstallButton();
            showInstallButton();
        }
    });
</script>