<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/brand/logo.png') }}" class="header-brand-img light-logo" alt="logo">
            <img src="{{ asset('images/brand/higertech-logo.png') }}" class="header-brand-img light-logo1"
                alt="logo">
        </a><!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li>
            <h3>Main</h3>
        </li>
        <li class="slide">
            <a class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                data-bs-toggle="slide" href="{{ route('admin.dashboard') }}" {!! request()->routeIs('admin.dashboard') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
        </li>
        <li>
            <h3>MANAGEMENT</h3>
        </li>
        <li>
            <a class="side-menu__item {{ request()->routeIs('admin.users.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.users.index') }}" {!! request()->routeIs('admin.users.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Pengguna</span></a>
            <a class="side-menu__item {{ request()->routeIs('admin.internships.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.internships.index') }}" {!! request()->routeIs('admin.internships.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-award"></i><span class="side-menu__label">Pendaftaran Magang</span>
                @php
                    $pendingCount = \App\Models\InternshipApplication::where('status', 'pending')->count();
                @endphp
                @if ($pendingCount > 0)
                    <span class="badge bg-warning text-dark rounded-pill ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>
            <a class="side-menu__item {{ request()->routeIs('admin.settings.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.settings.index') }}" {!! request()->routeIs('admin.settings.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">Pengaturan
                    Website</span></a>
        </li>
        <li>
            <h3>DATA MASTER</h3>
        </li>
        <li>
            <a class="side-menu__item {{ request()->routeIs('admin.categories.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.categories.index') }}" {!! request()->routeIs('admin.categories.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Kategori</span></a>
            <a class="side-menu__item {{ request()->routeIs('admin.clients.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.clients.index') }}" {!! request()->routeIs('admin.clients.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Mitra & Klien</span></a>
            <a class="side-menu__item" href="widgets.html"><i class="side-menu__icon fe fe-cpu"></i><span
                    class="side-menu__label">Produk</span></a>
            <a class="side-menu__item {{ request()->routeIs('admin.articles.*') ? 'active pointer-events-none cursor-default select-none' : '' }}"
                href="{{ route('admin.articles.index') }}" {!! request()->routeIs('admin.articles.*') ? 'aria-current="page" tabindex="-1"' : '' !!}><i
                    class="side-menu__icon fe fe-file-text"></i><span
                    class="side-menu__label">Artikel</span></a>
        </li>
    </ul>
</aside>
