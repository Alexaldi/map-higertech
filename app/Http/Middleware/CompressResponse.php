<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompressResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Don't compress during unit tests or for binary file/streamed responses
        if (app()->runningUnitTests() || $response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        if (function_exists('gzencode') && str_contains((string) $request->header('Accept-Encoding'), 'gzip')) {
            $content = $response->getContent();

            // Only compress string responses > 1KB that are not already encoded
            if (is_string($content) && strlen($content) > 1024 && ! $response->headers->has('Content-Encoding')) {
                $compressed = gzencode($content, 6);
                if ($compressed !== false) {
                    $response->setContent($compressed);
                    $response->headers->set('Content-Encoding', 'gzip');
                    $response->headers->set('Content-Length', (string) strlen($compressed));
                    $response->headers->set('Vary', 'Accept-Encoding', false);
                }
            }
        }

        return $response;
    }
}

