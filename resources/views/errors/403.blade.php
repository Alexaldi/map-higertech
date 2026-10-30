@extends('errors.layout')

@section('title', '403 Akses Ditolak')

@section('content')
    <h1 class="display-1 mb-2 fw-bold text-primary">403<span class="fs-20 text-muted">error</span></h1>
    <h3 class="text-dark fw-bold mb-2">Akses Ditolak / Dilarang (Forbidden)</h3>
    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 520px;">
        Maaf, Anda tidak memiliki izin atau hak akses yang cukup untuk membuka halaman atau direktori ini.
    </p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
        <a href="javascript:void(0)" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'"
            class="btn btn-outline-primary px-4 py-2">
            <i class="fe fe-arrow-left me-1"></i> Kembali ke Sebelumnya
        </a>
        <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2">
            <i class="fe fe-log-in me-1"></i> Masuk / Login
        </a>
    </div>
@endsection
