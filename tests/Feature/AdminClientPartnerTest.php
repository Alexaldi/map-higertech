<?php

namespace Tests\Feature;

use App\Models\ClientPartner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminClientPartnerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin-test@higertech.com',
            'password' => bcrypt('secret123'),
        ]);
    }

    public function test_guest_cannot_access_clients_admin(): void
    {
        $response = $this->get('/admin/clients');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_clients_index(): void
    {
        ClientPartner::create([
            'name' => 'BBWS Citarum',
            'sub' => 'Kementerian PUPR',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/clients');

        $response->assertOk()
            ->assertSee('BBWS Citarum')
            ->assertSee('Daftar Mitra');
    }

    public function test_admin_can_create_client_with_logo_upload(): void
    {
        Storage::fake('public');

        $logo = UploadedFile::fake()->image('citarum_logo.png', 200, 60);

        $response = $this->actingAs($this->admin)->post('/admin/clients', [
            'name' => 'BBWS Citarum',
            'sub' => 'Kementerian PUPR Ditjen SDA',
            'logo' => $logo,
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/clients');
        $this->assertDatabaseHas('client_partners', [
            'name' => 'BBWS Citarum',
            'sub' => 'Kementerian PUPR Ditjen SDA',
            'order' => 1,
            'is_active' => true,
        ]);

        $client = ClientPartner::where('name', 'BBWS Citarum')->firstOrFail();
        $this->assertNotNull($client->logo);
        Storage::disk('public')->assertExists($client->logo);
    }

    public function test_admin_can_update_client(): void
    {
        $client = ClientPartner::create([
            'name' => 'Old Partner Name',
            'sub' => 'Old Sub',
            'order' => 5,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/clients/{$client->id}", [
            'name' => 'New Partner Name',
            'sub' => 'New Sub',
            'order' => 2,
        ]);

        $response->assertRedirect('/admin/clients');
        $this->assertDatabaseHas('client_partners', [
            'id' => $client->id,
            'name' => 'New Partner Name',
            'sub' => 'New Sub',
            'order' => 2,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_client(): void
    {
        Storage::fake('public');
        $logo = UploadedFile::fake()->image('test_delete.png', 100, 40);
        $path = $logo->store('clients', 'public');

        $client = ClientPartner::create([
            'name' => 'Partner to Delete',
            'logo' => $path,
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/clients/{$client->id}");

        $response->assertRedirect('/admin/clients');
        $this->assertDatabaseMissing('client_partners', [
            'id' => $client->id,
        ]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_landing_page_renders_client_marquee(): void
    {
        ClientPartner::create([
            'name' => 'Balai Wilayah Sungai Bangka Belitung',
            'sub' => 'Kementerian PUPR',
            'logo' => 'images/clients/klien1.png',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('marquee-track-left', false)
            ->assertSee('marquee-track-right', false)
            ->assertSee('images/clients/klien1.png', false);
    }
}
