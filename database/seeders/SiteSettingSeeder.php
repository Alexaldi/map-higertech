<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Contact
            [
                'key' => 'contact_email',
                'value' => 'higertechkaryasinergi@gmail.com',
                'group' => 'contact',
                'type' => 'email',
            ],
            [
                'key' => 'contact_phone',
                'value' => '022-2101-0299',
                'group' => 'contact',
                'type' => 'tel',
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '08112332182',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Bandung, Jawa Barat, Indonesia',
                'group' => 'contact',
                'type' => 'textarea',
            ],

            // Social Media
            [
                'key' => 'social_whatsapp',
                'value' => 'https://wa.me/628112332182',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com',
                'group' => 'social',
                'type' => 'url',
            ],

            // General & Footer
            [
                'key' => 'site_name',
                'value' => 'PT Higertech Karya Sinergi',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'footer_about',
                'value' => 'PT Higertech Karya Sinergi menghadirkan portofolio terdepan instrumentasi hidrologi, telemetri lingkungan, serta program inkubasi talenta muda di Indonesia.',
                'group' => 'general',
                'type' => 'textarea',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

