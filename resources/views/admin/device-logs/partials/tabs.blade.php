{{-- Navigasi antara riwayat log dan rekap laporan --}}
<ul class="nav nav-pills mt-5 mb-3 gap-2">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.device-logs.index') ? 'active' : 'bg-white' }}"
            href="{{ route('admin.device-logs.index') }}">
            <i class="fe fe-list me-1"></i> Riwayat Log
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.device-logs.recap') ? 'active' : 'bg-white' }}"
            href="{{ route('admin.device-logs.recap') }}">
            <i class="fe fe-bar-chart-2 me-1"></i> Rekap Laporan per Alat
        </a>
    </li>
</ul>
