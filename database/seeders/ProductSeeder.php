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
        $productsByCategory = [
            'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )' => [
                [
                    'title' => 'Stasiun Curah Hujan Telemetri Otomatis ARR-HGT01',
                    'desc' => 'Perangkat pemantau dan pencatat curah hujan otomatis real-time berbasis GSM/GPRS & IoT. Dilengkapi sensor tipping bucket presisi tinggi, solar power system mandiri, dan integrasi cloud.',
                ],
                [
                    'title' => 'Tipping Bucket Rain Gauge Sensor Stainless Steel',
                    'desc' => 'Sensor penakar curah hujan tipe tipping bucket beresolusi 0.5 mm dengan bodi stainless steel tahan korosi untuk penggunaan jangka panjang di pos telemetri terbuka.',
                ],
            ],
            'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )' => [
                [
                    'title' => 'Perangkat Telemetri AWLR Pressure Sensor (HGT-AWLR01)',
                    'desc' => 'Sistem telemetri tinggi muka air dengan submersible pressure sensor berakurasi tinggi (TKDN 40%). Cocok untuk pemantauan sungai, waduk, bendungan, dan saluran irigasi.',
                ],
                [
                    'title' => 'Non-Contact Radar Water Level Telemetry Station',
                    'desc' => 'Stasiun pemantau muka air tanpa kontak menggunakan radar frekuensi tinggi 80GHz. Tahan terhadap gelombang, sampah permukaan air, dan kondisi banjir ekstrem.',
                ],
                [
                    'title' => 'Ultrasonic Water Level Sensor Telemetry Station',
                    'desc' => 'Sistem telemetri muka air berbasis gelombang ultrasonik untuk pengukuran kontinuitas aliran saluran irigasi dan pintu air bendung.',
                ],
            ],
            'Klimatologi ( Automatic Weather Station / AWS )' => [
                [
                    'title' => 'Stasiun Cuaca Otomatis AWS Standar BMKG & WMO',
                    'desc' => 'Sistem pemantauan cuaca dan iklim terpadu meliputi sensor arah & kecepatan angin, suhu udara, kelembaban, radiasi matahari, tekanan udara, dan curah hujan.',
                ],
                [
                    'title' => 'Compact All-in-One Ultrasonic Weather Sensor',
                    'desc' => 'Sensor cuaca kompak terintegrasi tanpa bagian bergerak (solid-state) untuk pengamatan meteorologi mikro dan stasiun agroklimatologi.',
                ],
            ],
            'Alarm Peringatan Dini ( Early Warning Sistem / EWS )' => [
                [
                    'title' => 'Sistem Sirine Peringatan Dini Banjir & Longsor (EWS)',
                    'desc' => 'Sistem alarm peringatan dini multi-stage dengan sirine berdaya jangkau hingga 2 km, lampu strobo visual, dan aktivasi otomatis berbasis ambang batas siaga sensor.',
                ],
                [
                    'title' => 'Komunitas Alert Box & GSM Broadcast Early Warning',
                    'desc' => 'Modul penerima peringatan bencana di posko warga yang terhubung secara nirkabel dengan stasiun telemetri utama.',
                ],
            ],
            'Pemantau Visual Camera Capture ( CCTV Capture )' => [
                [
                    'title' => 'Solar Powered CCTV Capture Outdoor Telemetry',
                    'desc' => 'Kamera pengawas lapangan resolusi tinggi dengan transmisi gambar berkala via 4G LTE, dilengkapi panel surya mandiri dan housing IP67 untuk pemantauan fisik stasiun.',
                ],
                [
                    'title' => 'PTZ Pan-Tilt-Zoom Telemetry Surveillance Camera',
                    'desc' => 'Kamera PTZ berputar 360 derajat dengan optical zoom untuk inspeksi visual detail kondisi bendungan, mercu luapan, dan pintu air secara remote.',
                ],
            ],
            'Vibrating Wire' => [
                [
                    'title' => 'Vibrating Wire Piezometer Geotechnical Sensor',
                    'desc' => 'Sensor pengukur tekanan air pori tanah dan batuan berbasis frekuensi kawat bergetar untuk keamanan struktural bendungan dan lereng tambang.',
                ],
                [
                    'title' => 'Vibrating Wire Crackmeter & Jointmeter',
                    'desc' => 'Instrumen pemantau pergerakan rekahan dan celah sambungan beton bendungan dengan kestabilan sinyal jangka panjang tanpa terpengaruh hambatan kabel.',
                ],
            ],
            'Alat Ukur' => [
                [
                    'title' => 'Peilschaal Alumunium Enamel Skala 1:100',
                    'desc' => 'Papan duga muka air (peilschaal) bahan aluminium berkualitas dilapisi cat enamel anti gores dan tahan cuaca ekstrem untuk kalibrasi visual lapangan.',
                ],
                [
                    'title' => 'Digital Current Meter Pengukur Debit Aliran Sungai',
                    'desc' => 'Alat ukur kecepatan aliran air portabel dengan propeler presisi dan display digital untuk survei debit hidrometri berkala.',
                ],
            ],
            'Sparepart' => [
                [
                    'title' => 'Data Logger Telemetri Higertech HGT_L01',
                    'desc' => 'Modul unit logger utama berkinerja tinggi dengan multi-channel analog/digital/RS485, low power consumption, penyimpanan micro-SD, dan modem 4G terintegrasi.',
                ],
                [
                    'title' => 'Modul Solar Charge Controller & Industrial Battery Pack 12V',
                    'desc' => 'Paket sistem suplai daya tenaga surya industri termasuk solar panel monocrystalline, MPPT controller, dan baterai deep cycle/LiFePO4.',
                ],
            ],
            'Jasa' => [
                [
                    'title' => 'Jasa Kalibrasi & Sertifikasi Sensor Telemetri',
                    'desc' => 'Layanan kalibrasi berkala untuk sensor curah hujan, water level, dan cuaca guna menjamin akurasi data sesuai standar operasional BBWS/BWS/BMKG.',
                ],
                [
                    'title' => 'Jasa Instalasi, Commissioning & Maintenance Stasiun Telemetri',
                    'desc' => 'Pekerjaan sipil tiang menara, penangkal petir, grounding, instalasi instrumen, komisioning sistem komunikasi, serta pemeliharaan preventif.',
                ],
            ],
        ];

        foreach ($productsByCategory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->where('tipe', 'produk')->first();

            if (! $category) {
                continue;
            }

            foreach ($products as $product) {
                $slug = Str::slug($product['title']);

                Product::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $category->id,
                        'title' => $product['title'],
                        'desc' => $product['desc'],
                        'image' => null,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}