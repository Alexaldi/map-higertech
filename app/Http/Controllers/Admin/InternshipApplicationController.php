<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use App\Services\Admin\InternshipApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InternshipApplicationController extends Controller
{
    public function __construct(
        private readonly InternshipApplicationService $service
    ) {}

    /**
     * Display a listing of internship applications.
     */
    public function index(Request $request): View
    {
        $filters = [
            'type' => $request->query('type'),
            'status' => $request->query('status'),
            'search' => $request->query('search'),
        ];

        $applications = $this->service->getPaginated($filters, 12);
        $counts = $this->service->getCounts();

        return view('admin.internships.index', compact('applications', 'counts', 'filters'));
    }

    /**
     * Show detailed data of an application (used by modal or AJAX preview).
     */
    public function show(InternshipApplication $internship): JsonResponse|RedirectResponse
    {
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'application' => [
                    'id' => $internship->id,
                    'registration_code' => $internship->registration_code,
                    'application_type' => $internship->application_type,
                    'is_group' => $internship->is_group,
                    'type' => $internship->type,
                    'type_label' => $internship->type_label,
                    'name' => $internship->name,
                    'email' => $internship->email,
                    'phone' => $internship->phone,
                    'identity_number' => $internship->identity_number,
                    'institution' => $internship->institution,
                    'institution_address' => $internship->institution_address,
                    'major' => $internship->major,
                    'head_of_program' => $internship->head_of_program,
                    'grade_level' => $internship->grade_level,
                    'track' => $internship->track,
                    'duration' => $internship->duration,
                    'start_date' => $internship->start_date ? $internship->start_date->format('Y-m-d') : null,
                    'end_date' => $internship->end_date ? $internship->end_date->format('Y-m-d') : null,
                    'period_formatted' => $internship->period_formatted,
                    'status' => $internship->status,
                    'status_label' => $internship->status_label,
                    'badge_class' => $internship->badge_class,
                    'notes' => $internship->notes,
                    'reference_number' => $internship->reference_number,
                    'reference_date' => $internship->reference_date ? $internship->reference_date->format('Y-m-d') : null,
                    'acceptance_number' => $internship->acceptance_number_formatted,
                    'acceptance_date' => $internship->acceptance_date ? $internship->acceptance_date->format('Y-m-d') : now()->format('Y-m-d'),
                    'letter_download_url' => route('admin.internships.letter', $internship),
                    'letter_preview_url' => route('admin.internships.letter.preview', $internship),
                    'notified_at' => $internship->notified_at ? $internship->notified_at->timezone('Asia/Jakarta')->format('d M Y H:i') : null,
                    'created_at' => $internship->created_at->timezone('Asia/Jakarta')->format('d M Y H:i'),
                    'members' => $internship->all_members->map(fn ($m) => [
                        'id' => $m->id,
                        'name' => $m->name,
                        'identity_number' => $m->identity_number,
                        'phone' => $m->phone,
                        'email' => $m->email,
                        'is_leader' => (bool) $m->is_leader,
                        'file_identity_url' => $m->file_identity_url,
                        'file_cv_url' => $m->file_cv_url,
                        'file_transcript_url' => $m->file_transcript_url,
                    ]),
                    'documents' => [
                        'identity' => [
                            'name' => $internship->type === 'vocational' ? 'Kartu Pelajar / KTP' : 'KTM / KTP Mahasiswa',
                            'name' => $internship->type === 'vocational' ? 'Kartu Pelajar' : 'KTM Mahasiswa',
                            'url' => $internship->file_identity_url,
                        ],
                        'recommendation' => [
                            'name' => $internship->type === 'vocational' ? 'Surat Pengantar Sekolah' : 'Surat Pengantar Kampus / MBKM',
                            'url' => $internship->file_recommendation_url,
                        ],
                        'cv' => [
                            'name' => 'CV / Portofolio / Riwayat Hidup',
                            'url' => $internship->file_cv_url,
                        ],
                        'transcript' => [
                            'name' => $internship->type === 'vocational' ? 'Rapor Terakhir' : 'Transkrip Nilai Kumulatif',
                            'url' => $internship->file_transcript_url,
                        ],
                    ],
                ],
            ]);
        }

        return redirect()->route('admin.internships.index', ['review' => $internship->id]);
    }

    /**
     * Update status, acceptance letter details, and notes for an internship application.
     */
    public function update(Request $request, InternshipApplication $internship): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected',
            'notes' => 'nullable|string|max:1500',
            'acceptance_number' => 'nullable|string|max:100',
            'acceptance_date' => 'nullable|date',
            'head_of_program' => 'nullable|string|max:255',
            'institution_address' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'reference_date' => 'nullable|date',
        ], [
            'status.required' => 'Pilih keputusan status permohonan magang.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'notes.max' => 'Catatan pembina maksimal 1500 karakter.',
        ]);

        $this->service->updateStatus(
            $internship,
            $validated['status'],
            $validated['notes'] ?? null,
            $validated['acceptance_number'] ?? null,
            $validated['acceptance_date'] ?? null,
            array_filter([
                'head_of_program' => $validated['head_of_program'] ?? null,
                'institution_address' => $validated['institution_address'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'reference_date' => $validated['reference_date'] ?? null,
            ], fn($v) => !is_null($v))
        );

        // Kirim notifikasi WhatsApp otomatis ke pelamar secara asinkron (non-blocking) jika diterima/ditolak
        if (in_array($validated['status'], ['accepted', 'rejected'])) {
            try {
                \App\Jobs\SendWhatsAppNotification::dispatchAsync($internship->id, 'status_update');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('GOWA WA notification dispatch failed: ' . $e->getMessage());
            }
        }

        $statusText = match ($validated['status']) {
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'reviewing' => 'Sedang Ditinjau',
            default => 'Pending',
        };

        $message = "Status permohonan magang untuk {$internship->name} berhasil diperbarui menjadi: {$statusText}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $validated['status'],
                'status_label' => $internship->fresh()->status_label,
                'letter_download_url' => route('admin.internships.letter', $internship),
            ]);
        }

        return redirect()
            ->route('admin.internships.index')
            ->with('success', $message);
    }

    /**
     * Download the official Letter of Acceptance (LoA) PDF.
     */
    public function downloadLetter(InternshipApplication $internship): Response
    {
        $pdf = $this->service->generateAcceptancePdf($internship);
        $filename = 'Surat_Balasan_Magang_' . Str::slug($internship->name) . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Preview/Stream the official Letter of Acceptance (LoA) PDF directly in browser.
     */
    public function previewLetter(InternshipApplication $internship): Response
    {
        $pdf = $this->service->generateAcceptancePdf($internship);
        $filename = 'Surat_Balasan_Magang_' . Str::slug($internship->name) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Remove an application and its files.
     */
    public function destroy(InternshipApplication $internship): RedirectResponse|JsonResponse
    {
        $name = $internship->name;
        $this->service->delete($internship);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Berkas pendaftaran magang atas nama {$name} berhasil dihapus.",
            ]);
        }

        return redirect()
            ->back(fallback: route('admin.internships.index'))
            ->with('success', "Berkas pendaftaran magang atas nama {$name} berhasil dihapus.");
    }
}
