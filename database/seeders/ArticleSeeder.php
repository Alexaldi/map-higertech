<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Implementasi' => Category::firstOrCreate(
                ['name' => 'Implementasi'],
                ['sub_nama' => 'Implementasi Lapangan', 'description' => 'Proyek dan implementasi perangkat telemetri di lapangan.']
            ),
            'Tutorial Teknis' => Category::firstOrCreate(
                ['name' => 'Tutorial Teknis'],
                ['sub_nama' => 'Panduan Teknis', 'description' => 'Panduan instalasi dan pengoperasian instrumen teknik.']
            ),
            'Video Panduan' => Category::firstOrCreate(
                ['name' => 'Video Panduan'],
                ['sub_nama' => 'Panduan Multimedia', 'description' => 'Video panduan konfigurasi dan pemeliharaan alat.']
            ),
        ];

        $articles = [
            [
                'title' => 'Perangkat Telemetry Klimatologi Malahayu',
                'slug' => 'perangkat-telemetry-klimatologi-malahayu',
                'category_id' => $categories['Implementasi']->id,
                'category' => 'Implementasi',
                'excerpt' => 'Sistem pemantauan cuaca otomatis untuk mengukur parameter iklim secara presisi di Banjarharjo, Brebes.',
                'content' => '<p class="lead">Sistem pemantauan cuaca otomatis (Automatic Weather Station) yang dipasang di Malahayu, Kecamatan Banjarharjo, Kabupaten Brebes dirancang untuk menyajikan data meteorologi dan klimatologi secara kontinu dan presisi tinggi.</p><h2>Latar Belakang Proyek</h2><p>Daerah tangkapan air dan waduk Malahayu memerlukan pemantauan kondisi cuaca yang presisi guna mendukung pengelolaan sumber daya air serta antisipasi terhadap anomali iklim lokal. Stasiun telemetri ini mencakup sensor temperatur, kelembaban udara, tekanan udara, kecepatan serta arah angin, curah hujan, hingga radiasi matahari.</p><h2>Spesifikasi & Keandalan</h2><p>Didukung dengan teknologi transmisi data nirkabel GSM/GPRS dan satelit cadangan, data parameter lingkungan dikirim secara real-time ke pusat komputasi Higertech untuk divisualisasikan pada dasbor pemantauan.</p>',
                'image' => 'images/articles/malahayu.png',
                'author' => 'Tim Higertech',
                'read_time' => 5,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::create(2026, 6, 8, 10, 0, 0),
            ],
            [
                'title' => 'Installation Guide Automatic Weather Station (AWS)',
                'slug' => 'installation-guide-automatic-weather-station-aws',
                'category_id' => $categories['Tutorial Teknis']->id,
                'category' => 'Tutorial Teknis',
                'excerpt' => 'Panduan penempatan sensor arah angin, pyranometer surya, mast tower, penangkal petir, dan grounding.',
                'content' => '<p class="lead">Panduan komprehensif bagi teknisi lapangan dalam proses pemasangan dan kalibrasi sistem Automatic Weather Station (AWS) agar memenuhi standar WMO (World Meteorological Organization).</p><h2>1. Pemilihan Lokasi</h2><p>Pastikan stasiun ditempatkan pada area terbuka tanpa halangan pohon maupun bangunan tinggi dalam radius minimal 10 kali tinggi halangan tersebut untuk memastikan akurasi data angin dan radiasi.</p><h2>2. Sistem Mast & Penangkal Petir</h2><p>Tower mast harus terpasang kokoh dengan grounding resistance kurang dari 5 Ohm. Sistem penangkal petir terisolasi melindungi logger sensitif dan sensor analog/digital.</p><h2>3. Pemasangan Sensor</h2><ul><li>Anemometer & Wind Vane: Arahkan ke utara sebenarnya (True North).</li><li>Pyranometer: Pastikan waterpass berada tepat di tengah tanpa bayangan.</li><li>Rain Gauge: Pasang pada ketinggian standar dan bebas getaran.</li></ul>',
                'image' => 'images/articles/aws-guide.png',
                'author' => 'Tim Higertech',
                'read_time' => 8,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::create(2026, 5, 20, 9, 30, 0),
            ],
            [
                'title' => 'Pemasangan Pos Curah Hujan (PCH) Bendungkaret Tawangsari',
                'slug' => 'pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari',
                'category_id' => $categories['Implementasi']->id,
                'category' => 'Implementasi',
                'excerpt' => 'Dokumentasi pemasangan pos curah hujan untuk mendukung data hidrometeorologi lapangan yang andal.',
                'content' => '<p class="lead">Pos Curah Hujan (PCH) merupakan bagian penting dari jaringan pemantauan hidrometeorologi. Data yang dikirimkan secara berkala membantu pemantauan kondisi hujan dan mendukung pengambilan keputusan berbasis data.</p><h2>Mendukung pemantauan curah hujan</h2><p>Pemasangan PCH Bendungkaret Tawangsari dirancang untuk menyediakan titik pengamatan curah hujan yang andal di lapangan. Perangkat mengukur intensitas hujan dan meneruskan data melalui sistem telemetri agar informasi dapat dipantau dari jarak jauh.</p><blockquote style="border-left: 4px solid #0284c7; padding-left: 1rem; color: #0369a1; font-style: italic; margin: 1.5rem 0;">Tujuan utama instalasi adalah memastikan data tersedia secara konsisten, mudah diakses, dan siap digunakan sebagai dasar pemantauan kondisi wilayah.</blockquote><h2>Tahapan pemasangan</h2><p>Tim teknis melakukan peninjauan lokasi untuk memastikan posisi perangkat aman, terbuka, dan representatif terhadap kondisi hujan di sekitarnya. Setelah titik pemasangan ditetapkan, struktur penyangga, sensor, sumber daya, serta perangkat komunikasi dipasang dan diuji.</p><ol><li>Verifikasi titik lokasi dan kesiapan area pemasangan.</li><li>Instalasi sensor curah hujan, enclosure, serta sistem catu daya.</li><li>Konfigurasi logger dan konektivitas telemetri.</li><li>Pengujian pembacaan sensor dan pengiriman data.</li></ol><h2>Data yang terhubung</h2><p>Setelah proses commissioning selesai, perangkat dapat menjadi bagian dari jaringan pemantauan yang lebih luas. Data curah hujan dapat ditinjau secara berkala melalui platform monitoring untuk membantu evaluasi kondisi lapangan.</p><h2>Komitmen pada data yang andal</h2><p>Melalui implementasi ini, Higertech terus mendukung kebutuhan instrumentasi dan telemetri untuk pemantauan sumber daya air serta lingkungan. Infrastruktur pengukuran yang baik menjadi fondasi untuk data yang lebih siap, respons yang lebih tepat, dan pengelolaan yang berkelanjutan.</p>',
                'image' => 'images/articles/deli-serdang.png',
                'author' => 'Tim Higertech',
                'read_time' => 4,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::create(2026, 6, 8, 14, 0, 0),
            ],
            [
                'title' => 'Tutorial Setting dan Reset Logger AWLR Sonar Digital',
                'slug' => 'tutorial-setting-dan-reset-logger-awlr-sonar-digital',
                'category_id' => $categories['Video Panduan']->id,
                'category' => 'Video Panduan',
                'excerpt' => 'Langkah praktis untuk konfigurasi awal dan pemulihan logger AWLR sonar digital.',
                'content' => '<p class="lead">Langkah praktis bagi operator teknis dalam mengonfigurasi baud rate, sensor offset, serta prosedur reset darurat pada unit Automatic Water Level Recorder (AWLR) berbasis sensor sonar digital.</p><h2>Konfigurasi Awal</h2><p>Hubungkan logger dengan kabel serial RS-232/USB ke komputer lapangan, buka terminal konfigurasi, dan pastikan baudrate diatur pada 9600 bps 8-N-1.</p><h2>Pengaturan Zero Reference (Datum)</h2><p>Ukur jarak fisik sensor ke dasar saluran atau titik nol peilschaal manual. Masukkan parameter offset pada menu kalkulasi elevasi air.</p><h2>Prosedur Reset Pabrik</h2><p>Apabila logger mengalami anomali transmisi atau loop freeze, tekan tombol Reset selama 5 detik hingga indikator LED status berkedip cepat sebanyak 3 kali.</p>',
                'image' => 'images/articles/awlr-tutorial.png',
                'author' => 'Tim Higertech',
                'read_time' => 6,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => Carbon::create(2025, 3, 11, 11, 0, 0),
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

