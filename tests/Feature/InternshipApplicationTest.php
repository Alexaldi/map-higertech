<?php

namespace Tests\Feature;

use App\Models\InternshipApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InternshipApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_internship_page_renders_with_both_modals_and_datalists(): void
    {
        $response = $this->get('/internship');

        $response->assertOk()
            ->assertSee('id="modal-daftar-smk"', false)
            ->assertSee('id="modal-daftar-mahasiswa"', false)
            ->assertSee('id="modal-sukses-daftar"', false)
            ->assertSee('id="smk-schools-list"', false)
            ->assertSee('id="univ-schools-list"', false)
            ->assertSee('id="univ-majors-list"', false)
            ->assertSee('SMKN 1 Cimahi')
            ->assertSee('Institut Teknologi Bandung (ITB)');
    }

    public function test_vocational_smk_application_can_be_submitted_successfully(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'vocational',
            'name' => 'Budi Pratama',
            'email' => 'budi.pratama@smkn1cimahi.sch.id',
            'identity_number' => '0061234567',
            'institution' => 'SMKN 1 Cimahi (Teknologi & Industri)',
            'grade_level' => 'Kelas XI (Semester 3 / 4)',
            'phone' => '081234567890',
            'duration' => '6 Bulan',
            'start_period' => '2026-01',
            'track' => 'Perakitan & Soldering Hardware IoT',
            'file_identity' => UploadedFile::fake()->create('ktp_budi.pdf', 500, 'application/pdf'),
            'file_recommendation' => UploadedFile::fake()->create('surat_sekolah.pdf', 800, 'application/pdf'),
            'file_cv' => UploadedFile::fake()->create('cv_budi.pdf', 600, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('rapor_budi.pdf', 700, 'application/pdf'),
        ];

        $response = $this->postJson('/internship/apply', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath('application.type', 'vocational')
            ->assertJsonPath('application.name', 'Budi Pratama')
            ->assertJsonPath('application.status', 'pending');

        $app = InternshipApplication::where('identity_number', '0061234567')->first();
        $this->assertNotNull($app);
        $this->assertEquals('vocational', $app->type);
        $this->assertEquals('SMK / MAK', $app->type_label);
        $this->assertNull($app->major);
        $this->assertStringStartsWith('INT-SMK', $response->json('registration_code'));

        $this->assertNotNull($app->file_identity);
        Storage::disk('local')->assertExists($app->file_identity);
    }

    public function test_university_student_application_can_be_submitted_successfully(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'university',
            'name' => 'Farhan Aditama',
            'email' => 'farhan@itb.ac.id',
            'identity_number' => '13221001',
            'institution' => 'Institut Teknologi Bandung (ITB)',
            'major' => 'S1 / D4 Teknik Elektro',
            'grade_level' => 'Semester 5 (Tingkat 3)',
            'phone' => '085712345678',
            'duration' => '6 Bulan (MBKM / Magang Bersertifikat)',
            'start_period' => '2026-02',
            'track' => 'IoT Embedded Firmware Engineer (C/C++, FreeRTOS, MODBUS)',
            'file_identity' => UploadedFile::fake()->create('ktm_farhan.jpg', 300, 'image/jpeg'),
            'file_recommendation' => UploadedFile::fake()->create('surat_mbkm.pdf', 900, 'application/pdf'),
            'file_cv' => UploadedFile::fake()->create('cv_farhan.pdf', 750, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('transkrip_farhan.pdf', 850, 'application/pdf'),
        ];

        $response = $this->postJson('/internship/apply', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath('application.type', 'university')
            ->assertJsonPath('application.name', 'Farhan Aditama');

        $app = InternshipApplication::where('identity_number', '13221001')->first();
        $this->assertNotNull($app);
        $this->assertEquals('university', $app->type);
        $this->assertStringStartsWith('INT-UNV', $response->json('registration_code'));
    }

    public function test_validation_fails_when_required_fields_are_missing(): void
    {
        $response = $this->postJson('/internship/apply', [
            'type' => 'vocational',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'identity_number', 'institution', 'phone', 'file_identity', 'file_transcript']);
    }

    public function test_application_can_be_submitted_without_recommendation_letter(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'vocational',
            'name' => 'Siswa Mandiri',
            'email' => 'mandiri@smk.sch.id',
            'identity_number' => '0098765432',
            'institution' => 'SMKN 1 Cimahi (Teknologi & Industri)',
            'grade_level' => 'Kelas XI',
            'phone' => '081234567899',
            'file_identity' => UploadedFile::fake()->create('ktp.pdf', 200, 'application/pdf'),
            // file_recommendation omitted intentionally (can be submitted later)
            'file_transcript' => UploadedFile::fake()->create('rapor.pdf', 200, 'application/pdf'),
        ];

        $response = $this->postJson('/internship/apply', $payload);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $app = InternshipApplication::where('identity_number', '0098765432')->first();
        $this->assertNotNull($app);
        $this->assertNull($app->file_recommendation);
    }

    public function test_application_is_rejected_when_internship_is_disabled(): void
    {
        \App\Models\SiteSetting::updateOrCreate(
            ['key' => 'internship_enabled'],
            ['value' => '0', 'group' => 'internship', 'type' => 'boolean']
        );

        $response = $this->postJson('/internship/apply', [
            'type' => 'vocational',
            'name' => 'Calon Peserta',
            'identity_number' => '12345678',
            'institution' => 'SMKN 1 Cimahi',
            'grade_level' => 'Kelas XI',
            'phone' => '081234567890',
            'file_identity' => UploadedFile::fake()->create('ktp.pdf', 200, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('rapor.pdf', 200, 'application/pdf'),
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_application_can_be_tracked_by_id_or_identity_number(): void
    {
        $app = InternshipApplication::create([
            'type' => 'vocational',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@smk.sch.id',
            'identity_number' => '0078901234',
            'institution' => 'SMKN 4 Bandung',
            'major' => 'Teknik Komputer dan Jaringan',
            'grade_level' => 'Kelas XI',
            'phone' => '082199887766',
            'duration' => '3 Bulan',
            'start_period' => '2026-03',
            'track' => 'IT Support',
            'status' => 'accepted',
        ]);

        // Track by registration code
        $response = $this->getJson('/internship/track?query=' . $app->registration_code);
        $response->assertOk()
            ->assertJsonPath('data.registration_code', $app->registration_code)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Siti Nurhaliza')
            ->assertJsonPath('data.status', 'accepted')
            ->assertJsonPath('data.status_label', 'Diterima (ACC)');

        // Track by NISN
        $trackByNisn = $this->getJson("/internship/track?query=0078901234");
        $trackByNisn->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.registration_code', $app->registration_code);

        // Track with non-existent query
        $notFound = $this->getJson("/internship/track?query=UNKNOWN_ID");
        $notFound->assertStatus(404)
            ->assertJsonPath('success', false);
    }

    public function test_smk_application_with_custom_institution_other_can_be_submitted_successfully(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'vocational',
            'name' => 'Rangga Wijaya',
            'identity_number' => '0099887766',
            'institution_select' => 'Lainnya',
            'institution_other' => 'SMK Mitra Industri MM2100 Cikarang',
            'grade_level' => 'Kelas XI',
            'phone' => '081299887711',
            'track' => 'Perakitan Hardware',
            'file_identity' => UploadedFile::fake()->create('ktp.pdf', 200, 'application/pdf'),
            'file_recommendation' => UploadedFile::fake()->create('surat.pdf', 200, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('rapor.pdf', 200, 'application/pdf'),
        ];

        $response = $this->postJson('/internship/apply', $payload);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $app = InternshipApplication::where('identity_number', '0099887766')->first();
        $this->assertNotNull($app);
        $this->assertEquals('SMK Mitra Industri MM2100 Cikarang', $app->institution);
    }

    public function test_university_application_with_custom_institution_other_can_be_submitted_successfully(): void
    {
        Storage::fake('local');

        $payload = [
            'type' => 'university',
            'name' => 'Luthfi Hakim',
            'identity_number' => '2201099',
            'institution_select' => 'Lainnya',
            'institution_other' => 'Universitas Jenderal Soedirman (UNSOED)',
            'major' => 'S1 / D4 Teknik Elektro',
            'grade_level' => 'Semester 6',
            'phone' => '082211998844',
            'track' => 'IoT Embedded Firmware Engineer',
            'file_identity' => UploadedFile::fake()->create('ktm.pdf', 200, 'application/pdf'),
            'file_recommendation' => UploadedFile::fake()->create('surat.pdf', 200, 'application/pdf'),
            'file_transcript' => UploadedFile::fake()->create('transkrip.pdf', 200, 'application/pdf'),
        ];

        $response = $this->postJson('/internship/apply', $payload);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $app = InternshipApplication::where('identity_number', '2201099')->first();
        $this->assertNotNull($app);
        $this->assertEquals('Universitas Jenderal Soedirman (UNSOED)', $app->institution);
    }
}

