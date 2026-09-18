<?php

namespace Database\Seeders;

use App\Models\Tutorial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    public function run(): void
    {
        $tutorials = [
            [
                'title' => 'Installation Guide Automatic Weather Station (AWS)',
                'slug' => 'installation-guide-automatic-weather-station-aws',
                'type' => 'Panduan Instalasi',
                'excerpt' => 'Panduan penempatan sensor, mast tower, penangkal petir, dan grounding untuk instalasi AWS yang aman.',
                'content' => '<p class="lead">Panduan komprehensif bagi teknisi lapangan dalam proses pemasangan dan kalibrasi sistem Automatic Weather Station (AWS) agar memenuhi standar WMO (World Meteorological Organization).</p><h2>1. Pemilihan Lokasi</h2><p>Pastikan stasiun ditempatkan pada area terbuka tanpa halangan pohon maupun bangunan tinggi dalam radius minimal 10 kali tinggi halangan tersebut untuk memastikan akurasi data angin dan radiasi.</p><h2>2. Sistem Mast & Penangkal Petir</h2><p>Tower mast harus terpasang kokoh dengan grounding resistance kurang dari 5 Ohm. Sistem penangkal petir terisolasi melindungi logger sensitif dan sensor analog/digital.</p><h2>3. Pemasangan Sensor</h2><ul><li>Anemometer & Wind Vane: Arahkan ke utara sebenarnya (True North).</li><li>Pyranometer: Pastikan waterpass berada tepat di tengah tanpa bayangan.</li><li>Rain Gauge: Pasang pada ketinggian standar dan bebas getaran.</li></ul><h2>4. Konfigurasi Logger</h2><p>Setelah semua sensor terpasang, konfigurasikan parameter sampling rate, interval pengiriman, dan alamat server tujuan pada logger datalogger AWS sesuai kebutuhan operasional.</p>',
                'image' => 'images/articles/aws-guide.png',
                'video_url' => null,
                'duration' => 8,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::create(2026, 5, 20, 9, 30, 0),
            ],
            [
                'title' => 'Setting dan Reset Logger AWLR Sonar Digital',
                'slug' => 'setting-dan-reset-logger-awlr-sonar-digital',
                'type' => 'Video Tutorial',
                'excerpt' => 'Langkah konfigurasi awal, pemeriksaan koneksi, serta reset logger untuk perangkat AWLR sonar digital.',
                'content' => '<p class="lead">Langkah praktis bagi operator teknis dalam mengonfigurasi baud rate, sensor offset, serta prosedur reset darurat pada unit Automatic Water Level Recorder (AWLR) berbasis sensor sonar digital.</p><h2>Konfigurasi Awal</h2><p>Hubungkan logger dengan kabel serial RS-232/USB ke komputer lapangan, buka terminal konfigurasi, dan pastikan baudrate diatur pada 9600 bps 8-N-1.</p><h2>Pengaturan Zero Reference (Datum)</h2><p>Ukur jarak fisik sensor ke dasar saluran atau titik nol peilschaal manual. Masukkan parameter offset pada menu kalkulasi elevasi air.</p><h2>Prosedur Reset Pabrik</h2><p>Apabila logger mengalami anomali transmisi atau loop freeze, tekan tombol Reset selama 5 detik hingga indikator LED status berkedip cepat sebanyak 3 kali. Setelah reset, konfigurasikan ulang seluruh parameter sesuai kebutuhan lapangan.</p>',
                'image' => 'images/articles/awlr-tutorial.png',
                'video_url' => null,
                'duration' => 6,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::create(2025, 3, 11, 11, 0, 0),
            ],
            [
                'title' => 'Persiapan Perangkat Telemetri di Lapangan',
                'slug' => 'persiapan-perangkat-telemetri-di-lapangan',
                'type' => 'Panduan Lapangan',
                'excerpt' => 'Checklist praktis sebelum perangkat dikirim, dipasang, dan dihubungkan ke sistem monitoring.',
                'content' => '<p class="lead">Sebelum perangkat telemetri dikirimkan ke lokasi pemasangan, diperlukan serangkaian persiapan teknis untuk memastikan instalasi berjalan lancar dan perangkat siap beroperasi optimal sejak hari pertama.</p><h2>Checklist Persiapan Perangkat</h2><ul><li>Verifikasi kelengkapan komponen: sensor, logger, enclosure, solar panel, baterai, dan antena.</li><li>Pengujian fungsional masing-masing sensor di workshop sebelum pengiriman.</li><li>Pemrograman awal logger: baudrate, sampling interval, APN GSM, dan alamat server.</li><li>Labeling perangkat sesuai nomor unit dan lokasi tujuan pemasangan.</li></ul><h2>Persiapan Lokasi</h2><p>Koordinasikan dengan pihak pengelola lokasi untuk memastikan izin akses, ketersediaan sumber daya listrik PLN atau solar, dan keamanan instalasi jangka panjang.</p><h2>Dokumen & Koordinasi</h2><p>Pastikan lembar kerja instalasi, prosedur kalibrasi, dan kontak teknis tersedia bagi tim lapangan selama proses pemasangan berlangsung.</p>',
                'image' => 'images/articles/deli-serdang.png',
                'video_url' => null,
                'duration' => 5,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::create(2026, 4, 15, 10, 0, 0),
            ],
        ];

        foreach ($tutorials as $data) {
            Tutorial::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

