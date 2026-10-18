<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Services\WhatsAppService;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request, WhatsAppService $waService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string',
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Notify Admin (Fail-safe: jangan gagalkan submit pesan jika notifikasi WA bermasalah)
        try {
            $waService->notifyNewContactMessage($contactMessage);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi WhatsApp untuk pesan kontak: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
