@extends('errors.layout')

@section('title', '419 Sesi Halaman Kedaluwarsa')

@section('content')
    <h1 class="display-1 mb-2 fw-bold text-warning">419<span class="fs-20 text-muted">expired</span></h1>
    <h3 class="text-dark fw-bold mb-2">Sesi Halaman Kedaluwarsa (Page Expired)</h3>
    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 520px;">
        Sesi keamanan pengiriman formulir Anda telah berakhir karena terlalu lama tidak ada aktivitas. Silakan muat ulang halaman.
    </p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
        <a href="javascript:void(0)" onclick="window.location.reload()"
            class="btn btn-warning text-white px-4 py-2">
            <i class="fe fe-refresh-cw me-1"></i> Muat Ulang Halaman
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 py-2">
            <i class="fe fe-log-in me-1"></i> Halaman Login
        </a>
    </div>
@endsection
