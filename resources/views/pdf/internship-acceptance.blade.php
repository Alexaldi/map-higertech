<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Permohonan - {{ $application->acceptance_number_formatted }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 18mm 20mm 20mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #111111;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Header */
        .kop-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .kop-logo {
            width: 220px;
            vertical-align: top;
        }

        .kop-logo img {
            max-width: 210px;
            height: auto;
        }

        .kop-accent {
            text-align: right;
            vertical-align: top;
        }

        /* Angled decorative bands */
        .accent-polygon {
            display: inline-block;
            height: 22px;
            width: 140px;
        }

        .title-section {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 16px;
        }

        .title-text {
            font-size: 12.5pt;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Metadata Surat */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10.5pt;
        }

        .meta-table td {
            vertical-align: top;
            padding: 1px 0;
        }

        .meta-label {
            width: 80px;
        }

        .meta-colon {
            width: 15px;
            text-align: center;
        }

        .content-p {
            margin: 0 0 10px 0;
            text-align: justify;
            text-justify: inter-word;
            font-size: 10.5pt;
        }

        /* Tabel Mahasiswa */
        .members-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 14px 0;
            font-size: 10pt;
        }

        .members-table th,
        .members-table td {
            border: 1px solid #222222;
            padding: 5px 8px;
        }

        .members-table th {
            background-color: #f8fafc;
            font-weight: bold;
            text-align: center;
        }

        .col-no {
            width: 38px;
            text-align: center;
        }

        .col-nim {
            width: 140px;
            text-align: center;
        }

        /* Ketentuan Pelaksanaan */
        .terms-list {
            margin: 4px 0 12px 18px;
            padding: 0;
            font-size: 10.5pt;
        }

        .terms-list li {
            margin-bottom: 4px;
            text-align: justify;
        }

        /* Signature Block */
        .sign-wrapper {
            width: 100%;
            margin-top: 16px;
        }

        .sign-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sign-box {
            width: 270px;
            text-align: center;
            font-size: 10.5pt;
            vertical-align: top;
        }

        .sign-space {
            height: 60px;
            position: relative;
        }

        .sign-logo-stamp {
            position: absolute;
            left: 30px;
            top: -5px;
            width: 80px;
            opacity: 0.85;
        }

        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .sign-role {
            font-size: 10.5pt;
        }

        /* Footer */
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #444444;
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <table class="kop-header">
        <tr>
            <td class="kop-logo">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="HIGERTECH KARYA SINERGI">
                @else
                    <h2
                        style="margin: 0; color: #16275E; font-family: Arial, sans-serif; font-size: 16pt; font-weight: 800;">
                        HIGERTECH</h2>
                    <small style="color: #64748b; font-family: Arial, sans-serif; letter-spacing: 2px;">KARYA
                        SINERGI</small>
                @endif
            </td>
            <td class="kop-accent">
                {{-- Aksen Biru & Merah khas PT Higertech --}}
                <div style="text-align: right;">
                    <span
                        style="display: inline-block; width: 60px; height: 8px; background: #C5221F; margin-right: 4px;"></span>
                    <span style="display: inline-block; width: 90px; height: 8px; background: #16275E;"></span>
                </div>
            </td>
        </tr>
    </table>

    {{-- JUDUL SURAT --}}
    <div class="title-section">
        <div class="title-text">SURAT BALASAN PERMOHONAN</div>
    </div>

    {{-- METADATA NOMOR & TUJUAN --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">No</td>
            <td class="meta-colon">:</td>
            <td style="font-weight: bold;">{{ $application->acceptance_number_formatted }}</td>
        </tr>
        <tr>
            <td class="meta-label">Tanggal</td>
            <td class="meta-colon">:</td>
            <td>{{ $application->acceptance_date_formatted }}</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 10px;">Kepada Yth.</td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>{{ $application->head_of_program ?: ($application->type === 'vocational' ? 'Kepala Program Keahlian ' . $application->major : 'Ketua Program Studi ' . $application->major) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">{{ $application->institution }}</td>
        </tr>
        <tr>
            <td colspan="3">{{ $application->institution_address ?: 'Bandung' }}</td>
        </tr>
        <tr>
            <td style="padding-top: 8px;">Perihal</td>
            <td class="meta-colon" style="padding-top: 8px;">:</td>
            <td style="padding-top: 8px; font-weight: bold;">Balasan Permohonan Kerja Praktek</td>
        </tr>
    </table>

    {{-- PEMBUKA --}}
    <p class="content-p">
        Dengan Hormat,
    </p>
    <p class="content-p">
        Menindaklanjuti surat Permohonan Kerja Praktek
        @if ($application->reference_number)
            Nomor : <strong>{{ $application->reference_number }}</strong>,
        @endif
        @if ($application->reference_date_formatted)
            pada tanggal {{ $application->reference_date_formatted }},
        @endif
        dengan ini kami menyatakan <strong>Menerima</strong>
        {{ $application->type === 'vocational' ? 'siswa/i' : 'mahasiswa/i' }}
        Program Studi {{ $application->major }} {{ $application->institution }}, untuk melaksanakan Kerja Praktek di
        <strong>PT. Higertech Karya Sinergi</strong>.
    </p>

    {{-- TABEL ANGGOTA TIM / PESERTA --}}
    <p class="content-p" style="margin-bottom: 4px;">
        Adapun identitas {{ $application->type === 'vocational' ? 'siswa/i' : 'mahasiswa/i' }} tersebut adalah sebagai
        berikut: :
    </p>

    <table class="members-table">
        <thead>
            <tr>
                <th class="col-no">No.</th>
                <th>Nama</th>
                <th class="col-nim">{{ $application->type === 'vocational' ? 'NISN / NIK' : 'NIM' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($application->all_members as $idx => $member)
                <tr>
                    <td class="col-no">{{ $idx + 1 }}.</td>
                    <td style="font-weight: 500;">{{ $member->name }}</td>
                    <td class="col-nim">{{ $member->identity_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- KETENTUAN PELAKSANAAN --}}
    <p class="content-p" style="margin-bottom: 2px;">
        Ketentuan Pelaksanaan Kerja Praktek di PT Higertech Karya Sinergi:
    </p>
    <ol class="terms-list">
        <li>Periode Kerja Praktek akan berlangsung mulai tanggal
            <strong>{{ $application->period_letter_formatted }}</strong>.</li>
        <li>{{ $application->type === 'vocational' ? 'Siswa/i' : 'Mahasiswa/i' }} wajib mematuhi peraturan dan tata
            tertib yang berlaku di perusahaan.</li>
        <li>{{ $application->type === 'vocational' ? 'Siswa/i' : 'Mahasiswa/i' }} diharapkan membawa perlengkapan
            pendukung yang diperlukan selama Kerja Praktek.</li>
        <li>Laporan akhir Kerja Praktek agar disusun dan diserahkan juga kepada pihak perusahaan sebagai bahan evaluasi.
        </li>
    </ol>

    {{-- PENUTUP --}}
    <p class="content-p">
        Demikian surat balasan ini kami sampaikan. Besar harapan kami kerja sama ini dapat memberikan manfaat bagi kedua
        belah pihak. Untuk informasi lebih lanjut dapat menghubungi:
        <br>
        <strong>Telp. 022 - 21010299</strong> atau <strong>Admin: 081224398145 a.n Ibu.Cica Riyani</strong>
    </p>

    <p class="content-p">
        Atas perhatian dan kerja samanya, kami ucapkan terima kasih.
    </p>

    {{-- TANDA TANGAN & STEMPEL --}}
    <div class="sign-wrapper">
        <table class="sign-table">
            <tr>
                <td style="width: 55%;"></td>
                <td class="sign-box">
                    <div>Bandung, {{ $application->acceptance_date_formatted }}</div>
                    <div>Hormat Kami,</div>
                    <div style="font-weight: bold; margin-bottom: 8px;">PT. Higertech Karya Sinergi</div>

                    <div class="sign-space">
                        @if (!empty($brandIconBase64))
                            <img src="{{ $brandIconBase64 }}" class="sign-logo-stamp" alt="Logo Stamp">
                        @endif
                    </div>

                    <div class="sign-name">(Dwi Putra Silitonga)</div>
                    <div class="sign-role">Direktur Utama</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER KANTOR --}}
    <div class="footer-fixed">
        <table class="footer-table">
            <tr>
                <td style="width: 45%;">
                    <div><strong>Telp:</strong> 022-2101-0299</div>
                    <div><strong>Email:</strong> higertechkaryasinergi@gmail.com</div>
                </td>
                <td style="width: 55%; text-align: right;">
                    <div>Jl. Banda No. 30 RT. 002 RW. 006, Citarum, Bandung Wetan, Bandung, Jawa Barat</div>
                    <div><strong>Web:</strong> www.higertech.com</div>
                </td>
            </tr>
        </table>
        <div style="margin-top: 4px; height: 4px; background: linear-gradient(to right, #16275E 70%, #C5221F 30%);">
        </div>
    </div>

</body>

</html>
