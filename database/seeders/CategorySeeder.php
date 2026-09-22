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
            // Kategori Produk
            [
                'name' => 'Hidrologi',
                'sub_nama' => 'Peralatan Hidrologi',
                'tipe' => 'produk',
                'description' => 'Berbagai macam instrumen dan sistem monitoring hidrologi (AWLR, curah hujan, dll).',
            ],
            [
                'name' => 'Klimatologi',
                'sub_nama' => 'Peralatan Klimatologi',
                'tipe' => 'produk',
                'description' => 'Sistem pemantauan cuaca, AWS, dan instrumen iklim lainnya.',
            ],
            [
                'name' => 'Kualitas Air',
                'sub_nama' => 'Water Quality',
                'tipe' => 'produk',
                'description' => 'Sensor dan instrumen pengukuran parameter kualitas air (pH, DO, TSS, dll).',
            ],
            [
                'name' => 'Geoteknik',
                'sub_nama' => 'Peralatan Geoteknik',
                'tipe' => 'produk',
                'description' => 'Sistem monitoring pergerakan tanah, inclinometer, dan instrumen geoteknik lainnya.',
            ],
            [
                'name' => 'Software & Platform',
                'sub_nama' => 'Perangkat Lunak',
                'tipe' => 'produk',
                'description' => 'Dashboard monitoring, platform IoT, dan layanan perangkat lunak pendukung telemetri.',
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
