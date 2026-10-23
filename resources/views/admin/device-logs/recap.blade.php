@extends('admin.layouts.app')

@section('title', 'Rekap Log API Device Telemetri | Higertech Karya Sinergi')

@section('content')
    @include('admin.device-logs.partials.tabs')

    @php
        $isSingleDay = $filters['from'] === $filters['to'];
        $periodLabel = $isSingleDay
            ? \Carbon\Carbon::parse($filters['from'])->translatedFormat('d F Y')
            : \Carbon\Carbon::parse($filters['from'])->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($filters['to'])->translatedFormat('d M Y');
        $exportParams = array_filter([
            'from' => $filters['from'],
            'to' => $filters['to'],
            'q' => $filters['q'],
            'sort' => $filters['sort'],
        ]);
        $today = now('Asia/Jakarta');
        $quickRanges = [
            'Hari ini' => [$today->toDateString(), $today->toDateString()],
            'Kemarin' => [$today->copy()->subDay()->toDateString(), $today->copy()->subDay()->toDateString()],
            '7 hari terakhir' => [$today->copy()->subDays(6)->toDateString(), $today->toDateString()],
            '30 hari terakhir' => [$today->copy()->subDays(29)->toDateString(), $today->toDateString()],
        ];
        $rateClass = fn (?float $rate) => match (true) {
            $rate === null => 'secondary',
            $rate >= 95 => 'success',
            $rate >= 80 => 'warning',
            default => 'danger',
        };
    @endphp

    <div class="row">
        <!-- Stat Cards -->
        @foreach ([
            ['label' => 'Jumlah Alat (ID)', 'value' => number_format($summary['devices']), 'bg' => 'bg-primary-gradient', 'icon' => 'fe-cpu'],
            ['label' => 'Total Data Masuk', 'value' => number_format($summary['total']), 'bg' => 'bg-info-gradient', 'icon' => 'fe-activity'],
            ['label' => 'Berhasil (200)', 'value' => number_format($summary['success']), 'bg' => 'bg-success-gradient', 'icon' => 'fe-check-circle'],
            ['label' => 'Gagal / Error', 'value' => number_format($summary['failed']), 'bg' => 'bg-danger-gradient', 'icon' => 'fe-alert-triangle'],
            ['label' => '% Berhasil', 'value' => $summary['rate'] !== null ? number_format($summary['rate'], 1, ',', '.') . '%' : '-', 'bg' => 'bg-warning-gradient', 'icon' => 'fe-percent'],
        ] as $card)
            <div class="col-sm-6 col-md-4 col-xl">
                <div class="card {{ $card['bg'] }} text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 text-white-50">{{ $card['label'] }}</h6>
                                <h2 class="mb-0 text-white font-weight-bold">{{ $card['value'] }}</h2>
                            </div>
                            <div class="ms-auto">
                                <span class="avatar avatar-md bg-white-transparent rounded-circle">
                                    <i class="fe {{ $card['icon'] }} text-white fs-20"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Recap Table -->
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="card-title mb-0">Rekap Laporan per Alat</h3>
                        <p class="fs-12 text-muted mb-0 mt-1">
                            Jumlah data masuk per ID alat per hari (WIB), berhasil (200) dan gagal &middot; Periode: <strong>{{ $periodLabel }}</strong>
                        </p>
                    </div>
                    @if ($rows->total() > 0)
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="{{ route('admin.device-logs.recap.export.csv', $exportParams) }}" class="btn btn-outline-success btn-sm btn-export"
                                title="Unduh rekap sesuai filter dalam format CSV">
                                <i class="fe fe-file-text me-1"></i> Ekspor CSV
                            </a>
                            <a href="{{ route('admin.device-logs.recap.export.pdf', $exportParams) }}" class="btn btn-outline-primary btn-sm btn-export"
                                title="Unduh rekap sesuai filter dalam format PDF (maks. {{ number_format($pdfMaxRows) }} baris)">
                                <i class="fe fe-download me-1"></i> Ekspor PDF
                            </a>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.device-logs.recap') }}" method="GET" class="mb-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <label class="d-flex align-items-center gap-2 mb-0">
                                Tampilkan
                                <select name="per_page" class="form-select form-select-sm" style="width: 80px;" onchange="this.form.submit()">
                                    @foreach ($perPageOptions as $option)
                                        <option value="{{ $option }}" {{ $perPage === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                baris
                            </label>

                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <select name="sort" class="form-select form-select-sm" style="width: 190px;" onchange="this.form.submit()"
                                    aria-label="Urutkan">
                                    @foreach ($sortOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $filters['sort'] === $value ? 'selected' : '' }}>Urut: {{ $label }}</option>
                                    @endforeach
                                </select>

                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="date" name="from" class="form-control" value="{{ $filters['from'] }}"
                                        title="Dari tanggal (WIB)" aria-label="Dari tanggal">
                                    <span class="input-group-text">s/d</span>
                                    <input type="date" name="to" class="form-control" value="{{ $filters['to'] }}"
                                        title="Sampai tanggal (WIB)" aria-label="Sampai tanggal">
                                </div>

                                <div class="input-group input-group-sm" style="width: 240px;">
                                    <input type="text" name="q" class="form-control" placeholder="ID alat / subdomain..."
                                        value="{{ $filters['q'] }}" aria-label="Cari ID alat atau subdomain">
                                    <button type="submit" class="btn btn-primary" title="Terapkan filter"><i class="fe fe-search"></i></button>
                                    <a href="{{ route('admin.device-logs.recap') }}" class="btn btn-light" title="Reset ke hari ini"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-wrap gap-1 mt-2">
                            <span class="fs-12 text-muted me-1">Periode cepat:</span>
                            @foreach ($quickRanges as $label => [$rangeFrom, $rangeTo])
                                @php $isActive = $filters['from'] === $rangeFrom && $filters['to'] === $rangeTo; @endphp
                                <a href="{{ route('admin.device-logs.recap', array_filter(['from' => $rangeFrom, 'to' => $rangeTo, 'q' => $filters['q'], 'sort' => $filters['sort'], 'per_page' => $perPage])) }}"
                                    class="btn btn-sm {{ $isActive ? 'btn-primary' : 'btn-outline-light text-dark' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </form>

                    @if ($filters['clamped'])
                        <div class="alert alert-warning py-2 fs-13">
                            <i class="fe fe-info me-1"></i> Rentang tanggal dibatasi maksimal {{ $maxRangeDays }} hari, sehingga rekap ditampilkan sampai
                            {{ \Carbon\Carbon::parse($filters['to'])->translatedFormat('d F Y') }}.
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Tanggal</th>
                                    <th>ID Alat</th>
                                    <th>Subdomain Balai</th>
                                    <th class="text-end">Total Masuk</th>
                                    <th class="text-end">Berhasil (200)</th>
                                    <th class="text-end">Gagal</th>
                                    <th style="width: 170px;">% Berhasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rows as $row)
                                    @php
                                        $rate = $recap->successRate($row);
                                        $codes = $breakdown[$recap->rowKey($row)] ?? [];
                                    @endphp
                                    <tr>
                                        <td>{{ $rows->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span class="fs-13 text-dark fw-medium">{{ \Carbon\Carbon::parse($row->recap_date)->translatedFormat('d M Y') }}</span>
                                            <small class="d-block text-muted fs-11">{{ \Carbon\Carbon::parse($row->recap_date)->translatedFormat('l') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border fs-12">{{ $row->device_id }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $row->sub_domain }}</span>
                                            <small class="d-block text-muted fs-11">{{ $row->sub_domain }}.higertech.com</small>
                                        </td>
                                        <td class="text-end fw-semibold">{{ number_format($row->total) }}</td>
                                        <td class="text-end text-success fw-semibold">{{ number_format($row->success) }}</td>
                                        <td class="text-end">
                                            @if ((int) $row->failed > 0)
                                                <span class="text-danger fw-semibold">{{ number_format($row->failed) }}</span>
                                                <small class="d-block text-muted fs-11">{{ $recap->formatBreakdown($codes) }}</small>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($rate !== null)
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 6px;">
                                                        <div class="progress-bar bg-{{ $rateClass($rate) }}" style="width: {{ $rate }}%"></div>
                                                    </div>
                                                    <span class="fs-12 fw-semibold text-{{ $rateClass($rate) }}">{{ number_format($rate, 1, ',', '.') }}%</span>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fe fe-inbox fs-30 d-block mb-2 text-muted opacity-50"></i>
                                            Tidak ada data masuk pada periode {{ $periodLabel }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($rows->total() > 0)
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <div class="small text-muted">
                                Menampilkan {{ $rows->firstItem() }} sampai {{ $rows->lastItem() }} dari
                                {{ number_format($rows->total()) }} baris rekap
                            </div>
                            <div>
                                {{ $rows->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.device-logs.partials.export-lock-script')
@endsection
