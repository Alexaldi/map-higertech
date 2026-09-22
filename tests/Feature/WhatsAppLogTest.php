<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WhatsAppLog;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WhatsAppLogTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin WhatsApp',
            'email' => 'admin-wa@higertech.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_guest_cannot_access_whatsapp_logs_page(): void
    {
        $response = $this->get(route('admin.whatsapp-logs.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_whatsapp_logs_page(): void
    {
        $user = $this->createAdmin();
        WhatsAppLog::create([
            'phone' => '087751945841',
            'type' => 'text',
            'message' => 'Halo Admin, ini pesan uji coba.',
            'status' => 'success',
            'sent_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.whatsapp-logs.index'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat Pengiriman WhatsApp');
        $response->assertSee('087751945841');
        $response->assertSee('Halo Admin, ini pesan uji coba.');
    }

    public function test_whatsapp_service_automatically_creates_log_on_send_message(): void
    {
        Http::fake([
            '*/send/message' => Http::response(['success' => true], 200),
        ]);

        $service = app(WhatsAppService::class);
        $sent = $service->sendMessage('08123456789', 'Halo pesan uji coba');

        $this->assertTrue($sent);
        $this->assertDatabaseHas('whatsapp_logs', [
            'phone' => '628123456789',
            'type' => 'text',
            'message' => 'Halo pesan uji coba',
            'status' => 'success',
        ]);
    }

    public function test_admin_can_delete_single_whatsapp_log(): void
    {
        $user = $this->createAdmin();
        $log = WhatsAppLog::create([
            'phone' => '087751945841',
            'type' => 'text',
            'message' => 'Pesan untuk dihapus',
            'status' => 'success',
            'sent_at' => now(),
        ]);

        $response = $this->actingAs($user)->delete(route('admin.whatsapp-logs.destroy', $log->id));

        $response->assertRedirect(route('admin.whatsapp-logs.index'));
        $this->assertDatabaseMissing('whatsapp_logs', ['id' => $log->id]);
    }

    public function test_admin_can_clear_all_whatsapp_logs(): void
    {
        $user = $this->createAdmin();
        WhatsAppLog::create([
            'phone' => '087751945841',
            'type' => 'text',
            'message' => 'Log 1',
            'status' => 'success',
            'sent_at' => now(),
        ]);
        WhatsAppLog::create([
            'phone' => '087751945842',
            'type' => 'text',
            'message' => 'Log 2',
            'status' => 'failed',
            'sent_at' => now(),
        ]);

        $response = $this->actingAs($user)->delete(route('admin.whatsapp-logs.clear'));

        $response->assertRedirect(route('admin.whatsapp-logs.index'));
        $this->assertEquals(0, WhatsAppLog::count());
    }
}
