<?php

namespace Tests\Feature;

use App\Models\InternshipApplication;
use App\Models\User;
use App\Services\Notification\WahaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminInternshipApplicationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Magang',
            'email' => 'admin-magang@higertech.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_guest_cannot_access_admin_internships(): void
    {
        $response = $this->get('/admin/internships');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_internship_management_dashboard_with_stats(): void
    {
        InternshipApplication::create([
            'type' => 'university',
            'name' => 'Aditia Rahman',
            'email' => 'aditia@kampus.ac.id',
            'identity_number' => '12345678',
            'institution' => 'Universitas Indonesia',
            'major' => 'Teknik Elektro',
            'grade_level' => 'Semester 6',
            'phone' => '081234567890',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
            'duration' => '6 Bulan',
            'start_period' => '2026-07',
            'track' => 'IoT Embedded Firmware Engineer',
            'status' => 'pending',
        ]);

        InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Dina Pratiwi',
            'email' => 'dina@smk.sch.id',
            'identity_number' => '00987654',
            'institution' => 'SMKN 1 Cimahi',
            'grade_level' => 'Kelas XI',
            'phone' => '089876543210',
            'start_date' => '2026-08-01',
            'end_date' => '2026-10-31',
            'duration' => '3 Bulan',
            'start_period' => '2026-08',
            'track' => 'Perakitan & Soldering Hardware IoT',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/internships');

        $response->assertOk()
            ->assertSee('Manajemen Pendaftaran Magang')
            ->assertSee('Aditia Rahman')
            ->assertSee('Dina Pratiwi')
            ->assertSee('Universitas Indonesia')
            ->assertSee('SMKN 1 Cimahi')
            ->assertSee('Total Pendaftar')
            ->assertSee('Siswa SMK');
    }

    public function test_admin_can_filter_by_type(): void
    {
        InternshipApplication::create([
            'type' => 'university',
            'name' => 'Farhan Univ',
            'email' => 'farhan@univ.ac.id',
            'identity_number' => '111111',
            'institution' => 'Institut Teknologi Bandung',
            'grade_level' => 'Semester 5',
            'phone' => '0811111111',
            'start_date' => '2026-07-01',
            'end_date' => '2026-10-01',
            'duration' => '3 Bulan',
            'track' => 'Web SCADA',
            'status' => 'pending',
        ]);

        InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Gita SMK',
            'email' => 'gita@smk.sch.id',
            'identity_number' => '222222',
            'institution' => 'SMKN 4 Bandung',
            'grade_level' => 'Kelas XI',
            'phone' => '0822222222',
            'start_date' => '2026-08-01',
            'end_date' => '2026-11-01',
            'duration' => '3 Bulan',
            'track' => 'Soldering',
            'status' => 'pending',
        ]);

        // Filter for vocational only
        $response = $this->actingAs($this->admin)->get('/admin/internships?type=vocational');

        $response->assertOk()
            ->assertSee('Gita SMK')
            ->assertDontSee('Farhan Univ');

        // Filter for university only
        $responseUniv = $this->actingAs($this->admin)->get('/admin/internships?type=university');

        $responseUniv->assertOk()
            ->assertSee('Farhan Univ')
            ->assertDontSee('Gita SMK');
    }

    public function test_admin_can_filter_by_status(): void
    {
        InternshipApplication::create([
            'type' => 'university',
            'name' => 'Budi Pending',
            'email' => 'budi@test.com',
            'identity_number' => '333333',
            'institution' => 'Telkom University',
            'grade_level' => 'Semester 7',
            'phone' => '0833333333',
            'duration' => '3 Bulan',
            'track' => 'Web SCADA',
            'status' => 'pending',
        ]);

        InternshipApplication::create([
            'type' => 'university',
            'name' => 'Siti Accepted',
            'email' => 'siti@test.com',
            'identity_number' => '444444',
            'institution' => 'Universitas Padjadjaran',
            'grade_level' => 'Semester 5',
            'phone' => '0844444444',
            'duration' => '3 Bulan',
            'track' => 'Hydrology',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/internships?status=accepted');

        $response->assertOk()
            ->assertSee('Siti Accepted')
            ->assertDontSee('Budi Pending');
    }

    public function test_admin_can_search_by_keyword(): void
    {
        InternshipApplication::create([
            'type' => 'university',
            'name' => 'Zaky Mubarok',
            'email' => 'zaky@test.com',
            'identity_number' => '555555',
            'institution' => 'Politeknik Negeri Bandung (POLBAN)',
            'grade_level' => 'Semester 6',
            'phone' => '0855555555',
            'duration' => '6 Bulan',
            'track' => 'Hardware IoT',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/internships?search=POLBAN');

        $response->assertOk()
            ->assertSee('Zaky Mubarok')
            ->assertSee('Politeknik Negeri Bandung (POLBAN)');
    }

    public function test_admin_can_update_status_to_accepted_with_notes(): void
    {
        $app = InternshipApplication::create([
            'type' => 'university',
            'name' => 'Kurniawan Pratama',
            'email' => 'kurnia@test.com',
            'identity_number' => '666666',
            'institution' => 'Universitas Gadjah Mada',
            'grade_level' => 'Semester 6',
            'phone' => '08123456789',
            'duration' => '6 Bulan',
            'track' => 'IoT Embedded Firmware Engineer',
            'status' => 'pending',
        ]);

        $payload = [
            'status' => 'accepted',
            'notes' => 'Selamat, Anda diterima di R&D Telemetry Lab Bandung Divisi Firmware mulai 1 Oktober 2026.',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/internships/{$app->id}", $payload);

        $response->assertRedirect('/admin/internships')
            ->assertSessionHas('success');

        $app->refresh();
        $this->assertEquals('accepted', $app->status);
        $this->assertEquals('Selamat, Anda diterima di R&D Telemetry Lab Bandung Divisi Firmware mulai 1 Oktober 2026.', $app->notes);
        $this->assertNotNull($app->notified_at);
    }

    public function test_admin_can_update_status_to_rejected_with_notes(): void
    {
        $app = InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Rian Hidayat',
            'email' => 'rian@smk.sch.id',
            'identity_number' => '777777',
            'institution' => 'SMKN 2 Bandung',
            'grade_level' => 'Kelas XII',
            'phone' => '0877777777',
            'duration' => '3 Bulan',
            'track' => 'Perakitan Hardware',
            'status' => 'pending',
        ]);

        $payload = [
            'status' => 'rejected',
            'notes' => 'Mohon maaf kuota perakitan hardware telah terpenuhi.',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/internships/{$app->id}", $payload);

        $response->assertRedirect('/admin/internships')
            ->assertSessionHas('success');

        $app->refresh();
        $this->assertEquals('rejected', $app->status);
        $this->assertEquals('Mohon maaf kuota perakitan hardware telah terpenuhi.', $app->notes);
    }

    public function test_admin_can_show_application_json(): void
    {
        $app = InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Maya Kartika',
            'email' => 'maya@smk.sch.id',
            'identity_number' => '888888',
            'institution' => 'SMKN 1 Katapang',
            'grade_level' => 'Kelas XI',
            'phone' => '0888888888',
            'duration' => '3 Bulan',
            'track' => 'Perakitan Hardware',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->getJson("/admin/internships/{$app->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'application' => [
                    'id' => $app->id,
                    'name' => 'Maya Kartika',
                    'type' => 'vocational',
                    'type_label' => 'SMK / MAK',
                ],
            ]);
    }

    public function test_admin_can_delete_application_and_its_files(): void
    {
        Storage::fake('public');

        $filePath = UploadedFile::fake()->create('ktm_dummy.pdf', 100, 'application/pdf')
            ->store('internships/university/2026', 'public');

        $app = InternshipApplication::create([
            'type' => 'university',
            'name' => 'Hapus Target',
            'email' => 'hapus@test.com',
            'identity_number' => '999999',
            'institution' => 'Target Univ',
            'grade_level' => 'Semester 8',
            'phone' => '0899999999',
            'duration' => '3 Bulan',
            'track' => 'Web SCADA',
            'file_identity' => $filePath,
            'status' => 'pending',
        ]);

        Storage::disk('public')->assertExists($filePath);

        $response = $this->actingAs($this->admin)->delete("/admin/internships/{$app->id}");

        $response->assertRedirect('/admin/internships')
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('internship_applications', ['id' => $app->id]);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function test_admin_can_delete_application_via_ajax_json(): void
    {
        $app = InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Target Ajax Delete',
            'email' => 'ajaxdel@smk.sch.id',
            'identity_number' => '777888',
            'institution' => 'SMKN 1 Cimahi',
            'grade_level' => 'Kelas XI',
            'phone' => '0877788899',
            'duration' => '3 Bulan',
            'track' => 'Perakitan Hardware',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson("/admin/internships/{$app->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Berkas pendaftaran magang atas nama Target Ajax Delete berhasil dihapus.',
            ]);

        $this->assertDatabaseMissing('internship_applications', ['id' => $app->id]);
    }
}
