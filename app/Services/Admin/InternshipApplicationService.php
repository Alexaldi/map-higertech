<?php

namespace App\Services\Admin;

use App\Models\InternshipApplication;
use App\Models\InternshipMember;
use App\Repositories\Admin\InternshipApplicationRepository;
use App\Services\Notification\WahaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfWrapper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InternshipApplicationService
{
    public function __construct(
        private readonly InternshipApplicationRepository $repository,
        private readonly WahaService $wahaService
    ) {}

    /**
     * @param array<string, mixed> $filters
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getPaginated($filters, $perPage);
    }

    public function findById(int $id): ?InternshipApplication
    {
        return $this->repository->findById($id);
    }

    /**
     * Process new application registration from public form (Individual or Group).
     *
     * @param array<string, mixed> $data
     * @param array<string, ?UploadedFile> $files
     * @param array<int, array<string, mixed>> $membersData
     * @param array<int, array<string, ?UploadedFile>> $membersFiles
     */
    public function registerApplication(
        array $data,
        array $files = [],
        array $membersData = [],
        array $membersFiles = []
    ): InternshipApplication {
        $type = $data['type'] ?? 'university';
        $year = date('Y');

        // Handle leader / general file uploads
        foreach (['file_identity', 'file_recommendation', 'file_cv', 'file_transcript'] as $field) {
            if (! empty($files[$field]) && $files[$field] instanceof UploadedFile) {
                $filename = Str::slug($data['name']) . '-' . Str::random(8) . '.' . $files[$field]->getClientOriginalExtension();
                $path = $files[$field]->storeAs("internships/{$type}/{$year}", $filename, 'public');
                $data[$field] = $path;
            }
        }

        $data['status'] = 'pending';
        $application = $this->repository->create($data);

        // Always register the leader in the members table
        $application->members()->create([
            'name' => $application->name,
            'identity_number' => $application->identity_number,
            'email' => $application->email,
            'phone' => $application->phone,
            'is_leader' => true,
            'file_identity' => $application->file_identity,
            'file_cv' => $application->file_cv,
            'file_transcript' => $application->file_transcript,
        ]);

        // Register additional team members if group application
        if (($data['application_type'] ?? '') === 'group' && ! empty($membersData)) {
            foreach ($membersData as $index => $member) {
                if (empty($member['name']) || empty($member['identity_number'])) {
                    continue;
                }

                $memFiles = $membersFiles[$index] ?? [];
                $memIdentity = null;
                $memCv = null;
                $memTranscript = null;

                if (! empty($memFiles['file_identity']) && $memFiles['file_identity'] instanceof UploadedFile) {
                    $filename = Str::slug($member['name']) . '-id-' . Str::random(8) . '.' . $memFiles['file_identity']->getClientOriginalExtension();
                    $memIdentity = $memFiles['file_identity']->storeAs("internships/{$type}/{$year}", $filename, 'public');
                }

                if (! empty($memFiles['file_cv']) && $memFiles['file_cv'] instanceof UploadedFile) {
                    $filename = Str::slug($member['name']) . '-cv-' . Str::random(8) . '.' . $memFiles['file_cv']->getClientOriginalExtension();
                    $memCv = $memFiles['file_cv']->storeAs("internships/{$type}/{$year}", $filename, 'public');
                }

                if (! empty($memFiles['file_transcript']) && $memFiles['file_transcript'] instanceof UploadedFile) {
                    $filename = Str::slug($member['name']) . '-trans-' . Str::random(8) . '.' . $memFiles['file_transcript']->getClientOriginalExtension();
                    $memTranscript = $memFiles['file_transcript']->storeAs("internships/{$type}/{$year}", $filename, 'public');
                }

                $application->members()->create([
                    'name' => trim($member['name']),
                    'identity_number' => trim($member['identity_number']),
                    'email' => $member['email'] ?? null,
                    'phone' => $member['phone'] ?? null,
                    'is_leader' => false,
                    'file_identity' => $memIdentity,
                    'file_cv' => $memCv,
                    'file_transcript' => $memTranscript,
                ]);
            }
        }

        // Try triggering supervisor WhatsApp notification
        $this->notifySupervisorNewApplication($application);

        return $application;
    }

    /**
     * Generate official Letter of Acceptance (LoA) PDF based on PT Higertech template.
     */
    public function generateAcceptancePdf(InternshipApplication $application): DomPdfWrapper
    {
        $logoPath = public_path('images/brand/higertech-logo.png');
        $brandIconPath = public_path('images/brand/logo.png');

        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $brandIconBase64 = file_exists($brandIconPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($brandIconPath))
            : null;

        // Auto-assign acceptance date if not set
        if (! $application->acceptance_date) {
            $application->acceptance_date = now();
        }

        return Pdf::loadView('pdf.internship-acceptance', [
            'application' => $application,
            'logoBase64' => $logoBase64,
            'brandIconBase64' => $brandIconBase64,
        ])->setPaper('a4', 'portrait');
    }

    /**
     * Track application by registration code, identity number, phone or email.
     */
    public function trackApplication(string $query): ?InternshipApplication
    {
        $cleanQuery = trim($query);

        // If format is HGT-SMK-1234 or HGT-RND-1234 or INT-UNV26-0001
        if (preg_match('/(?:(?:HGT-(?:SMK|RND)-)|(?:INT-(?:SMK|UNV)\d{2}-))?(\d+)/i', $cleanQuery, $matches)) {
            $id = (int) $matches[1];
            $app = $this->repository->findById($id);
            if ($app) {
                return $app;
            }
        }

        // Search in members table by identity number (NIM / NISN)
        $member = InternshipMember::where('identity_number', $cleanQuery)->first();
        if ($member && $member->application) {
            return $member->application;
        }

        // Search by identity number (NIM / NISN / NIK) on application
        $app = $this->repository->findByIdentityNumber($cleanQuery);
        if ($app) {
            return $app;
        }

        // Search by phone or email
        return $this->repository->findByPhoneOrEmail($cleanQuery);
    }

    /**
     * Update review status, acceptance number, notes, dates, and letter details.
     */
    public function updateStatus(
        InternshipApplication $application,
        string $status,
        ?string $notes = null,
        ?string $acceptanceNumber = null,
        ?string $acceptanceDate = null,
        array $extraAttributes = []
    ): bool {
        $data = [
            'status' => $status,
            'notes' => $notes,
        ];

        if (!empty($extraAttributes)) {
            $allowed = ['head_of_program', 'institution_address', 'reference_number', 'reference_date'];
            foreach ($allowed as $field) {
                if (array_key_exists($field, $extraAttributes)) {
                    $data[$field] = $extraAttributes[$field];
                }
            }
        }

        if ($status === 'accepted') {
            if ($acceptanceNumber) {
                $data['acceptance_number'] = $acceptanceNumber;
            } elseif (empty($application->acceptance_number)) {
                $data['acceptance_number'] = $application->acceptance_number_formatted;
            }

            if ($acceptanceDate) {
                $data['acceptance_date'] = $acceptanceDate;
            } elseif (empty($application->acceptance_date)) {
                $data['acceptance_date'] = now()->toDateString();
            }
        }

        $application->update($data);

        if (in_array($status, ['accepted', 'rejected'])) {
            $this->notifyApplicantStatusUpdate($application);
        }

        return true;
    }

    public function delete(InternshipApplication $application): bool
    {
        // Delete uploaded files of application
        foreach (['file_identity', 'file_recommendation', 'file_cv', 'file_transcript'] as $field) {
            if ($application->{$field} && Storage::disk('public')->exists($application->{$field})) {
                Storage::disk('public')->delete($application->{$field});
            }
        }

        // Delete uploaded files of members
        foreach ($application->members as $member) {
            foreach (['file_identity', 'file_cv', 'file_transcript'] as $field) {
                if ($member->{$field} && Storage::disk('public')->exists($member->{$field})) {
                    Storage::disk('public')->delete($member->{$field});
                }
            }
        }

        return $this->repository->delete($application);
    }

    /**
     * @return array<string, int>
     */
    public function getCounts(): array
    {
        return $this->repository->getCounts();
    }

    /**
     * Notify internship supervisor about new incoming registration.
     */
    private function notifySupervisorNewApplication(InternshipApplication $app): void
    {
        try {
            $this->wahaService->notifySupervisorNewSubmission($app);
        } catch (\Throwable $e) {
            Log::warning("Gagal mengirim notifikasi WhatsApp pembina: " . $e->getMessage());
        }
    }

    /**
     * Notify applicant on status update (accepted/rejected).
     */
    private function notifyApplicantStatusUpdate(InternshipApplication $app): void
    {
        try {
            $app->update(['notified_at' => now()]);
            $this->wahaService->notifyApplicantStatusUpdate($app);
        } catch (\Throwable $e) {
            Log::warning("Gagal mengirim notifikasi WhatsApp peserta: " . $e->getMessage());
        }
    }
}
