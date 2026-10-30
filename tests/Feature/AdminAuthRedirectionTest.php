<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthRedirectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_accessing_admin_dashboard_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_accessing_login_page_is_redirected_to_admin_dashboard(): void
    {
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admintest@higertech.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_login_throttling_redirects_back_with_error_for_web_requests(): void
    {
        // Kirim 5 percobaan gagal
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email'    => 'admin@higertech.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Percobaan ke-6 harus di-throttle: redirect kembali ke /login dengan error (bukan JSON)
        $response = $this->post('/login', [
            'email'    => 'admin@higertech.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('login');
        $response->assertSessionHas('_old_input.email', 'admin@higertech.com');
    }

    public function test_login_throttling_returns_json_for_api_requests(): void
    {
        // Kirim 5 percobaan gagal via JSON
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/login', [
                'email'    => 'api@higertech.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Percobaan ke-6 harus return 429 JSON
        $response = $this->postJson('/login', [
            'email'    => 'api@higertech.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_guest_accessing_admin_root_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_accessing_admin_root_is_redirected_to_dashboard(): void
    {
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admintest@higertech.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_custom_404_page_renders_with_zanex_template(): void
    {
        $response = $this->get('/halaman-ini-pasti-tidak-ada-xyz-123');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Higertech Karya Sinergi');
    }
}
