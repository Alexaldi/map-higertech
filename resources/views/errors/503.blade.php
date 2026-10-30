@extends('errors.layout')

@section('title', '503 Pemeliharaan Sistem')

@section('content')
    <h1 class="display-1 mb-2 fw-bold text-info">503<span class="fs-20 text-muted">maintenance</span></h1>
    <h3 class="text-dark fw-bold mb-2">Sistem Sedang Dalam Pemeliharaan (Maintenance)</h3>
    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 520px;">
        Kami sedang melakukan pemeliharaan dan pembaruan sistem berkala untuk meningkatkan kehandalan dan performa layanan.
    </p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
        <a href="javascript:void(0)" onclick="window.location.reload()"
            class="btn btn-info text-white px-4 py-2">
            <i class="fe fe-refresh-cw me-1"></i> Coba Muat Ulang
        </a>
    </div>
@endsection
