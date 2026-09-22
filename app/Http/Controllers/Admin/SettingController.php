<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SiteSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly SiteSettingService $settingService) {}

    public function index(): View
    {
        $settings = $this->settingService->all();
        $socialLinks = setting_social_links();
        $availablePlatforms = social_platforms();

        return view('admin.settings.index', compact('settings', 'socialLinks', 'availablePlatforms'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'contact_whatsapp_message' => ['nullable', 'string', 'max:500'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'footer_about' => ['nullable', 'string', 'max:1000'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['nullable', 'string', 'max:50'],
            'social_links.*.label' => ['nullable', 'string', 'max:100'],
            'social_links.*.url' => ['nullable', 'url', 'max:255'],
            'social_whatsapp' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'internship_enabled' => ['nullable', 'in:0,1'],
            'internship_wa_notification' => ['nullable', 'string', 'max:50'],
            'internship_closed_message' => ['nullable', 'string', 'max:1000'],
            'internship_tracks_smk' => ['nullable', 'string', 'max:2000'],
            'internship_tracks_univ' => ['nullable', 'string', 'max:2000'],
        ], [
            'contact_email.required' => 'Email kontak wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
            'social_links.*.url.url' => 'Format URL media sosial tidak valid.',
        ]);

        if ($request->has('internship_enabled')) {
            $validated['internship_enabled'] = $request->input('internship_enabled') === '1' ? '1' : '0';
        }

        if ($request->has('social_links')) {
            $cleaned = [];
            foreach ($request->input('social_links', []) as $row) {
                if (! empty($row['url'])) {
                    $plat = $row['platform'] ?? 'globe';
                    $cleaned[] = [
                        'platform' => $plat,
                        'label' => $row['label'] ?? '',
                        'url' => $row['url'],
                    ];

                    if ($plat === 'whatsapp') {
                        $validated['social_whatsapp'] = $row['url'];
                    }
                    if ($plat === 'instagram') {
                        $validated['social_instagram'] = $row['url'];
                    }
                    if ($plat === 'linkedin') {
                        $validated['social_linkedin'] = $row['url'];
                    }
                    if ($plat === 'youtube') {
                        $validated['social_youtube'] = $row['url'];
                    }
                }
            }
            $validated['social_links'] = json_encode($cleaned);
        } elseif (! empty($validated['social_whatsapp']) || ! empty($validated['social_instagram'])) {
            // Build social_links from legacy single fields if submitted directly
            $legacyLinks = [];
            if (! empty($validated['social_whatsapp'])) {
                $legacyLinks[] = ['platform' => 'whatsapp', 'label' => 'WhatsApp', 'url' => $validated['social_whatsapp']];
            }
            if (! empty($validated['social_instagram'])) {
                $legacyLinks[] = ['platform' => 'instagram', 'label' => 'Instagram', 'url' => $validated['social_instagram']];
            }
            if (! empty($validated['social_linkedin'])) {
                $legacyLinks[] = ['platform' => 'linkedin', 'label' => 'LinkedIn', 'url' => $validated['social_linkedin']];
            }
            if (! empty($validated['social_youtube'])) {
                $legacyLinks[] = ['platform' => 'youtube', 'label' => 'YouTube', 'url' => $validated['social_youtube']];
            }
            $validated['social_links'] = json_encode($legacyLinks);
        }

        $this->settingService->updateSettings($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
