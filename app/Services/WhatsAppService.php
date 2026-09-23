<?php

namespace App\Services;

use App\Models\InternshipApplication;
use App\Models\WhatsAppLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsAppService
{
    protected string $baseUrl;
    protected ?string $deviceId;
    protected ?string $adminNumber;
    protected ?string $username;
    protected ?string $password;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.gowa.url', 'http://127.0.0.1:3000'), '/');
        $this->deviceId = config('services.gowa.device_id');
        $this->adminNumber = setting('internship_wa_notification', config('services.gowa.admin_number'));
        $this->username = config('services.gowa.username');
        $this->password = config('services.gowa.password');
    }

    /**
     * Build HTTP client dengan Basic Auth (jika dikonfigurasi)
     */
    protected function newHttpClient(int $timeout = 10): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::timeout($timeout);

        if (!empty($this->username) && !empty($this->password)) {
            $client->withBasicAuth($this->username, $this->password);
        }

        return $client;
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
            if (! empty($this->deviceId) && $this->deviceId !== 'default') {
                $headers['X-Device-Id'] = $this->deviceId;
            }

            $response = $this->newHttpClient(10)
                ->withHeaders($headers)
                ->post("{$this->baseUrl}/send/message", [
                    'phone'   => $phone,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                $this->recordLog($phone, 'text', $message, null, null, 'success');
                return true;
            }

            $this->recordLog($phone, 'text', $message, null, null, 'failed', "Status: {$response->status()} - {$response->body()}");

            Log::warning('GOWA WhatsApp Send Failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            // Fail-safe: jika server GOWA mati/offline, sistem utama Laravel tetap jalan
            $this->recordLog($phone, 'text', $message, null, null, 'failed', $e->getMessage());
            Log::error('GOWA WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim file / berkas dokumen ke WA
     */
    public function sendFile(string $phone, string $absoluteFilePath, string $caption = '', ?string $customFilename = null): bool
    {
        $filename = $customFilename ?: basename($absoluteFilePath);

        if (! file_exists($absoluteFilePath)) {
            $this->recordLog($phone, 'file', $caption, $filename, $absoluteFilePath, 'failed', 'Berkas tidak ditemukan pada direktori penyimpanan.');
            return false;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        }

        try {
            $headers = [];
            if (! empty($this->deviceId) && $this->deviceId !== 'default') {
                $headers['X-Device-Id'] = $this->deviceId;
            }

            $response = $this->newHttpClient(30)
                ->withHeaders($headers)
                ->attach('file', file_get_contents($absoluteFilePath), $filename)
                ->post("{$this->baseUrl}/send/file", [
                    'phone'   => $phone,
                    'caption' => $caption,
                ]);

            if ($response->successful()) {
                $this->recordLog($phone, 'file', $caption, $filename, $absoluteFilePath, 'success');
                return true;
            }

            $this->recordLog($phone, 'file', $caption, $filename, $absoluteFilePath, 'failed', "Status: {$response->status()} - {$response->body()}");

            Log::warning('GOWA WhatsApp Send File Failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            $this->recordLog($phone, 'file', $caption, $filename, $absoluteFilePath, 'failed', $e->getMessage());
            Log::error('GOWA WhatsApp Send File Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Catat riwayat pengiriman pesan WhatsApp ke database
     */
    protected function recordLog(
        string $phone,
        string $type,
        ?string $message,
        ?string $attachmentName,
        ?string $attachmentPath,
        string $status,
        ?string $response = null
    ): void {
        try {
            WhatsAppLog::create([
                'phone'           => $phone,
                'type'            => $type,
                'message'         => $message,
                'attachment_name' => $attachmentName,
                'attachment_path' => $attachmentPath,
                'status'          => $status,
                'response'        => $response,
                'sent_at'         => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('GOWA WhatsApp Logging Exception: ' . $e->getMessage());
        }
    }

    /**
     * Format & kirim notifikasi pengajuan magang baru ke Admin beserta berkas jika tersedia
     */
    public function notifyNewInternshipApplication(InternshipApplication $application): bool
    {
        if (empty($this->adminNumber)) {
            return false;
        }

        $cacheKey = "wa_new_app_notif_{$application->id}";
        if (cache()->has($cacheKey)) {
            Log::info("WA notification for new application {$application->id} skipped (duplicate prevention)");
            return false;
        }
        cache()->put($cacheKey, true, 30);

        // Link detail admin pengajuan magang
        $detailUrl = route('admin.internships.show', $application->id);

        $startPeriodLabel = $application->start_period;
        try {
            if (! empty($application->start_period)) {
                $startPeriodLabel = \Carbon\Carbon::parse($application->start_period)->translatedFormat('F Y');
            }
        } catch (\Throwable $e) {
            $startPeriodLabel = $application->start_period;
        }

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
            . "• *Periode Magang:* {$application->duration} (Mulai: {$startPeriodLabel})\n\n"
            . "📂 *Link Berkas & Detail Pengajuan:*\n"
            . "{$detailUrl}\n\n"
            . "Silakan klik tautan di atas untuk mereview CV, portofolio, dan surat pengantar pelamar.\n"
            . "— _Sistem Otomasi Telemetri Higertech_";

        $sent = $this->sendMessage($this->adminNumber, $message);

        // 1. Berkas CV
        if (! empty($application->file_cv) && Storage::disk('public')->exists($application->file_cv)) {
            $cvPath = Storage::disk('public')->path($application->file_cv);
            $this->sendFile(
                $this->adminNumber,
                $cvPath,
                "📄 *Curriculum Vitae (CV)* - {$application->name}",
                "CV-{$application->registration_code}." . pathinfo($cvPath, PATHINFO_EXTENSION)
            );
        }

        // 2. Berkas Surat Pengantar / Rekomendasi
        if (! empty($application->file_recommendation) && Storage::disk('public')->exists($application->file_recommendation)) {
            $recPath = Storage::disk('public')->path($application->file_recommendation);
            $this->sendFile(
                $this->adminNumber,
                $recPath,
                "📑 *Surat Pengantar / Rekomendasi* - {$application->institution}",
                "Surat-Pengantar-{$application->registration_code}." . pathinfo($recPath, PATHINFO_EXTENSION)
            );
        }

        // 3. Berkas Identitas (KTP / KTM / Kartu Pelajar)
        // 3. Berkas Identitas (KTM / Kartu Pelajar)
        if (! empty($application->file_identity) && Storage::disk('public')->exists($application->file_identity)) {
            $idPath = Storage::disk('public')->path($application->file_identity);
            $idLabel = $application->type === 'university' ? 'KTM (Kartu Mahasiswa)' : 'Kartu Pelajar';
            $this->sendFile(
                $this->adminNumber,
                $idPath,
                "🪪 *Identitas ({$idLabel})* - {$application->name}",
                "Identitas-{$application->registration_code}." . pathinfo($idPath, PATHINFO_EXTENSION)
            );
        }

        // 4. Berkas Transkrip / Rapor
        if (! empty($application->file_transcript) && Storage::disk('public')->exists($application->file_transcript)) {
            $trPath = Storage::disk('public')->path($application->file_transcript);
            $this->sendFile(
                $this->adminNumber,
                $trPath,
                "📊 *Transkrip Nilai / Rapor* - {$application->name}",
                "Transkrip-{$application->registration_code}." . pathinfo($trPath, PATHINFO_EXTENSION)
            );
        }

        return $sent;
    }

    /**
     * Kirim notifikasi hasil review magang (Diterima / Ditolak) ke WhatsApp pelamar (Ketua Tim / PIC)
     */
    public function notifyApplicantStatusUpdate(InternshipApplication $application): bool
    {
        if (empty($application->phone)) {
            return false;
        }

        $isAccepted = $application->status === 'accepted';
        $isRejected = $application->status === 'rejected';

        if (! $isAccepted && ! $isRejected) {
            return false;
        }

        $cacheKey = "wa_status_notif_{$application->id}_{$application->status}";
        if (cache()->has($cacheKey)) {
            Log::info("WA notification for app {$application->id} status {$application->status} skipped (duplicate prevention)");
            return false;
        }
        cache()->put($cacheKey, true, 30);

        $appTypeLabel = $application->application_type === 'group' ? 'Kelompok / Tim' : 'Individu';
        $notesText = ! empty($application->notes) ? "\n📝 *Catatan Pembina:*\n_{$application->notes}_\n" : '';

        // Tampilkan info anggota tim jika kelompok
        $teamText = '';
        if ($application->application_type === 'group' && $application->all_members->count() > 1) {
            $memberNames = $application->all_members->pluck('name')->implode(', ');
            $teamText = "\n👥 *Anggota Tim:* {$memberNames}\n";
        }

        if ($isAccepted) {
            $letterUrl = route('internship.letter', $application->registration_code);
            $message = "🎉 *SELAMAT! PERMOHONAN MAGANG ANDA DITERIMA*\n\n"
                . "Halo *{$application->name}*,\n"
                . "Permohonan magang Anda di *PT Higertech Karya Sinergi* telah ditinjau dan dinyatakan *DITERIMA (APPROVED)*.\n\n"
                . "📋 *Detail Pengajuan:*\n"
                . "• *No. Registrasi:* `{$application->registration_code}`\n"
                . "• *Tingkat:* {$application->type_label}\n"
                . "• *Institusi:* {$application->institution}\n"
                . "• *Peminatan / Jalur:* {$application->track}\n"
                . "• *Periode Magang:* {$application->duration}\n"
                . "• *Tipe Pengajuan:* {$appTypeLabel}\n"
                . $teamText
                . $notesText . "\n"
                . "📄 *Surat Balasan Penerimaan Resmi (LoA):*\n"
                . "{$letterUrl}\n\n"
                . "Silakan klik tautan di atas untuk mengunduh Surat Balasan Resmi untuk keperluan administrasi kampus/sekolah Anda.\n\n"
                . "Selamat bergabung dalam ekosistem litbang telemetri Higertech!\n"
                . "— _Tim Litbang & HR PT Higertech Karya Sinergi_";

            $sent = $this->sendMessage($application->phone, $message);

            // Coba kirim juga berkas LoA PDF langsung ke WhatsApp
            try {
                $appService = app(\App\Services\Admin\InternshipApplicationService::class);
                $pdf = $appService->generateAcceptancePdf($application);
                $tempDir = storage_path('app/temp');
                if (! file_exists($tempDir)) {
                    mkdir($tempDir, 0755, true);
                }
                $tempPath = $tempDir . '/Surat-Penerimaan-' . $application->registration_code . '.pdf';
                file_put_contents($tempPath, $pdf->output());

                if (file_exists($tempPath)) {
                    $this->sendFile(
                        $application->phone,
                        $tempPath,
                        "📄 *Surat Balasan Penerimaan Resmi (LoA)* - {$application->name}",
                        "Surat-Penerimaan-{$application->registration_code}.pdf"
                    );
                    @unlink($tempPath);
                }
            } catch (\Throwable $e) {
                Log::warning('GOWA LoA PDF generation for WA failed: ' . $e->getMessage());
            }

            return $sent;
        }

        // Jika status rejected (Ditolak)
        $message = "📢 *PEMBERITAHUAN SELEKSI PERMOHONAN MAGANG*\n\n"
            . "Halo *{$application->name}*,\n"
            . "Terima kasih atas minat dan antusiasme Anda untuk bergabung dalam program magang di *PT Higertech Karya Sinergi*.\n\n"
            . "📋 *Data Permohonan:*\n"
            . "• *No. Registrasi:* `{$application->registration_code}`\n"
            . "• *Asal Institusi:* {$application->institution}\n"
            . "• *Peminatan / Jalur:* {$application->track}\n\n"
            . "Berdasarkan hasil seleksi berkas dan ketersediaan kuota pembina Litbang saat ini, dengan berat hati kami sampaikan bahwa permohonan magang Anda *Belum Dapat Diterima* dikarenakan kuota yang telah terpenuhi.\n"
            . $notesText . "\n"
            . "Kami sangat mengapresiasi portofolio dan semangat Anda. Tetap semangat, terus berkarya, dan semoga sukses dalam studi serta kesempatan di masa mendatang.\n\n"
            . "Salam hangat,\n"
            . "— _Tim Seleksi & Litbang PT Higertech Karya Sinergi_";

        return $this->sendMessage($application->phone, $message);
    }
}
