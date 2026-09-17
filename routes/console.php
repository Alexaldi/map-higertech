<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('wa:test {phone} {message=Halo, ini pesan uji coba WhatsApp Telemetri Higertech!}', function (string $phone, string $message, \App\Services\Notification\WahaService $waha) {
    $this->info("Menghubungi gateway WhatsApp untuk nomor: {$phone}");
    $configured = $waha->isConfigured();
    $this->line("Status Konfigurasi WAHA: " . ($configured ? "<fg=green>TERHUBUNG (Real Mode)</>" : "<fg=yellow>SIMULASI / DUMMY (Cek storage/logs/laravel.log)</>"));

    $success = $waha->sendTextMessage($phone, $message);
    if ($success) {
        $this->info("Pesan berhasil diproses!");
        if (! $configured) {
            $this->comment("Catatan: Karena WAHA_API_URL belum diatur di .env, pesan otomatis dicatat di storage/logs/laravel.log.");
        }
    } else {
        $this->error("Gagal mengirim pesan WhatsApp. Periksa koneksi gateway atau log aplikasi.");
    }
})->purpose('Kirim pesan tes WhatsApp via WahaService');
