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
