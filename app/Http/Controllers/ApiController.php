<?php

namespace App\Http\Controllers;

use App\Models\DeviceApiLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Meneruskan (forward/relay) data pembacaan sensor dari alat lapangan
     * ke subdomain server balai masing-masing, sekaligus mencatat riwayat log.
     *
     * Contoh:
     * Request masuk: http://higertech.com/hkabbwscitarum/api/device/store?ch=15
     * Diteruskan ke: http://hkabbwscitarum.higertech.com/api/device/store?ch=15
     */
    public function storeReading(string $sub_domain, Request $request): Response|\Illuminate\Http\JsonResponse
    {
        $startTime = microtime(true);

        // Validasi keamanan nama subdomain (hanya alfanumerik, dash, dan underscore)
        if (! preg_match('/^[a-zA-Z0-9\-_]+$/', $sub_domain)) {
            return response()->json([
                'error' => 'Subdomain tidak valid.',
            ], 400);
        }

        // Ambil seluruh query parameters dari alat (misal: ch=10, batt=12.4, dll)
        $queryParams = $request->query();
        $targetUrl = 'http://' . strtolower($sub_domain) . '.higertech.com/api/device/store';

        try {
            // Forward request GET ke server balai dengan timeout 15 detik
            $response = Http::timeout(15)->get($targetUrl, $queryParams);
            $statusCode = $response->status();
            $body = $response->body();
            $durationMs = (int) round((microtime(true) - $startTime) * 1000);

            // Rekam log penangkapan request
            $this->recordLog($sub_domain, $request, $statusCode, $body, $durationMs);

            return response($body, $statusCode)
                ->header('Content-Type', $response->header('Content-Type') ?: 'application/json');
        } catch (\Throwable $e) {
            $durationMs = (int) round((microtime(true) - $startTime) * 1000);

            Log::error("Gagal meneruskan data telemetri ke {$targetUrl}: " . $e->getMessage(), [
                'sub_domain'   => $sub_domain,
                'query_params' => $queryParams,
            ]);

            // Rekam log kegagalan request
            $this->recordLog($sub_domain, $request, 500, $e->getMessage(), $durationMs);

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan rekaman log telemetri ke database secara aman (tidak merusak respon jika logging terkendala).
     */
    protected function recordLog(string $subDomain, Request $request, int $statusCode, string $responseBody, int $durationMs): void
    {
        try {
            DeviceApiLog::create([
                'sub_domain'    => strtolower($subDomain),
                'endpoint'      => '/api/device/store',
                'method'        => $request->method(),
                'payload'       => $request->query(),
                'ip_address'    => $request->ip(),
                'status_code'   => $statusCode,
                'status'        => ($statusCode >= 200 && $statusCode < 400) ? 'success' : 'failed',
                'response_body' => mb_substr($responseBody, 0, 1000),
                'duration_ms'   => $durationMs,
            ]);
        } catch (\Throwable $logException) {
            Log::warning('Gagal mencatat log API telemetri: ' . $logException->getMessage());
        }
    }
}
