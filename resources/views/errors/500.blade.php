@extends('errors.layout')

@section('title', '500 Kesalahan Server')

@section('content')
    <h1 class="display-1 mb-2 fw-bold text-danger">500<span class="fs-20 text-muted">error</span></h1>
    <h3 class="text-dark fw-bold mb-2">Terjadi Kesalahan Server (Internal Server Error)</h3>
    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 520px;">
        Terjadi kendala pada sistem server kami saat memproses permintaan Anda. Tim teknis kami telah mencatat peristiwa ini.
    </p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
        <a href="javascript:void(0)" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'"
            class="btn btn-outline-danger px-4 py-2">
            <i class="fe fe-arrow-left me-1"></i> Kembali ke Sebelumnya
        </a>
        <a href="{{ url('/') }}" class="btn btn-danger px-4 py-2">
            <i class="fe fe-home me-1"></i> Ke Halaman Utama
        </a>
    </div>
@endsection
