<?php

namespace Tests\Feature;

use App\Models\InternshipApplication;
use App\Models\User;
use App\Services\Admin\InternshipApplicationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InternshipTeamApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_group_internship_application_with_team_members(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'university',
            'application_type' => 'group',
            'name' => 'Rizky Faturohman',
            'identity_number' => '10123391',
            'institution' => 'Universitas Komputer Indonesia (UNIKOM)',
            'institution_address' => 'Jl. Dipati Ukur No.102-116 Bandung',
            'major' => 'Teknik Informatika',
            'head_of_program' => 'Ketua Program Studi Teknik Informatika',
            'grade_level' => 'Semester 6',
            'email' => 'rizky@gmail.com',
            'phone' => '081234567890',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(2)->format('Y-m-d'),
            'track' => 'Web SCADA & GIS Telemetry Developer',
            'reference_number' => '098/KP/KaProdi-FTIK-IFS1/UNIKOM/VII/2026',
            'file_identity' => UploadedFile::fake()->create('ktm_leader.pdf', 100, 'application/pdf'),
            'file_recommendation' => UploadedFile::fake()->create('surat_pengantar.pdf', 150, 'application/pdf'),
            'file_cv' => UploadedFile::fake()->create('cv_leader.pdf', 120, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('transkrip_leader.pdf', 130, 'application/pdf'),
            'members' => [
                [
                    'name' => 'Raditya Rizkullah Anwar',
                    'identity_number' => '10123395',
                    'email' => 'raditya@gmail.com',
                    'file_identity' => UploadedFile::fake()->create('ktm_raditya.pdf', 90, 'application/pdf'),
                    'file_cv' => UploadedFile::fake()->create('cv_raditya.pdf', 90, 'application/pdf'),
                    'file_transcript' => UploadedFile::fake()->create('transcript_raditya.pdf', 90, 'application/pdf'),
                ],
                [
                    'name' => 'Gilang Aldiano',
                    'identity_number' => '10123404',
                    'email' => 'gilang@gmail.com',
                    'file_identity' => UploadedFile::fake()->create('ktm_gilang.pdf', 95, 'application/pdf'),
                    'file_cv' => UploadedFile::fake()->create('cv_gilang.pdf', 95, 'application/pdf'),
                    'file_transcript' => UploadedFile::fake()->create('transcript_gilang.pdf', 95, 'application/pdf'),
                ],
            ],
        ];

        $response = $this->postJson(route('internship.apply'), $payload);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('application.is_group', true)
            ->assertJsonPath('application.team_count', 3);

        $this->assertDatabaseHas('internship_applications', [
            'name' => 'Rizky Faturohman',
            'application_type' => 'group',
            'institution' => 'Universitas Komputer Indonesia (UNIKOM)',
        ]);

        $app = InternshipApplication::first();
        $this->assertNotNull($app);
        $this->assertCount(3, $app->members);

        // Leader member
        $leader = $app->members()->where('is_leader', true)->first();
        $this->assertNotNull($leader);
        $this->assertEquals('Rizky Faturohman', $leader->name);
        $this->assertEquals('10123391', $leader->identity_number);

        // Team members
        $this->assertTrue($app->members()->where('identity_number', '10123395')->exists());
        $this->assertTrue($app->members()->where('identity_number', '10123404')->exists());
    }

    public function test_can_generate_and_download_official_acceptance_letter_pdf(): void
    {
        $app = InternshipApplication::create([
            'type' => 'university',
            'application_type' => 'group',
            'name' => 'Rizky Faturohman',
            'identity_number' => '10123391',
            'institution' => 'Universitas Komputer Indonesia (UNIKOM)',
            'institution_address' => 'Jl. Dipati Ukur No.102-116 Bandung',
            'major' => 'Teknik Informatika',
            'head_of_program' => 'Ketua Program Studi Teknik Informatika',
            'grade_level' => 'Semester 6',
            'email' => 'rizky@gmail.com',
            'phone' => '081234567890',
            'start_date' => '2026-08-10',
            'end_date' => '2026-09-30',
            'duration' => '2 Bulan',
            'track' => 'Web SCADA & GIS Telemetry Developer',
            'reference_number' => '098/KP/KaProdi-FTIK-IFS1/UNIKOM/VII/2026',
            'status' => 'accepted',
            'acceptance_number' => '394/SP.KP/HGT/VII/2026',
            'acceptance_date' => '2026-07-17',
        ]);

        // Add 3 members like in the real sample
        $app->members()->createMany([
            ['name' => 'Rizky Faturohman', 'identity_number' => '10123391', 'is_leader' => true],
            ['name' => 'Raditya Rizkullah Anwar', 'identity_number' => '10123395', 'is_leader' => false],
            ['name' => 'Gilang Aldiano', 'identity_number' => '10123404', 'is_leader' => false],
        ]);

        $service = app(InternshipApplicationService::class);
        $pdf = $service->generateAcceptancePdf($app);
        $rawPdf = $pdf->output();

        $this->assertNotEmpty($rawPdf);
        $this->assertStringStartsWith('%PDF', $rawPdf);

        // Test participant public download
        $regCode = $app->registration_code;
        $response = $this->get(route('internship.letter', $regCode));
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');

        // Test admin download
        $admin = User::create([
            'name' => 'Admin Magang',
            'email' => 'admin-magang@higertech.com',
            'password' => bcrypt('password123'),
        ]);
        $adminResponse = $this->actingAs($admin)->get(route('admin.internships.letter', $app));
        $adminResponse->assertOk();
        $adminResponse->assertHeader('content-type', 'application/pdf');
    }

    public function test_single_applicant_backward_compatibility(): void
    {
        // Existing application without rows in internship_members
        $app = InternshipApplication::create([
            'type' => 'vocational',
            'application_type' => 'individual',
            'name' => 'Budi Santoso',
            'identity_number' => '12345678',
            'institution' => 'SMKN 1 Cimahi',
            'grade_level' => 'Kelas XI',
            'phone' => '081234567890',
            'status' => 'accepted',
        ]);

        // all_members should synthesize leader
        $this->assertCount(1, $app->all_members);
        $this->assertEquals('Budi Santoso', $app->all_members->first()->name);

        $service = app(InternshipApplicationService::class);
        $pdf = $service->generateAcceptancePdf($app);
        $this->assertStringStartsWith('%PDF', $pdf->output());
    }

    public function test_admin_can_update_acceptance_letter_details(): void
    {
        $admin = User::create([
            'name' => 'Admin Magang 2',
            'email' => 'admin-magang2@higertech.com',
            'password' => bcrypt('password123'),
        ]);

        $app = InternshipApplication::create([
            'type' => 'university',
            'application_type' => 'group',
            'name' => 'Rizky Faturohman',
            'identity_number' => '10123391',
            'institution' => 'Universitas Komputer Indonesia',
            'grade_level' => 'Semester 6',
            'phone' => '081234567890',
            'status' => 'reviewing',
        ]);

        $updateData = [
            'status' => 'accepted',
            'acceptance_number' => '394/SP.KP/HGT/VII/2026',
            'acceptance_date' => '2026-07-17',
            'head_of_program' => 'Ketua Program Studi Teknik Informatika',
            'institution_address' => 'Jl. Dipati Ukur No. 112 Bandung',
            'reference_number' => '098/KP/UNIKOM/VII/2026',
            'reference_date' => '2026-07-10',
            'notes' => 'Orientasi dimulai tanggal 10 Agustus 2026.',
        ];

        $response = $this->actingAs($admin)->put(route('admin.internships.update', $app), $updateData);
        $response->assertRedirect(route('admin.internships.index'));

        $this->assertDatabaseHas('internship_applications', [
            'id' => $app->id,
            'status' => 'accepted',
            'acceptance_number' => '394/SP.KP/HGT/VII/2026',
            'head_of_program' => 'Ketua Program Studi Teknik Informatika',
        ]);
    }

    public function test_tracking_returns_team_members_and_letter_download_url(): void
    {
        $app = InternshipApplication::create([
            'type' => 'university',
            'application_type' => 'group',
            'name' => 'Rizky Faturohman',
            'identity_number' => '10123391',
            'institution' => 'UNIKOM',
            'grade_level' => 'Semester 6',
            'phone' => '081234567890',
            'status' => 'accepted',
            'acceptance_number' => '394/SP.KP/HGT/VII/2026',
        ]);

        $app->members()->createMany([
            ['name' => 'Rizky Faturohman', 'identity_number' => '10123391', 'is_leader' => true],
            ['name' => 'Raditya Rizkullah Anwar', 'identity_number' => '10123395', 'is_leader' => false],
        ]);

        $response = $this->getJson(route('internship.track', ['query' => '10123395']));
        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_group', true)
            ->assertJsonPath('data.team_count', 2)
            ->assertJsonPath('data.status', 'accepted')
            ->assertJsonPath('data.letter_download_url', route('internship.letter', $app->registration_code));
    }

    public function test_individual_application_with_stray_empty_members_succeeds_smoothly(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'vocational',
            'application_type' => 'individual',
            'name' => 'Fajar Individu',
            'identity_number' => '123456789',
            'institution' => 'SMKN 1 Katapang',
            'grade_level' => 'Kelas XI',
            'phone' => '081234567899',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
            'track' => 'Perakitan Alat Telemetri',
            'file_identity' => UploadedFile::fake()->create('ktp.pdf', 100, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('rapor.pdf', 100, 'application/pdf'),
            // Stray empty members from hidden DOM
            'members' => [
                [
                    'name' => '',
                    'identity_number' => '',
                ],
            ],
        ];

        $response = $this->postJson(route('internship.apply'), $payload);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('application.is_group', false)
            ->assertJsonPath('application.application_type', 'individual');

        $this->assertDatabaseHas('internship_applications', [
            'name' => 'Fajar Individu',
            'application_type' => 'individual',
        ]);
    }
}
