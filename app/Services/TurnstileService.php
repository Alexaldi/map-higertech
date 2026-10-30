<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Cloudflare Turnstile CAPTCHA Verification Service.
 *
 * Verifikasi token dilakukan server-side terhadap endpoint resmi Cloudflare.
 * Secret Key TIDAK pernah dikirim ke client.
 */
class TurnstileService
{
    private string $secretKey;
    private string $verifyUrl;
    private int $timeout;

    public function __construct()
    {
        $this->secretKey = (string) config('services.turnstile.secret_key', '');
        $this->verifyUrl = (string) config('services.turnstile.verify_url', 'https://challenges.cloudflare.com/turnstile/v0/siteverify');
        $this->timeout   = (int)   config('services.turnstile.timeout', 10);
    }

    /**
     * Verifikasi token Turnstile dari request pengunjung.
     *
     * @param  string|null  $token  Token cf-turnstile-response dari form.
     * @param  string|null  $ip     IP pengunjung untuk audit log Cloudflare.
     * @return bool                 true jika verifikasi berhasil, false jika gagal.
     */
    public function verify(?string $token, ?string $ip = null): bool
    {
        // Jika site_key / secret_key belum dikonfigurasi, blokir — jangan bypass.
        if (empty($this->secretKey)) {
            Log::warning('Turnstile: TURNSTILE_SECRET_KEY belum dikonfigurasi. Pengiriman form kontak diblokir.');
            return false;
        }

        // Token wajib ada dan tidak boleh kosong.
        if (empty($token)) {
            return false;
        }

        $payload = [
            'secret'   => $this->secretKey,
            'response' => $token,
        ];

        if (! empty($ip)) {
            $payload['remoteip'] = $ip;
        }

        try {
            $response = Http::timeout($this->timeout)
                ->asForm()
                ->post($this->verifyUrl, $payload);

            if (! $response->successful()) {
                Log::warning('Turnstile: HTTP request gagal.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            $result = $response->json();

            // Catat error codes dari Cloudflare jika ada
            if (! empty($result['error-codes'])) {
                Log::info('Turnstile: Verifikasi gagal.', ['error_codes' => $result['error-codes']]);
            }

            return (bool) ($result['success'] ?? false);

        } catch (\Throwable $e) {
            // Jika layanan Cloudflare tidak dapat dijangkau, JANGAN bypass proteksi.
            Log::error('Turnstile: Exception saat verifikasi — ' . $e->getMessage());
            return false;
        }
    }
}

