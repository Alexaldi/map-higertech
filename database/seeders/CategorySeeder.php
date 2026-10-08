<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Kategori Produk (10 Kategori Resmi Sesuai Arahan Pak Handy)
            [
                'name' => 'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )',
                'sub_nama' => 'Automatic Rain Recorder',
                'tipe' => 'produk',
                'description' => 'Sistem pemantauan dan pencatatan curah hujan otomatis real-time berbasis telemetri.',
            ],
            [
                'name' => 'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
                'sub_nama' => 'Automatic Water Level Recorder',
                'tipe' => 'produk',
                'description' => 'Sistem pemantauan dan pengukuran tinggi muka air sungai, bendungan, dan saluran irigasi otomatis.',
            ],
            [
                'name' => 'Klimatologi ( Automatic Weather Station / AWS )',
                'sub_nama' => 'Automatic Weather Station',
                'tipe' => 'produk',
                'description' => 'Stasiun pengamatan cuaca dan iklim terintegrasi dengan beragam sensor meteorologi otomatis.',
            ],
            [
                'name' => 'Alarm Peringatan Dini ( Early Warning Sistem / EWS )',
                'sub_nama' => 'Early Warning System',
                'tipe' => 'produk',
                'description' => 'Sistem deteksi dini dan sirine peringatan bencana banjir, longsor, dan kenaikan air kritis.',
            ],
            [
                'name' => 'Pemantau Visual Camera Capture ( CCTV Capture )',
                'sub_nama' => 'CCTV Capture',
                'tipe' => 'produk',
                'description' => 'Kamera pemantau visual jarak jauh bertenaga surya untuk dokumentasi berkala kondisi lapangan.',
            ],
            [
                'name' => 'Vibrating Wire',
                'sub_nama' => 'Vibrating Wire Instruments',
                'tipe' => 'produk',
                'description' => 'Instrumen sensor vibrating wire untuk pemantauan stabilitas bendungan dan struktur geoteknik.',
            ],
            [
                'name' => 'Alat Ukur',
                'sub_nama' => 'Peralatan Ukur & Sensor',
                'tipe' => 'produk',
                'description' => 'Berbagai instrumen pengukuran debit, kualitas air, dan sensor pendukung telemetri.',
            ],
            [
                'name' => 'Sparepart',
                'sub_nama' => 'Komponen & Suku Cadang',
                'tipe' => 'produk',
                'description' => 'Suku cadang resmi, modul komunikasi, solar panel, baterai, dan aksesoris stasiun.',
            ],
            [
                'name' => 'Jasa',
                'sub_nama' => 'Layanan & Maintenance',
                'tipe' => 'produk',
                'description' => 'Jasa instalasi, kalibrasi sensor, perawatan berkala, serta integrasi sistem telemetri.',
            ],

            // Kategori Artikel
            [
                'name' => 'Edukasi & Panduan',
                'sub_nama' => 'Edukasi',
                'tipe' => 'artikel',
                'description' => 'Kumpulan artikel panduan, instalasi, edukasi seputar telemetri dan instrumen.',
            ],
            [
                'name' => 'Berita Perusahaan',
                'sub_nama' => 'Berita',
                'tipe' => 'artikel',
                'description' => 'Informasi terbaru, pengumuman, dan berita dari Higertech.',
            ],
            [
                'name' => 'Studi Kasus',
                'sub_nama' => 'Case Study',
                'tipe' => 'artikel',
                'description' => 'Penerapan nyata solusi telemetri dan hasil monitoring di lapangan.',
            ],
            [
                'name' => 'Teknologi IoT',
                'sub_nama' => 'Teknologi',
                'tipe' => 'artikel',
                'description' => 'Perkembangan terbaru seputar Internet of Things (IoT) di bidang instrumentasi.',
            ],
            [
                'name' => 'Event & Kegiatan',
                'sub_nama' => 'Event',
                'tipe' => 'artikel',
                'description' => 'Dokumentasi kegiatan, pameran, atau pelatihan yang diikuti atau diadakan oleh tim Higertech.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name'], 'tipe' => $category['tipe']],
                $category
            );
        }
    }
}
