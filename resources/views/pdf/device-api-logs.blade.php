<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Log API Telemetri Perangkat</title>
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

        table.logs {
            width: 100%;
            border-collapse: collapse;
        }

        table.logs thead {
            display: table-header-group;
        }

        table.logs th {
            background: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 5px 4px;
            border: 1px solid #1e3a8a;
        }

        table.logs td {
            padding: 4px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        /* Kelas biasa, bukan :nth-child, agar dompdf tetap ringan untuk tabel panjang */
        table.logs tr.even td {
            background: #f9fafb;
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
                <h1>Laporan Log API Telemetri Perangkat</h1>
                <p>Rekaman request sensor alat IoT yang diteruskan ke subdomain instansi/balai</p>
            </td>
        </tr>
    </table>

    <table class="logs">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th style="width: 15%;">Waktu Masuk (WIB)</th>
                <th style="width: 20%;">Subdomain Balai</th>
                <th>Parameter Sensor (Payload)</th>
                <th style="width: 9%;">Status HTTP</th>
                <th style="width: 7%;" class="text-right">Durasi</th>
                <th style="width: 12%;">IP Device</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                @php
                    $payloadText = !empty($log->payload) && is_array($log->payload)
                        ? collect($log->payload)->map(fn ($val, $key) => $key . ': ' . (is_array($val) ? json_encode($val) : $val))->implode(', ')
                        : '-';
                @endphp
                <tr class="{{ $loop->even ? 'even' : '' }}">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $log->created_at ? $log->created_at->timezone($timezone)->format('d/m/Y H:i:s') : '-' }}</td>
                    <td>{{ $log->sub_domain }}.higertech.com</td>
                    <td>{{ $payloadText }}</td>
                    <td class="{{ $log->status === 'success' ? 'ok' : 'fail' }}">{{ $log->status_code }} {{ $log->status === 'success' ? 'OK' : 'Error' }}</td>
                    <td class="text-right">{{ $log->duration_ms !== null ? $log->duration_ms . ' ms' : '-' }}</td>
                    <td>{{ $log->ip_address ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center muted">Tidak ada data log sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
