# Higertech Live Monitoring Map

Prototype WebGIS monitoring telemetry seluruh Indonesia. Project ini merecreate fungsi live map sebagai MVP menggunakan data dummy lokal—bukan data atau asset milik Higertech.

## Stack

- Laravel 13, Blade, dan SQLite
- Vite dan Tailwind CSS 4
- Leaflet, OpenStreetMap, dan Leaflet MarkerCluster
- Vanilla JavaScript modules

## Fitur MVP

- Peta Leaflet interaktif dengan 200 station fiktif deterministik di berbagai wilayah Indonesia
- Seluruh tipe `ARR`, `AWLR`, `AWS`, `AWLR_ARR`, `AGWLR`, `FM`, `EWS`, `AVWR`, `WQ`, `VNOTCH`, `OW`, dan `OSP`
- Pictogram SVG orisinal untuk seluruh tipe station, cluster marker, dan popup telemetry
- Galeri enam basemap: OSM, Humanitarian, Topografi, Light, Dark, dan Sentinel-2 Satellite non-Google
- Navbar desktop/mobile yang mengikuti struktur halaman utama serta reset, fit bounds, zoom, dan fullscreen browser
- Search serta filter tipe, status, dan instansi
- Sidebar desktop yang dapat diciutkan dan drawer mobile
- Summary station, loading state, empty state, error state, dan retry
- API JSON dengan penanganan koordinat, lokasi, timestamp, dan telemetry nullable

Tidak ada login, admin panel, CMS, CRUD station, chart historis, WebSocket, MQTT, atau halaman detail station pada MVP ini.

## Kebutuhan Lokal

- PHP 8.3 atau lebih baru dengan ekstensi SQLite
- Composer 2
- Node.js dan npm

Versi yang digunakan saat development: PHP 8.4, Laravel 13.26, Node.js 26, dan npm 11.

## Instalasi

Jalankan dari root project:

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File -Force
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Buka [http://127.0.0.1:8000/map](http://127.0.0.1:8000/map).

Untuk macOS/Linux, gunakan `cp .env.example .env` dan `touch database/database.sqlite` sebagai pengganti command PowerShell terkait.

## Development

Jalankan Laravel:

```powershell
php artisan serve
```

Pada terminal kedua, jalankan Vite:

```powershell
npm run dev
```

## Endpoint

| Method | URL | Fungsi |
| --- | --- | --- |
| GET | `/map` | Dashboard monitoring interaktif |
| GET | `/api/stations` | Daftar station berkoordinat |
| GET | `/api/stations/summary` | Ringkasan global station |

Query `/api/stations` yang didukung:

```text
?search=
?type=ARR
?status=online
?organization=BTN-SUMATERA
```

Filter dapat digabungkan. Gunakan `type=OTHER` untuk tipe selain `ARR`, `AWLR`, `AWS`, dan `AWLR_ARR`.

## Test dan Build

```powershell
php artisan test
npm run test:js
npm run build
```

Reset database dummy:

```powershell
php artisan migrate:fresh --seed
```

## Catatan Data dan Peta

- Seluruh station, device ID, organisasi, serta telemetry dibuat khusus untuk prototype ini.
- Nama provinsi/kota dipakai hanya sebagai konteks geografis umum.
- Tidak ada request ke endpoint Higertech dan tidak ada Google Maps API/API key.
- Tile OpenStreetMap memerlukan koneksi internet dan tetap tunduk pada kebijakan penggunaan tile serta atribusi OpenStreetMap.
