<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhatsAppLogController extends Controller
{
    /**
     * Tampilkan seluruh riwayat pengiriman pesan & berkas WhatsApp
     */
    public function index(Request $request): View
    {
        $logs = WhatsAppLog::latest('sent_at')->get();

        $stats = [
            'total'   => $logs->count(),
            'success' => $logs->where('status', 'success')->count(),
            'failed'  => $logs->where('status', 'failed')->count(),
        ];

        return view('admin.whatsapp-logs.index', compact('logs', 'stats'));
    }

    /**
     * Hapus satu baris log
     */
    public function destroy(WhatsAppLog $whatsappLog): RedirectResponse
    {
        $whatsappLog->delete();

        return redirect()
            ->route('admin.whatsapp-logs.index')
            ->with('success', 'Data log WhatsApp berhasil dihapus.');
    }

    /**
     * Kosongkan seluruh log WhatsApp
     */
    public function clear(): RedirectResponse
    {
        WhatsAppLog::truncate();

        return redirect()
            ->route('admin.whatsapp-logs.index')
            ->with('success', 'Seluruh riwayat log WhatsApp berhasil dibersihkan.');
    }
}

