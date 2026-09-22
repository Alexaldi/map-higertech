@extends('admin.layouts.app')
@section('title', 'Dashboard | Higertech Karya Sinergi')
@section('content')

<!-- ROW-1 -->
<div class="row mt-5">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="">Pendaftaran Magang</h6>
                                <h3 class="mb-2 number-font">34</h3>
                                <p class="text-muted mb-0">
                                    last month
                                </p>
                            </div>
                            <div class="col col-auto">
                                <div class="counter-icon bg-primary-gradient box-shadow-primary brround ms-auto">
                                    <i class="fe fe-award text-white mb-5 "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="">Total Produk</h6>
                                <h3 class="mb-2 number-font">56</h3>
                                <p class="text-muted mb-0">
                                    last month
                                </p>
                            </div>
                            <div class="col col-auto">
                                <div class="counter-icon bg-danger-gradient box-shadow-danger brround  ms-auto">
                                    <i class="fe fe-cpu text-white mb-5 "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="">Mitra & Client</h6>
                                <h3 class="mb-2 number-font">12</h3>
                                <p class="text-muted mb-0">
                                    last month
                                </p>
                            </div>
                            <div class="col col-auto">
                                <div class="counter-icon bg-secondary-gradient box-shadow-secondary brround ms-auto">
                                    <i class="fe fe-briefcase text-white mb-5 "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="">Total Artikel</h6>
                                <h3 class="mb-2 number-font">12</h3>
                                <p class="text-muted mb-0">
                                    last month
                                </p>
                            </div>
                            <div class="col col-auto">
                                <div class="counter-icon bg-success-gradient box-shadow-success brround  ms-auto">
                                    <i class="fe fe-file-text text-white mb-5 "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pendaftaran Magang Terbaru</h3>
            </div>
            <div class="card-body pb-0">
                <h1>test</h1>
            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
        <div class="card custom-card ">
            <div class="card-header">
                <h3 class="card-title">Recent Orders</h3>
            </div>
            <div class="card-body pt-0">
                <h1>test</h1>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- ROW-1 END -->
@endsection