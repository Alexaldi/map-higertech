<?php

namespace App\Services\Notification;

use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaService
{
    private ?string $apiUrl;
    private ?string $apiKey;
    private string $session;
    private ?string $supervisorPhone;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.waha.url', ''), '/');
        $this->apiKey = config('services.waha.key', '');
        $this->session = config('services.waha.session', 'default');
        $this->supervisorPhone = config('services.waha.supervisor_phone', '');
    }

    /**
     * Check if WAHA endpoint is configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiUrl);
    }

    /**
     * Format phone number to international WhatsApp format (e.g. 62812345678).
     */
    public function formatPhone(string $phone): string
    {
        // Remove spaces, dashes, parentheses, plus
        $clean = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        } elseif (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        }

        return $clean;
    }

    /**
     * Send plain text message via WAHA.
     */
    public function sendTextMessage(string $phone, string $message): bool
    {
        $formattedPhone = $this->formatPhone($phone);
        if (empty($formattedPhone)) {
            Log::warning("WAHA: Gagal mengirim pesan, format nomor telepon tidak valid: {$phone}");
            return false;
        }

        $chatId = "{$formattedPhone}@c.us";

        // If WAHA is not configured, simulate success and log to Laravel log for local development
        if (! $this->isConfigured()) {
            Log::info("WAHA (Simulated / Unconfigured URL) -> To: {$chatId} | Message:\n{$message}");
            return true;
        }

        try {
            $headers = ['Content-Type' => 'application/json'];
            if (! empty($this->apiKey)) {
                $headers['X-Api-Key'] = $this->apiKey;
            }

            $endpoint = "{$this->apiUrl}/api/sendText";
            $payload = [
                'session' => $this->session,
                'chatId' => $chatId,
                'text' => $message,
            ];

            $response = Http::withHeaders($headers)
                ->timeout(4)
                ->post($endpoint, $payload);

            if ($response->successful()) {
                Log::info("WAHA: Berhasil mengirim notifikasi WhatsApp ke {$chatId}");
                return true;
            }

            // If /api/sendText gave 404, fallback to session-specific endpoint /api/{session}/chats/sendText
            if ($response->status() === 404) {
                $altEndpoint = "{$this->apiUrl}/api/{$this->session}/chats/sendText";
                $altResponse = Http::withHeaders($headers)
                    ->timeout(4)
                    ->post($altEndpoint, [
                        'chatId' => $chatId,
                        'text' => $message,
                    ]);

                if ($altResponse->successful()) {
                    Log::info("WAHA (Alt endpoint): Berhasil mengirim notifikasi WhatsApp ke {$chatId}");
                    return true;
                }
            }

            Log::warning("WAHA Error: Respon API status {$response->status()} - {$response->body()}");
            return false;
        } catch (\Throwable $e) {
            Log::warning("WAHA Exception: Gagal menghubungi gateway WhatsApp: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to internship supervisor when new application submitted.
     */
    public function notifySupervisorNewSubmission(InternshipApplication $app): bool
    {
        $supervisorNumber = ! empty($this->supervisorPhone)
            ? $this->supervisorPhone
            : config('services.waha.supervisor_phone', '');

        if (empty($supervisorNumber) && function_exists('setting')) {
            $supervisorNumber = setting('contact_whatsapp', '');
        }

        if (empty($supervisorNumber)) {
            Log::info("WAHA: Nomor WA pembina belum diatur di .env atau setting. Notifikasi dicatat di log aplikasi.");
            $supervisorNumber = '082221010299'; // default fallback for log
        }

        $regCode = $app->registration_code;
        $adminUrl = url('/admin/internships');

        $message = "🔔 *Pemberitahuan Pendaftaran Magang Baru*\n"
            . "*PT Higertech Karya Sinergi*\n"
            . "──────────────────────────────\n"
            . "📋 *Kode Registrasi:* `{$regCode}`\n"
            . "👤 *Nama Peserta:* {$app->name}\n"
            . "🎓 *Kategori:* {$app->type_label}\n"
            . "🏛 *Institusi:* {$app->institution}\n"
            . ($app->major ? "📚 *Jurusan / Prodi:* {$app->major}\n" : "")
            . "🎯 *Peminatan:* {$app->track}\n"
            . "📅 *Periode Magang:* {$app->period_formatted} ({$app->duration})\n"
            . "📱 *Kontak Pemohon:* {$app->phone} ({$app->email})\n"
            . "──────────────────────────────\n"
            . "Mohon masuk ke Dashboard Admin untuk meninjau berkas portofolio & kelayakan:\n"
            . "👉 {$adminUrl}\n\n"
            . "_Pesan otomatis sistem telemetri Higertech._";

        return $this->sendTextMessage($supervisorNumber, $message);
    }

    /**
     * Send notification to applicant when their status is reviewed (accepted/rejected).
     */
    public function notifyApplicantStatusUpdate(InternshipApplication $app): bool
    {
        $regCode = $app->registration_code;
        $trackUrl = url('/internship/track?query=' . urlencode($regCode));
        $notes = ! empty($app->notes) ? trim($app->notes) : 'Tidak ada catatan tambahan.';

        if ($app->status === 'accepted') {
            $message = "🎉 *Selamat! Permohonan Magang Anda Diterima*\n"
                . "*PT Higertech Karya Sinergi*\n"
                . "──────────────────────────────\n"
                . "Halo *{$app->name}*,\n\n"
                . "Kami telah meninjau berkas dan permohonan magang yang Anda ajukan. Selamat, Anda dinyatakan *DITERIMA* untuk bergabung dalam program R&D Internship PT Higertech Karya Sinergi!\n\n"
                . "📋 *Kode Registrasi:* `{$regCode}`\n"
                . "🏛 *Institusi:* {$app->institution}\n"
                . "🎯 *Peminatan:* {$app->track}\n"
                . "📅 *Periode:* {$app->period_formatted} ({$app->duration})\n"
                . "✅ *Status Keputusan:* *DITERIMA (ACCEPTED)*\n\n"
                . "💬 *Catatan / Instruksi Pembina Magang:*\n"
                . "_{$notes}_\n\n"
                . "──────────────────────────────\n"
                . "Untuk mengecek status resmi atau mencetak bukti pendaftaran:\n"
                . "👉 {$trackUrl}\n\n"
                . "Silakan simpan nomor ini dan nantikan koordinasi teknis berikutnya dari tim pembina. Selamat berkarya & salam inovasi!\n"
                . "*Tim R&D Telemetry Higertech*";
        } elseif ($app->status === 'rejected') {
            $message = "📢 *Informasi Hasil Seleksi Magang*\n"
                . "*PT Higertech Karya Sinergi*\n"
                . "──────────────────────────────\n"
                . "Halo *{$app->name}*,\n\n"
                . "Terima kasih atas antusiasme dan permohonan magang yang telah Anda ajukan di PT Higertech Karya Sinergi.\n\n"
                . "Setelah melalui tahapan verifikasi dokumen dan penyesuaian kuota laboratorium, mohon maaf saat ini kami *belum dapat menerima* permohonan magang Anda untuk batch ini.\n\n"
                . "📋 *Kode Registrasi:* `{$regCode}`\n"
                . "🎯 *Peminatan:* {$app->track}\n"
                . "❌ *Status:* *BELUM DAPAT DITERIMA*\n\n"
                . "💬 *Catatan Pembina Magang:*\n"
                . "_{$notes}_\n\n"
                . "──────────────────────────────\n"
                . "Detail status dapat Anda pantau melalui:\n"
                . "👉 {$trackUrl}\n\n"
                . "Tetap semangat dalam menempuh pendidikan dan mengembangkan potensi enjiniring Anda!\n"
                . "*Tim R&D Telemetry Higertech*";
        } else {
            // For reviewing status
            $message = "ℹ️ *Update Status Permohonan Magang*\n"
                . "*PT Higertech Karya Sinergi*\n"
                . "──────────────────────────────\n"
                . "Halo *{$app->name}*,\n"
                . "Berkas pendaftaran magang Anda (`{$regCode}`) saat ini sedang dalam proses *Peninjauan (Review)* oleh tim pembina divisi {$app->track}.\n\n"
                . "Pantau status berkala di:\n"
                . "👉 {$trackUrl}\n\n"
                . "*PT Higertech Karya Sinergi*";
        }

        return $this->sendTextMessage($app->phone, $message);
    }
}

