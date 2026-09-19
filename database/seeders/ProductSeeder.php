<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pastiin ada kategori bertipe produk. Kalau belum ada, bikin beberapa dulu.
        $categoryNames = ['test-produk'];

        foreach ($categoryNames as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'tipe' => 'produk'],
                ['sub_nama' => $name, 'description' => "Kategori produk {$name}"]
            );
        }

        $categoryIds = Category::produk()->pluck('id')->toArray();

        $products = [
            [
                'title' => 'Website Sistem Informasi Hidrologi',
                'desc' => 'Platform monitoring hidrologi berbasis web yang menampilkan data real-time dari seluruh pos pantau. Dilengkapi dashboard interaktif, grafik debit air, peta distribusi sensor, dan sistem notifikasi otomatis untuk kondisi kritis.',
            ],
            [
                'title' => 'Pembuatan Web Telemetri Higertech',
                'desc' => 'Web telemetri terintegrasi untuk akuisisi data lapangan secara otomatis. Menampilkan dashboard utama, kolom profil pos telemetri, nilai sensor real-time, serta informasi aset dan laporan berkala.',
            ],
            [
                'title' => 'Web Telemetry dan Flood Early Warning System (FEWS)',
                'desc' => 'Pembuatan Web Telemetry dan FEWS dengan dashboard utama, peta sebaran pos telemetri, profil pos detail, nilai sensor real-time, serta peta 2 dimensi banjir spasial dari hasil curah hujan satelit.',
            ],
            [
                'title' => 'Sistem Monitoring Kualitas Air',
                'desc' => 'Sistem pemantauan kualitas air berbasis IoT yang mengintegrasikan sensor pH, kekeruhan, suhu, dan dissolved oxygen secara real-time. Dashboard terintegrasi dengan alert otomatis dan laporan historis.',
            ],
            [
                'title' => 'Platform Monitoring Cuaca Otomatis',
                'desc' => 'Platform digital untuk pemantauan kondisi cuaca secara otomatis melalui AWS (Automatic Weather Station). Menampilkan data curah hujan, kecepatan angin, suhu udara, dan kelembaban dalam satu dashboard terpadu.',
            ],
            [
                'title' => 'Sistem Informasi Geospasial Bencana',
                'desc' => 'Sistem informasi berbasis GIS untuk pemetaan potensi bencana alam. Mengintegrasikan data sensor lapangan, citra satelit, dan analitik spasial untuk mendukung pengambilan keputusan mitigasi bencana.',
            ],
            [
                'title' => 'Dashboard Monitoring Debit Sungai',
                'desc' => 'Sistem pemantauan debit sungai real-time dengan integrasi sensor ultrasonik dan radar level. Menyediakan grafik historis, prediksi banjir sederhana, dan notifikasi ambang batas siaga.',
            ],
            [
                'title' => 'Aplikasi Pelaporan Lapangan Petugas',
                'desc' => 'Aplikasi mobile-friendly untuk petugas lapangan melaporkan kondisi pos pantau secara langsung, lengkap dengan foto, lokasi GPS, dan status kerusakan alat.',
            ],
            [
                'title' => 'Sistem Manajemen Aset Telemetri',
                'desc' => 'Platform pencatatan dan pemeliharaan aset perangkat telemetri, termasuk riwayat kalibrasi, jadwal maintenance, dan status garansi tiap unit sensor.',
            ],
            [
                'title' => 'Dashboard Analitik Curah Hujan Satelit',
                'desc' => 'Visualisasi data curah hujan berbasis citra satelit dengan resolusi tinggi, dilengkapi perbandingan historis dan ekspor laporan per wilayah.',
            ],
            [
                'title' => 'Sistem Peringatan Dini Longsor',
                'desc' => 'Sistem monitoring pergerakan tanah menggunakan sensor inklinometer dan curah hujan, dengan notifikasi otomatis ke pihak terkait saat mendeteksi potensi longsor.',
            ],
            [
                'title' => 'Portal Data Terbuka Lingkungan',
                'desc' => 'Portal publik yang menyajikan data lingkungan (kualitas udara, air, cuaca) secara terbuka untuk masyarakat dan peneliti, dengan fitur unduh dataset dan API publik.',
            ],
        ];

        foreach ($products as $index => $product) {
            $slug = Str::slug($product['title']);

            Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categoryIds[$index % count($categoryIds)],
                    'title' => $product['title'],
                    'desc' => $product['desc'],
                    'image' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}