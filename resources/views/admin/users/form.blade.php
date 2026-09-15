@extends('admin.layouts.app')
@section('title', 'Users | Higertech Karya Sinergi')
@section('content')

<div class="row mt-4">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

        <div class="card">

            <div class="card-header">
                <h4 class="card-title">
                    {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}
                </h4>
            </div>

            <div class="card-body">

                <form
                    action="{{ isset($user)
                        ? route('admin.users.update', $user)
                        : route('admin.users.store') }}"
                    method="POST"
                >

                    @csrf

                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="row">

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name" class="form-label">
                                    Nama
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name ?? '') }}"
                                    placeholder="Masukkan nama"
                                >

                                @error('name')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email ?? '') }}"
                                    placeholder="Masukkan email"
                                >

                                @error('email')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>


                        {{-- Password --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="password" class="form-label">
                                    Password
                                    @if(isset($user))
                                        <span class="text-muted fs-12">
                                            (kosongkan jika tidak ingin mengubah)
                                        </span>
                                    @endif
                                </label>

                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="{{ isset($user) ? 'Masukkan password baru' : 'Masukkan password' }}"
                                >

                                @error('password')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>


                        {{-- Confirm Password --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="password_confirmation" class="form-label">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Konfirmasi password"
                                >

                                @error('password')
                                    <div class="text-danger mt-1 fs-12">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary mt-3 mb-0"
                    >
                        {{ isset($user) ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
                    </button>

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="btn btn-light mt-3 mb-0 ms-2"
                    >
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection