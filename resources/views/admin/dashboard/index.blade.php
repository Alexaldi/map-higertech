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
                                <h3 class="mb-2 number-font">{{ $totalInternships }}</h3>
                                <p class="text-muted mb-0">
                                    @if ($latestInternship)
                                        Pendaftaran terbaru
                                        {{ $latestInternship->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->locale('id')
                                            ->translatedFormat('d M Y H.i')
                                        }}
                                    @else
                                        Belum ada data
                                    @endif
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
                                <h3 class="mb-2 number-font">{{ $totalProducts }}</h3>
                                <p class="text-muted mb-0">
                                    @if ($latestProduct)
                                        Terakhir ditambahkan
                                        {{ $latestProduct->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->locale('id')
                                            ->translatedFormat('d M Y H.i')
                                        }}
                                    @else
                                        Belum ada data
                                    @endif
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
                                <h3 class="mb-2 number-font">{{ $totalClients }}</h3>
                                <p class="text-muted mb-0">
                                    @if ($latestClient)
                                        Terakhir ditambahkan
                                        {{ $latestClient->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->locale('id')
                                            ->translatedFormat('d M Y H.i')
                                        }}
                                    @else
                                        Belum ada data
                                    @endif
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
                                <h3 class="mb-2 number-font">{{ $totalArticles }}</h3>
                                <p class="text-muted mb-0">
                                    @if ($latestArticle)
                                        Terakhir ditambahkan
                                        {{ $latestArticle->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->locale('id')
                                            ->translatedFormat('d M Y H.i')
                                        }}
                                    @else
                                        Belum ada data
                                    @endif
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Institusi</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pendingInternships as $internship)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <h6 class="mb-0 fs-14 fw-semibold">
                                            {{ $internship->name }}
                                        </h6>

                                        <span class="fs-12 text-muted">
                                            {{ $internship->email }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $internship->institution }}
                                    </td>

                                    <td>
                                        {{ $internship->type_label }}
                                    </td>

                                    <td>
                                        {{ $internship->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->locale('id')
                                            ->translatedFormat('d M Y H.i')
                                        }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $internship->badge_class }}">
                                            {{ $internship->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.internships.index') }}"
                                            class="btn btn-outline-primary btn-sm rounded-11"
                                            title="Lihat Pendaftaran Magang">
                                            <i class="fe fe-eye me-1"></i>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Tidak ada pendaftaran yang menunggu review.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
        <div class="card custom-card ">
            <div class="card-header">
                <h3 class="card-title">Status Pendaftaran Magang</h3>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="internshipStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- ROW-1 END -->

@push('scripts')
<script>
    $(function () {

        var ctx = document
            .getElementById('internshipStatusChart')
            .getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',

            data: {
                labels: [
                    'Menunggu Review',
                    'Sedang Diproses',
                    'Diterima',
                    'Tidak Diterima'
                ],

                datasets: [{
                    data: [
                        {{ $internshipStatus['pending'] }},
                        {{ $internshipStatus['reviewing'] }},
                        {{ $internshipStatus['accepted'] }},
                        {{ $internshipStatus['rejected'] }}
                    ],

                    backgroundColor: [
                        '#f5b849',
                        '#0774f8',
                        '#09ad95',
                        '#ec546c'
                    ],

                    borderWidth: 0
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                legend: {
                    display: true,
                    position: 'bottom',

                    labels: {
                        fontColor: '#77778e',
                        padding: 15
                    }
                },

                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

    });
</script>
@endpush

@endsection