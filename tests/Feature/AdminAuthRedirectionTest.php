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
}
