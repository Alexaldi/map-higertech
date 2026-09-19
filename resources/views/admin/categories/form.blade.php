@extends('admin.layouts.app')
@section('title', 'Kategori | Higertech Karya Sinergi')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                    @csrf
                    @isset($category)
                        @method('PUT')
                    @endisset

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Masukkan nama kategori">
                                @error('name')
                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sub_nama" class="form-label">Sub Nama Kategori</label>
                                <input type="text" class="form-control @error('sub_nama') is-invalid @enderror" id="sub_nama" name="sub_nama" value="{{ old('sub_nama', $category->sub_nama ?? '') }}" placeholder="Masukkan sub nama kategori">
                                @error('sub_nama')
                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe" class="form-label">Tipe Kategori</label>
                                <select class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe">
                                    <option value="" disabled {{ old('tipe', $category->tipe ?? '') === '' ? 'selected' : '' }}>-- Pilih Tipe --</option>
                                    <option value="produk" {{ old('tipe', $category->tipe ?? '') === 'produk' ? 'selected' : '' }}>Produk</option>
                                    <option value="artikel" {{ old('tipe', $category->tipe ?? '') === 'artikel' ? 'selected' : '' }}>Artikel</option>
                                </select>
                                <small class="text-muted fs-12">Menentukan kategori ini muncul di form Produk atau Artikel.</small>
                                @error('tipe')
                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Deskripsi <span class="text-muted fs-12">(opsional)</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Masukkan deskripsi kategori">{{ old('description', $category->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1 fs-12">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 mb-0">
                        {{ isset($category) ? 'Perbarui Kategori' : 'Simpan Kategori' }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light mt-3 mb-0 ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
