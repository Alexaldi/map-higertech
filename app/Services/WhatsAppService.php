<?php

namespace App\Services;

use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;
    protected ?string $deviceId;
    protected ?string $adminNumber;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.gowa.url', 'http://127.0.0.1:3000'), '/');
        $this->deviceId = config('services.gowa.device_id');
        $this->adminNumber = config('services.gowa.admin_number');
    }

    /**
     * Kirim pesan teks WA secara umum
     */
    public function sendMessage(string $phone, string $message): bool
    {
        // Standarisasi nomor: buang +, spasi, dash, dan ubah 08xx jadi 628xx
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        }

        try {
            $headers = ['Content-Type' => 'application/json'];
            if ($this->deviceId) {
                $headers['X-Device-Id'] = $this->deviceId;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->post("{$this->baseUrl}/send/message", [
                    'phone'   => $phone,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('GOWA WhatsApp Send Failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            // Fail-safe: jika server GOWA mati/offline, sistem utama Laravel tetap jalan
            Log::error('GOWA WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format & kirim notifikasi pengajuan magang baru ke Admin
     */
    public function notifyNewInternshipApplication(InternshipApplication $application): bool
    {
        if (empty($this->adminNumber)) {
            return false;
        }

        // Link detail admin pengajuan magang
        $detailUrl = route('admin.internships.show', $application->id);

        // Susun template pesan rapi
        $message = "🔔 *PEMBERITAHUAN LAMARAN MAGANG BARU*\n\n"
            . "Telah masuk pengajuan magang baru di Portal Higertech:\n\n"
            . "• *No. Registrasi:* `{$application->registration_code}`\n"
            . "• *Nama Pelamar:* {$application->name}\n"
            . "• *Tingkat:* {$application->type_label}\n"
            . "• *Asal Institusi:* {$application->institution}\n"
            . "• *Jurusan / Jalur:* {$application->major} ({$application->track})\n"
            . "• *Tipe Pengajuan:* " . ($application->application_type === 'group' ? 'Kelompok / Tim' : 'Individu') . "\n"
            . "• *No. WhatsApp Pelamar:* {$application->phone}\n"
            . "• *Periode Magang:* {$application->duration} (Mulai: {$application->start_period})\n\n"
            . "📂 *Link Berkas & Detail Pengajuan:*\n"
            . "{$detailUrl}\n\n"
            . "Silakan klik tautan di atas untuk mereview CV, portofolio, dan surat pengantar pelamar.\n"
            . "— _Sistem Otomasi Telemetri Higertech_";

        return $this->sendMessage($this->adminNumber, $message);
    }
}
