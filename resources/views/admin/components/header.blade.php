<!-- mobile header -->
 <div class="app-header header">
    <div class="container-fluid">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
            <a class="header-brand1 d-flex d-md-none" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/brand/logo.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('images/brand/higertech-logo.png') }}" class="header-brand-img light-logo1" alt="logo">
            </a><!-- LOGO -->
            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical text-dark"></span>
                </button>
                <div class="dropdown d-none d-md-flex header-settings">
                    <a href="#" class="nav-link icon " data-bs-toggle="sidebar-right" data-target=".sidebar-right">
                        <i class="fe fe-menu"></i>
                    </a>
                </div><!-- SIDE-MENU -->
            </div>
        </div>
    </div>
</div>
<div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <div class="d-flex order-lg-2 ms-auto">
            <div class="dropdown d-md-flex header-settings">
                <a href="#" class="nav-link icon " data-bs-toggle="sidebar-right" data-target=".sidebar-right">
                    <i class="fe fe-menu"></i>
                </a>
            </div><!-- SIDE-MENU -->
        </div>
    </div>
</div>