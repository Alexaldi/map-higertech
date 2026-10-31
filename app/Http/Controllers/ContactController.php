<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Services\WhatsAppService;
use App\Services\TurnstileService;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request, WhatsAppService $waService, TurnstileService $turnstile)
    {
        // ── 1. Verifikasi CAPTCHA Cloudflare Turnstile ────────────────────────
        $token = $request->input('cf-turnstile-response');

        if (! $turnstile->verify($token, $request->ip())) {
            return back()
                ->withInput()
                ->withErrors(['captcha' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.']);
        }

        // ── 2. Validasi field form ────────────────────────────────────────────
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        // ── 3. Simpan ke database ─────────────────────────────────────────────
        $contactMessage = ContactMessage::create($validated);

        // ── 4. Kirim notifikasi WhatsApp ke Admin (fail-safe) ─────────────────
        try {
            $waService->notifyNewContactMessage($contactMessage);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi WhatsApp untuk pesan kontak: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}

