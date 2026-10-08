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
        // Pastikan folder storage public/products ada
        if (! \Illuminate\Support\Facades\Storage::disk('public')->exists('products')) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('products');
        }

        // Data Produk Riil dari Etalase Resmi PT Higertech Karya Sinergi di e-Katalog INAPROC LKPP
        // https://katalog.inaproc.id/higertech-karya-sinergi
        $productsByCategory = [
            'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )' => [
                [
                    'title' => 'Curah Hujan Telemetry / ARR Telemetry 0,5 mm/ 0,2mm-Data Logger HGTKS',
                    'desc' => "Paket Stasiun Telemetri Curah Hujan Otomatis (ARR) Standar BMKG & Ditjen SDA PUPR (TKDN 40%). Dilengkapi Data Logger HGTKS, Tipping Bucket Rain Gauge presisi 0.5 mm / 0.2 mm, catu daya solar panel mandiri, dan modem GSM 4G LTE IoT untuk transmisi data realtime.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/curah-hujan-telemetry-arr-telemetry-0-5-mm-0-2mm-data-logger-hgtks',
                    'image' => 'products/curah-hujan-telemetry-arr-telemetry-0-5-mm-0-2mm-data-logger-hgtks.jpeg',
                ],
                [
                    'title' => 'Sensor Curah Hujan Manual Telemetri Tipping Bucket 0,5mm',
                    'desc' => "Sensor penakar curah hujan tipe tipping bucket beresolusi 0.5 mm dengan diameter corong orifice standar. Dibuat tahan karat untuk pemantauan presisi jangka panjang di pos hidrologi lapangan terbuka.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/sensor-curah-hujan-manual-telemetri-tipping-bucket-0-5mm',
                    'image' => 'products/sensor-curah-hujan-manual-telemetri-tipping-bucket-0-5mm.png',
                ],
                [
                    'title' => 'CURAH HUJAN OBSERVATORIUM (OBS)',
                    'desc' => "Penakar hujan manual tipe Observatorium (OBS) standar BMKG dengan corong kuningan dan tabung ukur presisi untuk kalibrasi pos pengamatan curah hujan.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/curah-hujan-observatorium-obs',
                    'image' => 'products/curah-hujan-observatorium-obs.jpeg',
                ],
            ],
            'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )' => [
                [
                    'title' => 'TINGGI MUKA AIR / AWLR SENSOR RADAR TELEMETRY RANGE PENGUKURAN 20, 30, 50 METER',
                    'desc' => "Stasiun pemantau tinggi muka air tanpa kontak menggunakan radar frekuensi tinggi dengan jangkauan 20, 30, hingga 50 meter dan akurasi tinggi. Tidak terpengaruh sampah hanyut, lumpur pekat, maupun banjir ekstrem.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/tinggi-muka-air-awlr-sensor-radar-telemetry-range-pengukuran-20-30-50-meter',
                    'image' => 'products/tinggi-muka-air-awlr-sensor-radar-telemetry-range-pengukuran-20-30-50-meter.jpeg',
                ],
                [
                    'title' => 'TINGGI MUKA AIR / AWLR SENSOR SONAR TELEMETRY RANGE PENGUKURAN 0 s/d 10 METER',
                    'desc' => "Stasiun telemetri tinggi muka air ultrasonik/sonar untuk saluran irigasi, pintu air bendung, dan drainase perkotaan dengan rentang ukur 0 s/d 10 meter serta instalasi non-kontak yang mudah dipelihara.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/tinggi-muka-air-awlr-sensor-sonar-telemetry-range-pengukuran-0-s-d-10-meter',
                    'image' => 'products/tinggi-muka-air-awlr-sensor-sonar-telemetry-range-pengukuran-0-s-d-10-meter.jpeg',
                ],
                [
                    'title' => 'TINGGI MUKA AIR TIPE PRESSURE TELEMETRY',
                    'desc' => "Sistem Telemetri Tinggi Muka Air (AWLR) berbasis Submersible Pressure Sensor teruji berakurasi tinggi (TKDN 40%). Dilengkapi catu daya mandiri solar cell & backup baterai, enclosure IP66 anti air/debu, serta modul komunikasi telemetri terintegrasi untuk sungai, bendungan, dan saluran irigasi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/tinggi-muka-air-tipe-pressure-telemetry',
                    'image' => 'products/tinggi-muka-air-tipe-pressure-telemetry.jpeg',
                ],
                [
                    'title' => 'PERANGKAT TELEMETRY AUTOMATIC GROUND LEVEL WATER SENSOR AWLR PRESURE HIGERTECH',
                    'desc' => "Perangkat telemetri pemantau tinggi muka air tanah otomatis (AGWLR) presisi tinggi berbasis pressure sensor untuk sumur pantau dan konservasi air tanah.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-telemetry-automatic-ground-level-water-sensor-awlr-presure-higertech',
                    'image' => 'products/perangkat-telemetry-automatic-ground-level-water-sensor-awlr-presure-higertech.jpeg',
                ],
            ],
            'Klimatologi ( Automatic Weather Station / AWS )' => [
                [
                    'title' => 'Klimatologi / Automatic Weather Station Telemetry (AWS) HIGERTECH',
                    'desc' => "Sistem stasiun cuaca dan klimatologi otomatis terpadu standar BMKG & WMO dengan parameter arah & kecepatan angin, suhu, kelembaban udara, radiasi matahari, dan tekanan barometrik.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/klimatologi-automatic-weather-station-telemetry-aws-higertech',
                    'image' => 'products/klimatologi-automatic-weather-station-telemetry-aws-higertech.jpeg',
                ],
                [
                    'title' => 'Evaporation Sensor/ Panci Penguapan Telemetri',
                    'desc' => "Sensor pengukur evaporasi air otomatis pada panci penguapan (Class A Evaporation Pan) terintegrasi ke data logger telemetri untuk pos pengamatan klimatologi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/evaporation-sensor-panci-penguapan-telemetri',
                    'image' => 'products/evaporation-sensor-panci-penguapan-telemetri.jpeg',
                ],
                [
                    'title' => 'Sangkar Meteorologi',
                    'desc' => "Sangkar cuaca meteorologi standar BMKG berbahan kayu pilihan dengan ventilasi ganda untuk melindungi instrumen pengukuran suhu dan kelembaban udara dari radiasi matahari langsung.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/sangkar-meteorologi',
                    'image' => 'products/sangkar-meteorologi.png',
                ],
                [
                    'title' => 'Kertas Penyinaran Matahari / Shunshine',
                    'desc' => "Pita kertas pias pencatat durasi penyinaran matahari untuk Campbell Stokes Sunshine Recorder di stasiun klimatologi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/kertas-penyinaran-matahari-shunshine',
                    'image' => 'products/kertas-penyinaran-matahari-shunshine.png',
                ],
            ],
            'Alarm Peringatan Dini ( Early Warning Sistem / EWS )' => [
                [
                    'title' => 'EARLY WARNING SYSTEM (EWS) BANJIR TELEMETRY',
                    'desc' => "Sistem peringatan dini bencana banjir multi-stage dengan sirine berdaya suara 120dB (jangkauan hingga 2 km), strobo visual peringatan, dan pemicu otomatis terhubung ke stasiun AWLR hulu sungai.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/early-warning-system-ews-banjir-telemetry',
                    'image' => 'products/early-warning-system-ews-banjir-telemetry.jpeg',
                ],
                [
                    'title' => 'Web Telemetry dan Flood Early Warning System (FEWS)',
                    'desc' => "Platform sistem informasi dan dashboard peringatan dini banjir berbasis web untuk pemantauan real-time dan broadcast peringatan bahaya ke stakeholder terkait.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/web-telemetry-dan-flood-early-warning-system-fews',
                    'image' => 'products/web-telemetry-dan-flood-early-warning-system-fews.jpeg',
                ],
            ],
            'Pemantau Visual Camera Capture ( CCTV Capture )' => [
                [
                    'title' => 'PERANGKAT TELEMETRI CCTV CAPTURE',
                    'desc' => "Kamera pengawas pos hidrologi bertenaga surya mandiri dengan transmisi tangkapan foto berkala via jaringan 4G LTE, housing IP67 tahan cuaca, dan sistem penerangan malam otomatis.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-telemetri-cctv-capture-X',
                    'image' => 'products/perangkat-telemetri-cctv-capture-x.png',
                ],
                [
                    'title' => 'NVR302-16E2 Uniview NVR (Network Video Recorder)',
                    'desc' => "Perangkat perekam video jaringan (NVR) 16 kanal untuk manajemen rekaman kamera dan streaming pos pemantauan bendungan dan pintu air.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/nvr302-16e2-uniview-nvr-network-video-recorder',
                    'image' => 'products/nvr302-16e2-uniview-nvr-network-video-recorder.png',
                ],
            ],
            'Vibrating Wire' => [
                [
                    'title' => 'Vibrating Wire HIGERTECH',
                    'desc' => "Sensor geoteknik pengukur tekanan air pori tanah dan batuan berbasis teknologi kawat bergetar (vibrating wire) untuk analisis stabilitas bendungan urugan dan lereng galian.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/vibrating-wire-higertech',
                    'image' => 'products/vibrating-wire-higertech.jpeg',
                ],
                [
                    'title' => 'V Notch Telemetry HIGERTECH',
                    'desc' => "Sistem pemantau debit rembesan bendungan dengan sekat ukur V-Notch terintegrasi sensor muka air presisi tinggi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/v-notch-telemetry-higertech',
                    'image' => 'products/v-notch-telemetry-higertech.jpeg',
                ],
            ],
            'Alat Ukur' => [
                [
                    'title' => 'Peilschaal Skala 1 : 100',
                    'desc' => "Papan duga muka air (peilschaal) bahan pelat aluminium berkualitas dengan lapisan cat enamel anti-gores dan anti-UV tahan air sungai asam/basa untuk kalibrasi visual tinggi air (TKDN 40%).",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/peilschaal-skala-1-100',
                    'image' => 'products/peilschaal-skala-1-100.png',
                ],
                [
                    'title' => 'PERANGKAT CURRENT METER',
                    'desc' => "Alat ukur kecepatan arus air portabel dengan propeler presisi, tongkat ukur berskala, dan counter digital untuk pengukuran debit hidrometri berkala di lapangan.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-current-meter',
                    'image' => 'products/perangkat-current-meter.jpeg',
                ],
                [
                    'title' => 'ADCP (Acoustic Doppler Current Profiler) Sontek M9 PCM DGPS With ARqPoD Hypack Environmental',
                    'desc' => "Instrumen hidrometri mutakhir berbasis akustik Doppler untuk pengukuran profil kecepatan dan debit aliran sungai dengan integrasi DGPS berakurasi tinggi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/adcp-acoustic-doppler-current-profiler-sontek-m9-pcm-dgps-with-arqpod-hypack-environmental',
                    'image' => 'products/adcp-acoustic-doppler-current-profiler-sontek-m9-pcm-dgps-with-arqpod-hypack-environmental.jpeg',
                ],
                [
                    'title' => 'PERANGKAT FLOW METER TELEMETRY SENSOR ULTRASONIC (PENGUKURAN DEBIT SALURAN TERTUTUP)',
                    'desc' => "Instrumen pengukur debit saluran pipa tertutup berbasis sensor ultrasonik dengan output telemetri real-time.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-flow-meter-telemetry-sensor-ultrasonic-pengukuran-debit-saluran-tertutup',
                    'image' => 'products/perangkat-flow-meter-telemetry-sensor-ultrasonic-pengukuran-debit-saluran-tertutup.jpeg',
                ],
                [
                    'title' => 'PERANGKAT KUALITAS AIR / WATER QUALITY TELEMETRY',
                    'desc' => "Sistem telemetri pemantauan kualitas air multi-parameter kontinu (pH, DO, TDS/EC, Kekeruhan/Turbidity, dan Suhu) untuk badan air permukaan.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-kualitas-air-water-quality-telemetry',
                    'image' => 'products/perangkat-kualitas-air-water-quality-telemetry.jpeg',
                ],
                [
                    'title' => 'Papan Duga Air (Terpasang)',
                    'desc' => "Paket pengadaan dan pemasangan papan duga muka air (peilschaal) lengkap dengan tiang penguat pondasi di badan sungai atau saluran pembuang.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/papan-duga-air-terpasang',
                    'image' => 'products/papan-duga-air-terpasang.jpeg',
                ],
            ],
            'Sparepart' => [
                [
                    'title' => 'Data Logger Telemetri HGTKS',
                    'desc' => "Modul unit data logger utama berkinerja tinggi (TKDN 40%) dengan prosesor 32-bit, multi-channel analog/digital/RS485 Modbus/SDI-12, storage micro-SD, dan modem 4G LTE terintegrasi.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/data-logger-telemetri-hgtks',
                    'image' => 'products/data-logger-telemetri-hgtks.jpeg',
                ],
                [
                    'title' => 'Solar Charge Controller 30 Amper',
                    'desc' => "Modul solar charge controller 30A efisiensi tinggi dengan teknologi pengisian baterai cerdas untuk catu daya mandiri stasiun telemetri.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/solar-charge-controller-30-amper',
                    'image' => 'products/solar-charge-controller-30-amper.jpeg',
                ],
                [
                    'title' => 'Solar Panel 50 WP',
                    'desc' => "Panel surya monokristalin 50 Watt Peak tahan cuaca tropis untuk suplai energi bersih mandiri pos pemantauan lapangan.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/solar-panel-50-wp',
                    'image' => 'products/solar-panel-50-wp.jpg',
                ],
                [
                    'title' => 'Baterai VLRA 12 Volt 100 Ah',
                    'desc' => "Baterai kering industri Valve Regulated Lead Acid (VRLA) deep cycle 12V 100Ah tahan siklus pemakaian tinggi untuk backup stasiun telemetri 24 jam nonstop.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/baterai-vlra-12-volt-100-ah',
                    'image' => 'products/baterai-vlra-12-volt-100-ah.jpeg',
                ],
                [
                    'title' => 'Box Panel Outdoor ABS IP66 400 x 600 x 220 mm',
                    'desc' => "Enclosure box luar ruangan bahan ABS standar IP66 tahan karat, debu, dan percikan air untuk perlindungan data logger dan sistem elektronik.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/box-panel-outdoor-abs-ip66-400-x-600-x-220-mm',
                    'image' => 'products/box-panel-outdoor-abs-ip66-400-x-600-x-220-mm.jpg',
                ],
                [
                    'title' => 'Suku Cadang Curah Hujan',
                    'desc' => "Paket komponen suku cadang sensor curah hujan mencakup corong, reed switch counter, saringan kotoran, dan modul tipping bucket.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/suku-cadang-curah-hujan',
                    'image' => 'products/suku-cadang-curah-hujan.jpeg',
                ],
            ],
            'Jasa' => [
                [
                    'title' => 'Pembuatan Web Telemetri Higertech',
                    'desc' => "Layanan pembuatan dan integrasi sistem web monitoring telemetri kustom untuk pemantauan data hidrologi, visualisasi grafik, dan export laporan.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/pembuatan-web-telemetri-higertech',
                    'image' => 'products/pembuatan-web-telemetri-higertech.jpeg',
                ],
                [
                    'title' => 'Website Sistem Informasi Hidrologi',
                    'desc' => "Pengembangan portal sistem informasi hidrologi dan pengelolaan basis data hidrometeorologi terpusat untuk balai pengelola sumber daya air.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/website-sistem-informasi-hidrologi',
                    'image' => 'products/website-sistem-informasi-hidrologi.jpeg',
                ],
                [
                    'title' => 'Aplikasi Android Petugas Pos Hidrologi',
                    'desc' => "Pengembangan aplikasi mobile Android bagi petugas pos lapangan untuk pencatatan observasi manual, pelaporan kondisi alat, dan sinkronisasi server.",
                    'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi/aplikasi-android-petugas-pos-hidrologi',
                    'image' => 'products/aplikasi-android-petugas-pos-hidrologi.jpeg',
                ],
            ],
        ];

        // Kosongkan produk lama agar slug dan data persis sinkron dengan etalase asli Inaproc
        Product::query()->delete();

        foreach ($productsByCategory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->where('tipe', 'produk')->first();

            if (! $category) {
                continue;
            }

            foreach ($products as $product) {
                // Gunakan slug dari url inaproc atau dari title
                $inaprocLink = $product['inaproc_link'];
                $slug = basename(parse_url($inaprocLink, PHP_URL_PATH)) ?: Str::slug($product['title']);

                Product::create([
                    'category_id' => $category->id,
                    'title' => $product['title'],
                    'slug' => $slug,
                    'desc' => $product['desc'],
                    'inaproc_link' => $inaprocLink,
                    'image' => $product['image'] ?? null,
                    'is_active' => true,
                ]);
            }
        }
    }
}