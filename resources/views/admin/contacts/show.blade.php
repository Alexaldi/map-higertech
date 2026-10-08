@extends('admin.layouts.app')
@section('title', 'Detail Pesan Kontak | Higertech Karya Sinergi')
@section('content')
<div class="row mt-5">
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Detail Pesan Kontak</h3>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 200px">Nama Lengkap</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Perusahaan / Instansi</th>
                            <td>{{ $contact->company ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon / WhatsApp</th>
                            <td>{{ $contact->phone ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Diterima</th>
                            <td>{{ strtolower($contact->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H.i')) }}</td>
                        </tr>
                        <tr>
                            <th>Isi Pesan</th>
                            <td>
                                <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-end">
                <form
                    action="{{ route('admin.contacts.destroy', $contact) }}"
                    method="POST"
                    class="d-inline delete-form"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

