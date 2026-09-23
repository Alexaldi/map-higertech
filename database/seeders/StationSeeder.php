<?php

namespace Database\Seeders;

use App\Models\Station;
use Database\Factories\StationFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Station::query()->delete();

        $types = [
            ...array_fill(0, 12, 'ARR'),
            ...array_fill(0, 12, 'AWLR'),
            ...array_fill(0, 7, 'AWS'),
            ...array_fill(0, 5, 'AWLR_ARR'),
            'AGWLR', 'AGWLR',
            'FM', 'FM', 'FM',
            'EWS', 'EWS',
            'AVWR', 'AVWR',
            'WQ', 'WQ',
            'VNOTCH', 'OW', 'OSP',
        ];

        $organizations = [
            ['BTN-SUMATERA', 'Balai Telemetri Nusantara Sumatera'],
            ['BTN-JAWA-BARAT', 'Balai Telemetri Nusantara Jawa Barat'],
            ['BTN-JAWA-TENGAH', 'Balai Telemetri Nusantara Jawa Tengah'],
            ['BTN-JAWA-TIMUR', 'Balai Telemetri Nusantara Jawa Timur'],
            ['BTN-BALI-NUSA', 'Balai Telemetri Nusantara Bali Nusa Tenggara'],
            ['BTN-KALIMANTAN', 'Balai Telemetri Nusantara Kalimantan'],
            ['BTN-SULAWESI', 'Balai Telemetri Nusantara Sulawesi'],
            ['BTN-MALUKU-PAPUA', 'Balai Telemetri Nusantara Maluku Papua'],
        ];

        $locations = [
            ['Aceh', 'Banda Aceh', -5.5483, 95.3238],
            ['Sumatera Utara', 'Medan', 3.5952, 98.6722],
            ['Sumatera Barat', 'Padang', -0.9471, 100.4172],
            ['Riau', 'Pekanbaru', 0.5071, 101.4478],
            ['Kepulauan Riau', 'Tanjung Pinang', 0.9186, 104.4665],
            ['Jambi', 'Jambi', -1.6101, 103.6131],
            ['Bengkulu', 'Bengkulu', -3.7928, 102.2608],
            ['Sumatera Selatan', 'Palembang', -2.9909, 104.7566],
            ['Kepulauan Bangka Belitung', 'Pangkalpinang', -2.1316, 106.1169],
            ['Lampung', 'Bandar Lampung', -5.4292, 105.2625],
            ['Banten', 'Serang', -6.1201, 106.1503],
            ['DKI Jakarta', 'Jakarta Selatan', -6.2615, 106.8106],
            ['Jawa Barat', 'Bogor', -6.5971, 106.8060],
            ['Jawa Barat', 'Bandung', -6.9175, 107.6191],
            ['Jawa Barat', 'Cirebon', -6.7320, 108.5523],
            ['Jawa Tengah', 'Semarang', -6.9667, 110.4167],
            ['Jawa Tengah', 'Surakarta', -7.5755, 110.8243],
            ['DI Yogyakarta', 'Sleman', -7.7162, 110.3556],
            ['Jawa Timur', 'Surabaya', -7.2575, 112.7521],
            ['Jawa Timur', 'Malang', -7.9666, 112.6326],
            ['Jawa Timur', 'Banyuwangi', -8.2192, 114.3691],
            ['Bali', 'Denpasar', -8.6705, 115.2126],
            ['Nusa Tenggara Barat', 'Mataram', -8.5833, 116.1167],
            ['Nusa Tenggara Timur', 'Kupang', -10.1772, 123.6070],
            ['Kalimantan Barat', 'Pontianak', -0.0263, 109.3425],
            ['Kalimantan Tengah', 'Palangka Raya', -2.2161, 113.9137],
            ['Kalimantan Selatan', 'Banjarbaru', -3.4425, 114.8327],
            ['Kalimantan Timur', 'Samarinda', -0.5022, 117.1536],
            ['Kalimantan Utara', 'Tanjung Selor', 2.8404, 117.3744],
            ['Sulawesi Utara', 'Manado', 1.4748, 124.8421],
            ['Gorontalo', 'Gorontalo', 0.5435, 123.0568],
            ['Sulawesi Tengah', 'Palu', -0.9003, 119.8779],
            ['Sulawesi Barat', 'Mamuju', -2.6778, 118.8867],
            ['Sulawesi Selatan', 'Makassar', -5.1477, 119.4327],
            ['Sulawesi Tenggara', 'Kendari', -3.9985, 122.5120],
            ['Maluku Utara', 'Ternate', 0.7893, 127.3772],
            ['Maluku', 'Ambon', -3.6954, 128.1814],
            ['Papua Barat', 'Manokwari', -0.8615, 134.0620],
            ['Papua Barat Daya', 'Sorong', -0.8762, 131.2558],
            ['Papua', 'Jayapura', -2.5337, 140.7181],
            ['Papua Tengah', 'Nabire', -3.3636, 135.5018],
            ['Papua Pegunungan', 'Jayawijaya', -4.0833, 138.9500],
            ['Papua Selatan', 'Merauke', -8.4991, 140.4049],
            ['Jawa Barat', 'Sukabumi', -6.9277, 106.9300],
            ['Jawa Tengah', 'Cilacap', -7.7278, 109.0154],
            ['Jawa Timur', 'Jember', -8.1737, 113.7000],
            ['Sumatera Barat', 'Bukittinggi', -0.3050, 100.3692],
            ['Sumatera Selatan', 'Lahat', -3.8000, 103.5333],
            ['Kalimantan Selatan', 'Banjarmasin', -3.3186, 114.5944],
            ['Sulawesi Selatan', 'Parepare', -4.0096, 119.6291],
        ];

        $prefixes = [
            'ARR' => 'PCH',
            'AWLR' => 'PDA',
            'AWS' => 'Klimatologi',
            'AWLR_ARR' => 'PDA-PCH',
            'AGWLR' => 'Air Tanah',
            'FM' => 'Flow Meter',
            'EWS' => 'EWS',
            'AVWR' => 'Pintu Air',
            'WQ' => 'Kualitas Air',
            'VNOTCH' => 'V-Notch',
            'OW' => 'Observasi',
            'OSP' => 'Pompa',
        ];

        foreach ($locations as $offset => [$province, $regency, $latitude, $longitude]) {
            for ($variant = 0; $variant < 4; $variant++) {
                $number = ($offset * 4) + $variant + 1;
                $type = $types[($offset + ($variant * 11)) % count($types)];
                [$organizationCode, $balaiName] = $organizations[($offset + $variant) % count($organizations)];
                $name = sprintf('%s %s %03d', $prefixes[$type], $regency, $number);
                $latitudeJitter = (($variant - 1.5) * 0.032) + ((($offset % 3) - 1) * 0.006);
                $longitudeJitter = (((($variant + 1) % 4) - 1.5) * 0.038) + ((($offset % 5) - 2) * 0.005);

                Station::factory()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'station_type' => $type,
                    'latitude' => round($latitude + $latitudeJitter, 7),
                    'longitude' => round($longitude + $longitudeJitter, 7),
                    'balai_name' => $balaiName,
                    'organization_code' => $organizationCode,
                    'province_name' => $province,
                    'regency_name' => $regency,
                    'district_name' => $number % 5 === 0 ? null : 'Kecamatan Telemetri '.(($number % 9) + 1),
                    'village_name' => $number % 4 === 0 ? null : 'Desa Pantau '.(($number % 11) + 1),
                    'river_area_name' => 'WS Nusantara '.(($number % 7) + 1),
                    'watershed_name' => $number % 6 === 0 ? null : 'DAS Cakrawala '.(($number % 10) + 1),
                    'device_id' => sprintf('%s-DUMMY-%03d', $type, $number),
                    'device_status' => 'online',
                    'timezone' => $offset <= 20 ? 'Asia/Jakarta' : ($offset <= 34 ? 'Asia/Makassar' : 'Asia/Jayapura'),
                    'reading_at' => now()->subMinutes($number * 3),
                    'latest_reading' => $number % 50 === 0 ? null : StationFactory::telemetryFor($type, $number),
                ]);
            }
        }
    }
}
