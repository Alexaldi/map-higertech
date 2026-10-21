<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceApiLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceApiLogController extends Controller
{
    /**
     * Tampilkan riwayat log penangkapan request API telemetri perangkat
     */
    public function index(Request $request): View
    {
        $logs = DeviceApiLog::orderByDesc('created_at')->orderByDesc('id')->get();

        $stats = [
            'total'      => $logs->count(),
            'success'    => $logs->where('status', 'success')->count(),
            'failed'     => $logs->where('status', 'failed')->count(),
            'subdomains' => $logs->pluck('sub_domain')->unique()->count(),
        ];

        return view('admin.device-logs.index', compact('logs', 'stats'));
    }

    /**
     * Hapus satu baris log
     */
    public function destroy(DeviceApiLog $deviceLog): RedirectResponse
    {
        $deviceLog->delete();

        return redirect()
            ->route('admin.device-logs.index')
            ->with('success', 'Data log API telemetri berhasil dihapus.');
    }

    /**
     * Kosongkan seluruh log telemetri
     */
    public function clear(): RedirectResponse
    {
        DeviceApiLog::truncate();

        return redirect()
            ->route('admin.device-logs.index')
            ->with('success', 'Seluruh riwayat log API telemetri berhasil dibersihkan.');
    }
}
