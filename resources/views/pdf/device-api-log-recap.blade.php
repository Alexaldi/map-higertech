<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Log API Telemetri per Alat</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 14mm 12mm 16mm 12mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            color: #1f2937;
            margin: 0;
        }

        .footer {
            position: fixed;
            bottom: -10mm;
            left: 0;
            right: 0;
            font-size: 7pt;
            color: #6b7280;
        }

        .footer .page-number:after {
            content: "Halaman " counter(page) " dari " counter(pages);
        }

        .header {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #1e3a8a;
            margin-bottom: 10px;
        }

        .header td {
            vertical-align: middle;
            padding-bottom: 6px;
        }

        .header img {
            height: 34px;
        }

        .header .title {
            text-align: right;
        }

        .header h1 {
            font-size: 13pt;
            margin: 0;
            color: #1e3a8a;
        }

        .header p {
            margin: 2px 0 0;
            font-size: 8pt;
            color: #6b7280;
        }

        table.recap {
            width: 100%;
            border-collapse: collapse;
        }

        table.recap thead {
            display: table-header-group;
        }

        table.recap th {
            background: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 5px 4px;
            border: 1px solid #1e3a8a;
        }

        table.recap td {
            padding: 4px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        table.recap tr.even td {
            background: #f9fafb;
        }

        .truncated-note {
            margin-top: 6px;
            font-size: 7pt;
            color: #6b7280;
            font-style: italic;
        }

        table.recap tr.total td {
            background: #eef2ff;
            font-weight: bold;
            border-top: 2px solid #1e3a8a;
        }

        .muted {
            color: #6b7280;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .ok {
            color: #047857;
            font-weight: bold;
        }

        .fail {
            color: #b91c1c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        $periodLabel = $filters['from'] === $filters['to']
            ? \Carbon\Carbon::parse($filters['from'])->translatedFormat('d F Y')
            : \Carbon\Carbon::parse($filters['from'])->translatedFormat('d F Y') . ' s/d ' . \Carbon\Carbon::parse($filters['to'])->translatedFormat('d F Y');
    @endphp

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td>PT Higertech Karya Sinergi &middot; Dicetak {{ $generatedAt->translatedFormat('d F Y, H:i') }} WIB</td>
                <td class="text-right page-number"></td>
            </tr>
        </table>
    </div>

    <table class="header">
        <tr>
            <td>
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Higertech">
                @else
                    <strong>PT Higertech Karya Sinergi</strong>
                @endif
            </td>
            <td class="title">
                <h1>Rekap Laporan Log API Telemetri per Alat</h1>
                <p>Periode: {{ $periodLabel }} (WIB){{ $filters['q'] !== '' ? ' · Kata kunci: "' . $filters['q'] . '"' : '' }}</p>
            </td>
        </tr>
    </table>

    <table class="recap">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th style="width: 11%;">Tanggal</th>
                <th style="width: 11%;">ID Alat</th>
                <th>Subdomain Balai</th>
                <th style="width: 9%;" class="text-right">Total Masuk</th>
                <th style="width: 10%;" class="text-right">Berhasil (200)</th>
                <th style="width: 7%;" class="text-right">Gagal</th>
                <th style="width: 16%;">Rincian Kode Gagal</th>
                <th style="width: 8%;" class="text-right">% Berhasil</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                @php $rate = $recap->successRate($row); @endphp
                <tr class="{{ $loop->even ? 'even' : '' }}">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->recap_date)->format('d/m/Y') }}</td>
                    <td>{{ $row->device_id }}</td>
                    <td>{{ $row->sub_domain }}.higertech.com</td>
                    <td class="text-right">{{ number_format($row->total) }}</td>
                    <td class="text-right ok">{{ number_format($row->success) }}</td>
                    <td class="text-right {{ (int) $row->failed > 0 ? 'fail' : 'muted' }}">{{ number_format($row->failed) }}</td>
                    <td class="muted">{{ $recap->formatBreakdown($breakdown[$recap->rowKey($row)] ?? []) ?: '-' }}</td>
                    <td class="text-right">{{ $rate !== null ? number_format($rate, 1, ',', '.') . '%' : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center muted">Tidak ada data masuk pada periode ini.</td>
                </tr>
            @endforelse

            @if ($rows->isNotEmpty())
                <tr class="total">
                    <td colspan="2">{{ $totalRows > $rows->count() ? 'TOTAL SELURUH DATA' : 'TOTAL' }}</td>
                    <td>{{ number_format($summary['devices']) }} alat</td>
                    <td></td>
                    <td class="text-right">{{ number_format($summary['total']) }}</td>
                    <td class="text-right ok">{{ number_format($summary['success']) }}</td>
                    <td class="text-right fail">{{ number_format($summary['failed']) }}</td>
                    <td></td>
                    <td class="text-right">{{ $summary['rate'] !== null ? number_format($summary['rate'], 1, ',', '.') . '%' : '-' }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($totalRows > $rows->count())
        <div class="truncated-note">
            * Menampilkan {{ number_format($rows->count()) }} dari {{ number_format($totalRows) }} baris rekap. Baris TOTAL dihitung dari seluruh data
            pada periode ini. Gunakan ekspor CSV untuk rekap lengkap.
        </div>
    @endif
</body>

</html>
