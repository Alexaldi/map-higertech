<?php

namespace Database\Seeders;

use App\Models\ClientPartner;
use Illuminate\Database\Seeder;

class ClientPartnerSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'BALAI WILAYAH SUNGAI BANGKA BELITUNG',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien1.png',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'DINAS SUMBER DAYA AIR',
                'sub' => 'Pemerintah Provinsi Jawa Barat',
                'abbr' => 'SDA',
                'color' => 'bg-blue-600 text-white',
                'logo' => 'images/clients/klien2.png',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI PAPUA BARAT',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien3.png',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'JAGA BALAI SIAGA BENCANA',
                'sub' => 'Sistem Pemantauan Kebencanaan SDA',
                'abbr' => 'JB',
                'color' => 'bg-cyan-500 text-slate-950',
                'logo' => 'images/clients/klien4.png',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'UNIT HIDROLOGI KALIMANTAN TENGAH',
                'sub' => 'Dinas PUPR Provinsi Kalimantan Tengah',
                'abbr' => 'PUPR',
                'color' => 'bg-emerald-500 text-white',
                'logo' => 'images/clients/klien5.png',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI MALUKU UTARA',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien6.png',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI PAPUA',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien7.png',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI POMPENGAN',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien8.png',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'DINAS PUTR KABUPATEN BANDUNG',
                'sub' => 'Pemerintah Kabupaten Bandung',
                'abbr' => 'PEMKAB',
                'color' => 'bg-emerald-500 text-white',
                'logo' => 'images/clients/klien9.png',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI SUMATERA IV',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien10.png',
                'order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI KALIMANTAN I',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien11.png',
                'order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI SUMATERA VII',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien12.png',
                'order' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI WILAYAH SUNGAI KALIMANTAN IV',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien13.png',
                'order' => 13,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI CITARUM',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien14.png',
                'order' => 14,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI BENGAWAN SOLO',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien15.png',
                'order' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI CIMANUK CISANGGARUNG',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien16.png',
                'order' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI MESUJI SEKAMPUNG',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien17.png',
                'order' => 17,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI BRANTAS',
                'sub' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien18.png',
                'order' => 18,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI BESAR WILAYAH SUNGAI SERAYU OPAK',
                'sub' => 'Direktorat Jenderal Sumber Daya Air',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien19.png',
                'order' => 19,
                'is_active' => true,
            ],
            [
                'name' => 'BALAI TEKNIK SUNGAI',
                'sub' => 'Direktorat Bina Teknik Sumber Daya Air PUPR',
                'abbr' => 'PU',
                'color' => 'bg-amber-400 text-slate-950',
                'logo' => 'images/clients/klien20.png',
                'order' => 20,
                'is_active' => true,
            ],
        ];

        // Clean slate for client partners to ensure latest logos and orders
        ClientPartner::truncate();

        foreach ($clients as $client) {
            ClientPartner::create($client);
        }
    }
}
