<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuickAccessButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_header_does_not_render_admin_dashboard_button_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee(route('admin.dashboard'));
        $response->assertDontSee('Dashboard Admin');
    }

    public function test_public_header_renders_admin_dashboard_button_for_authenticated_admin(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin-quick@higertech.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($admin)->get('/');

        $response->assertOk();
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee('Dashboard Admin');
    }
}
