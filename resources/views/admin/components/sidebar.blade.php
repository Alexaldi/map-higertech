<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/brand/logo.png') }}" class="header-brand-img light-logo" alt="logo">
            <img src="{{ asset('images/brand/higertech-logo.png') }}" class="header-brand-img light-logo1" alt="logo">
        </a><!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li><h3>Main</h3></li>
        <li class="slide">
            <a class="side-menu__item"  data-bs-toggle="slide" href="{{ route('admin.dashboard') }}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
        </li>
        <li><h3>MANAGEMENT</h3></li>
        <li>
            <a class="side-menu__item" href="{{ route('admin.users.index') }}"><i class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Pengguna</span></a>
        </li>
        <li><h3>DATA MASTER</h3></li>
        <li>
            <a class="side-menu__item" href="{{ route('admin.categories.index') }}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Kategori</span></a>
            <a class="side-menu__item" href="widgets.html"><i class="side-menu__icon fe fe-cpu"></i><span class="side-menu__label">Produk</span></a>
            <a class="side-menu__item" href="widgets.html"><i class="side-menu__icon fe fe-file-text"></i><span class="side-menu__label">Artikel</span></a>
        </li>
    </ul>
</aside>
