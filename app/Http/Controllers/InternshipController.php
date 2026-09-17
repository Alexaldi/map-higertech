<?php

namespace App\Http\Controllers;

use App\Services\Admin\InternshipApplicationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InternshipController extends Controller
{
    public function __construct(
        private readonly InternshipApplicationService $service
    ) {}

    /**
     * Display the public internship information & registration page.
     */
    public function index(): View
    {
        $smkTracks = internship_tracks('vocational');
        $univTracks = internship_tracks('university');
        $internshipEnabled = is_internship_enabled();
        $closedMessage = setting('internship_closed_message', 'Mohon maaf, pendaftaran program magang periode saat ini sedang ditutup. Nantikan pengumuman batch berikutnya atau hubungi kontak kami untuk informasi lebih lanjut.');

        return view('internship.index', compact('smkTracks', 'univTracks', 'internshipEnabled', 'closedMessage'));
    }

    /**
     * Handle new application submission (SMK / Mahasiswa - Individual or Group).
     */
    public function apply(Request $request): JsonResponse
    {
        if (! is_internship_enabled()) {
            $closedMessage = setting('internship_closed_message', 'Mohon maaf, pendaftaran program magang saat ini sedang ditutup.');
            return response()->json([
                'success' => false,
                'message' => $closedMessage,
            ], 403);
        }

        // Merge institution from dropdown / manual input if needed
        if ($request->has('institution_select')) {
            if ($request->input('institution_select') === 'Lainnya' && ! empty($request->input('institution_other'))) {
                $request->merge(['institution' => trim($request->input('institution_other'))]);
            } elseif ($request->input('institution_select') !== 'Lainnya' && ! empty($request->input('institution_select'))) {
                $request->merge(['institution' => $request->input('institution_select')]);
            }
        } elseif (! empty($request->input('institution_other')) && empty($request->input('institution'))) {
            $request->merge(['institution' => trim($request->input('institution_other'))]);
        }

        // If application_type is individual (or not group), strip all members completely to avoid validation traps
        if ($request->input('application_type') !== 'group') {
            $request->merge(['application_type' => 'individual']);
            $request->request->remove('members');
            $request->files->remove('members');
        } else {
            // If group, clean out any completely blank member entries
            if ($request->has('members') && is_array($request->input('members'))) {
                $cleaned = array_filter($request->input('members'), function ($m) {
                    return ! empty($m['name']) || ! empty($m['identity_number']);
                });
                if (empty($cleaned)) {
                    $request->request->remove('members');
                    $request->files->remove('members');
                } else {
                    $request->merge(['members' => array_values($cleaned)]);
                }
            }
        }

        $validated = $request->validate([
            'type' => 'required|in:university,vocational',
            'application_type' => 'nullable|in:individual,group',
            'name' => 'required|string|max:255',
            'identity_number' => 'required|string|max:50',
            'institution' => 'required|string|max:255',
            'institution_other' => 'nullable|string|max:255',
            'institution_address' => 'nullable|string|max:255',
            'head_of_program' => 'nullable|string|max:255',
            'major' => $request->input('type') === 'university' ? 'required|string|max:255' : 'nullable|string|max:255',
            'major_other' => 'nullable|string|max:255',
            'grade_level' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:30',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'duration' => 'nullable|string|max:50',
            'start_period' => 'nullable|string|max:50',
            'track' => 'nullable|string|max:255',
            'track_other' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'reference_date' => 'nullable|date',
            'file_identity' => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'file_recommendation' => 'nullable|file|mimes:pdf|max:3072',
            'file_cv' => 'nullable|file|mimes:pdf|max:3072',
            'file_transcript' => 'required|file|mimes:pdf|max:3072',
            // Optional team members array
            'members' => 'nullable|array|max:8',
            'members.*.name' => 'required_with:members|string|max:255',
            'members.*.identity_number' => 'required_with:members|string|max:50',
            'members.*.email' => 'required_with:members|email|max:255',
            'members.*.phone' => 'nullable|string|max:30',
            'members.*.file_identity' => 'required_with:members|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'members.*.file_cv' => 'required_with:members|file|mimes:pdf|max:3072',
            'members.*.file_transcript' => 'required_with:members|file|mimes:pdf|max:3072',
        ], [
            'type.required' => 'Jenis jalur pendaftaran harus ditentukan.',
            'name.required' => 'Nama lengkap ketua/pemohon wajib diisi.',
            'identity_number.required' => 'NIM / NISN / NIK wajib diisi.',
            'institution.required' => 'Asal Universitas / Sekolah SMK wajib diisi.',
            'major.required' => 'Program Studi / Jurusan kuliah wajib diisi.',
            'grade_level.required' => 'Tingkat kelas / Semester wajib diisi.',
            'email.email' => 'Format alamat email siswa/mahasiswa tidak valid (contoh: nama@email.com).',
            'phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai magang tidak boleh sebelum hari ini.',
            'end_date.after_or_equal' => 'Tanggal selesai magang harus sama dengan atau setelah tanggal mulai magang.',
            'file_identity.required' => 'Scan KTP / Kartu Pelajar / KTM wajib diunggah.',
            'file_transcript.required' => 'Transkrip Nilai / Rapor wajib diunggah (Format PDF).',
            'file_identity.max' => 'Ukuran berkas identitas maksimal 3MB.',
            'file_recommendation.max' => 'Ukuran berkas surat pengantar maksimal 3MB.',
            'file_transcript.max' => 'Ukuran berkas transkrip nilai maksimal 3MB.',
            'file_cv.max' => 'Ukuran berkas CV maksimal 3MB.',
            'file_identity.mimes' => 'Berkas identitas harus berformat PDF atau gambar (JPG/PNG).',
            'file_recommendation.mimes' => 'Surat Pengantar harus berformat PDF.',
            'file_transcript.mimes' => 'Transkrip Nilai harus berformat PDF.',
            'file_cv.mimes' => 'CV harus berformat PDF.',
            'members.*.name.required_with' => 'Nama setiap anggota tim wajib diisi.',
            'members.*.identity_number.required_with' => 'NIM / NISN setiap anggota tim wajib diisi.',
            'members.*.email.required_with' => 'Alamat email setiap anggota tim wajib diisi.',
            'members.*.email.email' => 'Format alamat email anggota tim tidak valid (contoh: nama@email.com).',
            'members.*.file_identity.required_with' => 'Scan Kartu Pelajar / KTM setiap anggota tim wajib diunggah.',
            'members.*.file_cv.required_with' => 'Berkas CV / Portofolio setiap anggota tim wajib diunggah (Format PDF).',
            'members.*.file_transcript.required_with' => 'Transkrip Nilai / Rapor setiap anggota tim wajib diunggah (Format PDF).',
            'members.*.file_identity.mimes' => 'Kartu identitas anggota tim harus berformat PDF atau gambar (JPG/PNG).',
            'members.*.file_cv.mimes' => 'Berkas CV anggota tim harus berformat PDF.',
            'members.*.file_transcript.mimes' => 'Transkrip Nilai anggota tim harus berformat PDF.',
            'members.*.file_identity.max' => 'Ukuran berkas identitas anggota tim maksimal 3MB.',
            'members.*.file_cv.max' => 'Ukuran berkas CV anggota tim maksimal 3MB.',
            'members.*.file_transcript.max' => 'Ukuran berkas transkrip nilai anggota tim maksimal 3MB.',
        ]);

        // Default application_type
        if (empty($validated['application_type'])) {
            $validated['application_type'] = ! empty($request->input('members')) ? 'group' : 'individual';
        }

        // Process 'Lainnya' if submitted
        if (($validated['track'] ?? '') === 'Lainnya' && ! empty($request->input('track_other'))) {
            $validated['track'] = trim($request->input('track_other'));
        }
        if (($validated['major'] ?? '') === 'Lainnya' && ! empty($request->input('major_other'))) {
            $validated['major'] = trim($request->input('major_other'));
        }

        // Auto calculate duration and start_period from start_date & end_date
        if (! empty($validated['start_date']) && ! empty($validated['end_date'])) {
            $start = Carbon::parse($validated['start_date']);
            $end = Carbon::parse($validated['end_date']);
            $diffMonths = round($start->diffInMonths($end));
            $diffDays = $start->diffInDays($end);

            if (empty($validated['duration'])) {
                $validated['duration'] = $diffMonths > 0 ? "{$diffMonths} Bulan" : "{$diffDays} Hari";
            }
            if (empty($validated['start_period'])) {
                $validated['start_period'] = $start->format('Y-m');
            }
        } elseif (! empty($validated['start_date']) && empty($validated['start_period'])) {
            $validated['start_period'] = Carbon::parse($validated['start_date'])->format('Y-m');
        }

        $files = [
            'file_identity' => $request->file('file_identity'),
            'file_recommendation' => $request->file('file_recommendation'),
            'file_cv' => $request->file('file_cv'),
            'file_transcript' => $request->file('file_transcript'),
        ];

        // Process members and their files
        $membersData = $request->input('members', []);
        $membersFiles = [];

        if ($request->hasFile('members')) {
            $membersFiles = $request->file('members');
        }

        $application = $this->service->registerApplication($validated, $files, $membersData, $membersFiles);

        $regCode = $application->registration_code;

        return response()->json([
            'success' => true,
            'registration_code' => $regCode,
            'application' => [
                'id' => $application->id,
                'name' => $application->name,
                'type' => $application->type,
                'type_label' => $application->type_label,
                'application_type' => $application->application_type,
                'is_group' => $application->is_group,
                'team_count' => $application->all_members->count(),
                'institution' => $application->institution,
                'start_period' => $application->start_period,
                'status' => $application->status,
                'status_label' => $application->status_label,
            ],
            'message' => 'Pendaftaran berhasil dikirim! Simpan Nomor Registrasi Anda: ' . $regCode,
        ]);
    }

    /**
     * Handle tracking application status via AJAX.
     */
    public function track(Request $request): JsonResponse
    {
        $query = $request->query('query', '');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan Nomor Registrasi, NIM/NISN, No. WhatsApp, atau Email.',
            ], 422);
        }

        $app = $this->service->trackApplication($query);

        if (! $app) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran magang dengan kata kunci "' . htmlspecialchars($query) . '" tidak ditemukan.',
            ], 404);
        }

        $regCode = $app->registration_code;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $app->id,
                'registration_code' => $regCode,
                'name' => $app->name,
                'type' => $app->type,
                'type_label' => $app->type_label,
                'application_type' => $app->application_type,
                'is_group' => $app->is_group,
                'team_count' => $app->all_members->count(),
                'institution' => $app->institution,
                'major' => $app->major,
                'grade_level' => $app->grade_level,
                'duration' => $app->duration,
                'start_period' => $app->start_period,
                'period_formatted' => $app->period_formatted,
                'track' => $app->track,
                'status' => $app->status,
                'status_label' => $app->status_label,
                'status_badge_class' => $app->status_badge_class,
                'notes' => $app->notes,
                'letter_download_url' => $app->status === 'accepted' ? route('internship.letter', $regCode) : null,
                'members' => $app->all_members->map(fn ($m) => [
                    'name' => $m->name,
                    'identity_number' => $m->identity_number,
                    'is_leader' => (bool) $m->is_leader,
                ]),
                'created_at' => $app->created_at?->translatedFormat('d F Y H:i'),
            ],
        ]);
    }

    /**
     * Download the official Letter of Acceptance (LoA) PDF for accepted participant.
     */
    public function downloadLetter(string $code): Response
    {
        $app = $this->service->trackApplication($code);

        if (! $app || $app->status !== 'accepted') {
            abort(404, 'Surat Balasan Penerimaan belum tersedia atau permohonan belum disetujui.');
        }

        $pdf = $this->service->generateAcceptancePdf($app);
        $filename = 'Surat_Balasan_Permohonan_Magang_' . Str::slug($app->name) . '.pdf';

        return $pdf->download($filename);
    }
}
