@extends('errors.layout')

@section('title', '404 Halaman Tidak Ditemukan')

@section('content')
    <h1 class="display-1 mb-2 fw-bold text-primary">404<span class="fs-20 text-muted">error</span></h1>
    <h3 class="text-dark fw-bold mb-2">Halaman Tidak Ditemukan (Not Found)</h3>
    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 520px;">
        Maaf, tautan atau halaman yang Anda tuju tidak tersedia, mungkin telah dipindahkan, atau alamat URL yang dimasukkan salah.
    </p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
        <a href="javascript:void(0)" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'"
            class="btn btn-outline-primary px-4 py-2">
            <i class="fe fe-arrow-left me-1"></i> Kembali ke Sebelumnya
        </a>
        <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2">
            <i class="fe fe-home me-1"></i> Ke Halaman Utama
        </a>
    </div>
@endsection
