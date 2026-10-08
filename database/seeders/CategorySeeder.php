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
        // 1. Bersihkan kategori produk lama yang tidak ada dalam daftar resmi
        $officialProductNames = [
            'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )',
            'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
            'Klimatologi ( Automatic Weather Station / AWS )',
            'Alarm Peringatan Dini ( Early Warning Sistem / EWS )',
            'Pemantau Visual Camera Capture ( CCTV Capture )',
            'Vibrating Wire',
            'Alat Ukur',
            'Sparepart',
            'Jasa',
        ];

        Category::where('tipe', 'produk')
            ->whereNotIn('name', $officialProductNames)
            ->delete();

        $categories = [
            // Kategori Produk (Sesuai Arahan Resmi Pak Handy)
            [
                'name' => 'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )',
                'sub_nama' => 'Automatic Rain Recorder',
                'tipe' => 'produk',
                'sort_order' => 1,
                'description' => 'Sistem pemantauan dan pencatatan curah hujan otomatis real-time berbasis telemetri.',
            ],
            [
                'name' => 'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
                'sub_nama' => 'Automatic Water Level Recorder',
                'tipe' => 'produk',
                'sort_order' => 2,
                'description' => 'Sistem pemantauan dan pengukuran tinggi muka air sungai, bendungan, dan saluran irigasi otomatis.',
            ],
            [
                'name' => 'Klimatologi ( Automatic Weather Station / AWS )',
                'sub_nama' => 'Automatic Weather Station',
                'tipe' => 'produk',
                'sort_order' => 3,
                'description' => 'Stasiun pengamatan cuaca dan iklim terintegrasi dengan beragam sensor meteorologi otomatis.',
            ],
            [
                'name' => 'Alarm Peringatan Dini ( Early Warning Sistem / EWS )',
                'sub_nama' => 'Early Warning System',
                'tipe' => 'produk',
                'sort_order' => 4,
                'description' => 'Sistem deteksi dini dan sirine peringatan bencana banjir, longsor, dan kenaikan air kritis.',
            ],
            [
                'name' => 'Pemantau Visual Camera Capture ( CCTV Capture )',
                'sub_nama' => 'CCTV Capture',
                'tipe' => 'produk',
                'sort_order' => 5,
                'description' => 'Kamera pemantau visual jarak jauh bertenaga surya untuk dokumentasi berkala kondisi lapangan.',
            ],
            [
                'name' => 'Vibrating Wire',
                'sub_nama' => 'Vibrating Wire Instruments',
                'tipe' => 'produk',
                'sort_order' => 6,
                'description' => 'Instrumen sensor vibrating wire untuk pemantauan stabilitas bendungan dan struktur geoteknik.',
            ],
            [
                'name' => 'Alat Ukur',
                'sub_nama' => 'Peralatan Ukur & Sensor',
                'tipe' => 'produk',
                'sort_order' => 7,
                'description' => 'Berbagai instrumen pengukuran debit, kualitas air, dan sensor pendukung telemetri.',
            ],
            [
                'name' => 'Sparepart',
                'sub_nama' => 'Komponen & Suku Cadang',
                'tipe' => 'produk',
                'sort_order' => 8,
                'description' => 'Suku cadang resmi, modul komunikasi, solar panel, baterai, dan aksesoris stasiun.',
            ],
            [
                'name' => 'Jasa',
                'sub_nama' => 'Layanan & Maintenance',
                'tipe' => 'produk',
                'sort_order' => 9,
                'description' => 'Jasa instalasi, kalibrasi sensor, perawatan berkala, serta integrasi sistem telemetri.',
            ],

            // Kategori Artikel
            [
                'name' => 'Edukasi & Panduan',
                'sub_nama' => 'Edukasi',
                'tipe' => 'artikel',
                'sort_order' => 1,
                'description' => 'Kumpulan artikel panduan, instalasi, edukasi seputar telemetri dan instrumen.',
            ],
            [
                'name' => 'Berita Perusahaan',
                'sub_nama' => 'Berita',
                'tipe' => 'artikel',
                'sort_order' => 2,
                'description' => 'Informasi terbaru, pengumuman, dan berita dari Higertech.',
            ],
            [
                'name' => 'Studi Kasus',
                'sub_nama' => 'Case Study',
                'tipe' => 'artikel',
                'sort_order' => 3,
                'description' => 'Penerapan nyata solusi telemetri dan hasil monitoring di lapangan.',
            ],
            [
                'name' => 'Teknologi IoT',
                'sub_nama' => 'Teknologi',
                'tipe' => 'artikel',
                'sort_order' => 4,
                'description' => 'Perkembangan terbaru seputar Internet of Things (IoT) di bidang instrumentasi.',
            ],
            [
                'name' => 'Event & Kegiatan',
                'sub_nama' => 'Event',
                'tipe' => 'artikel',
                'sort_order' => 5,
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
