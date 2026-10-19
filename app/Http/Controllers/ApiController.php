<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Meneruskan (forward/relay) data pembacaan sensor dari alat lapangan
     * ke subdomain server balai masing-masing.
     *
     * Contoh:
     * Request masuk: http://higertech.com/hkabbwscitarum/api/device/store?ch=15
     * Diteruskan ke: http://hkabbwscitarum.higertech.com/api/device/store?ch=15
     */
    public function storeReading(string $sub_domain, Request $request): Response|\Illuminate\Http\JsonResponse
    {
        // Validasi keamanan nama subdomain (hanya alfanumerik, dash, dan underscore)
        if (! preg_match('/^[a-zA-Z0-9\-_]+$/', $sub_domain)) {
            return response()->json([
                'error' => 'Subdomain tidak valid.',
            ], 400);
        }

        // Ambil seluruh query parameters dari alat (misal: ch=10, batt=12.4, dll)
        $queryParams = $request->query();

        // Alamat server target balai
        $targetUrl = 'http://' . strtolower($sub_domain) . '.higertech.com/api/device/store';

        try {
            // Forward request GET ke server balai dengan timeout 15 detik
            $response = Http::timeout(15)->get($targetUrl, $queryParams);

            return response($response->body(), $response->status())
                ->header('Content-Type', $response->header('Content-Type') ?: 'application/json');
        } catch (\Throwable $e) {
            Log::error("Gagal meneruskan data telemetri ke {$targetUrl}: " . $e->getMessage(), [
                'sub_domain'   => $sub_domain,
                'query_params' => $queryParams,
            ]);

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

