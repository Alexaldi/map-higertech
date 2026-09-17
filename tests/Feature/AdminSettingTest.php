<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin-setting-test@higertech.com',
            'password' => bcrypt('secret123'),
        ]);
    }

    public function test_guest_cannot_access_settings_admin(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_settings_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/settings');

        $response->assertOk()
            ->assertSee('Pengaturan Website');
    }

    public function test_admin_can_update_settings(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/settings', [
            'contact_email' => 'new-contact@higertech.com',
            'contact_phone' => '021-99887766',
            'contact_whatsapp' => '081299999999',
            'contact_address' => 'Jakarta, Indonesia',
            'social_whatsapp' => 'https://wa.me/6281299999999',
            'social_instagram' => 'https://instagram.com/higertech_official',
            'social_linkedin' => 'https://linkedin.com/company/higertech',
            'social_youtube' => 'https://youtube.com/@higertech',
            'site_name' => 'PT Higertech Karya Sinergi',
            'footer_about' => 'Deskripsi baru profil higertech.',
        ]);

        $response->assertRedirect('/admin/settings');

        $this->assertEquals('new-contact@higertech.com', setting('contact_email'));
        $this->assertEquals('021-99887766', setting('contact_phone'));
        $this->assertEquals('Deskripsi baru profil higertech.', setting('footer_about'));
    }

    public function test_admin_can_manage_dynamic_social_media_links(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/settings', [
            'contact_email' => 'contact@higertech.com',
            'contact_phone' => '022-2101-0299',
            'social_links' => [
                [
                    'platform' => 'tiktok',
                    'label' => 'TikTok Higertech',
                    'url' => 'https://tiktok.com/@higertech',
                ],
                [
                    'platform' => 'facebook',
                    'label' => 'Facebook Higertech',
                    'url' => 'https://facebook.com/higertech',
                ],
            ],
        ]);

        $response->assertRedirect('/admin/settings');

        $socialLinks = setting_social_links();
        $this->assertCount(2, $socialLinks);
        $this->assertEquals('tiktok', $socialLinks[0]['platform']);
        $this->assertEquals('https://tiktok.com/@higertech', $socialLinks[0]['url']);
        $this->assertEquals('facebook', $socialLinks[1]['platform']);

        // Check landing page footer renders these dynamic links
        $landing = $this->get('/');
        $landing->assertOk()
            ->assertSee('https://tiktok.com/@higertech')
            ->assertSee('https://facebook.com/higertech');
    }
}
