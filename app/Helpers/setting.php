<?php

use App\Services\Admin\SiteSettingService;

if (!function_exists('setting')) {
    /**
     * Get site setting value by key with optional fallback.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SiteSettingService::class)->get($key, $default);
    }
}

if (!function_exists('social_platforms')) {
    /**
     * Stock of available social media platforms and icons.
     *
     * @return array<string, array{name: string, color: string, placeholder: string, hover_class: string, icon: string}>
     */
    function social_platforms(): array
    {
        return [
            'whatsapp' => [
                'name' => 'WhatsApp',
                'color' => '#25D366',
                'placeholder' => 'https://wa.me/628112332182',
                'hover_class' => 'hover:bg-emerald-500 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #25D366;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
            ],
            'instagram' => [
                'name' => 'Instagram',
                'color' => '#E4405F',
                'placeholder' => 'https://instagram.com/higertech',
                'hover_class' => 'hover:bg-pink-600 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #E4405F;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
            ],
            'linkedin' => [
                'name' => 'LinkedIn',
                'color' => '#0A66C2',
                'placeholder' => 'https://linkedin.com/company/higertech',
                'hover_class' => 'hover:bg-blue-700 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #0A66C2;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
            ],
            'youtube' => [
                'name' => 'YouTube',
                'color' => '#FF0000',
                'placeholder' => 'https://youtube.com/@higertech',
                'hover_class' => 'hover:bg-red-600 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #FF0000;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/></svg>',
            ],
            'facebook' => [
                'name' => 'Facebook',
                'color' => '#1877F2',
                'placeholder' => 'https://facebook.com/higertech',
                'hover_class' => 'hover:bg-blue-600 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #1877F2;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
            ],
            'twitter' => [
                'name' => 'X / Twitter',
                'color' => '#111827',
                'placeholder' => 'https://x.com/higertech',
                'hover_class' => 'hover:bg-slate-900 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #111827;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4l11.733 16h4.267l-11.733 -16z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>',
            ],
            'tiktok' => [
                'name' => 'TikTok',
                'color' => '#000000',
                'placeholder' => 'https://tiktok.com/@higertech',
                'hover_class' => 'hover:bg-slate-950 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #000000;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>',
            ],
            'telegram' => [
                'name' => 'Telegram',
                'color' => '#229ED9',
                'placeholder' => 'https://t.me/higertech',
                'hover_class' => 'hover:bg-sky-500 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #229ED9;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',
            ],
            'github' => [
                'name' => 'GitHub',
                'color' => '#24292e',
                'placeholder' => 'https://github.com/higertech',
                'hover_class' => 'hover:bg-slate-800 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #24292e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>',
            ],
            'globe' => [
                'name' => 'Website / Portal',
                'color' => '#0891b2',
                'placeholder' => 'https://higertech.com',
                'hover_class' => 'hover:bg-cyan-600 hover:text-white',
                'icon' => '<svg class="w-5 h-5" style="color: #0891b2;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            ],
        ];
    }
}

if (!function_exists('setting_social_links')) {
    /**
     * Get list of active social media links with icons and styling metadata.
     *
     * @return array<int, array{platform: string, label: string, url: string, hover_class: string, icon: string}>
     */
    function setting_social_links(): array
    {
        $raw = setting('social_links');
        $platforms = social_platforms();

        if ($raw) {
            $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
            if (is_array($decoded) && !empty($decoded)) {
                $result = [];
                foreach ($decoded as $item) {
                    if (empty($item['url'])) {
                        continue;
                    }
                    $platKey = $item['platform'] ?? 'globe';
                    $meta = $platforms[$platKey] ?? $platforms['globe'];

                    $result[] = [
                        'platform' => $platKey,
                        'label' => $item['label'] ?? $meta['name'],
                        'url' => $item['url'],
                        'hover_class' => $meta['hover_class'],
                        'icon' => $meta['icon'],
                    ];
                }
                if (!empty($result)) {
                    return $result;
                }
            }
        }

        // Fallback to legacy individual settings
        $defaults = [
            [
                'platform' => 'whatsapp',
                'label' => 'WhatsApp',
                'url' => setting('social_whatsapp', 'https://wa.me/628112332182'),
            ],
            [
                'platform' => 'instagram',
                'label' => 'Instagram',
                'url' => setting('social_instagram', 'https://instagram.com'),
            ],
            [
                'platform' => 'linkedin',
                'label' => 'LinkedIn',
                'url' => setting('social_linkedin', 'https://linkedin.com'),
            ],
            [
                'platform' => 'youtube',
                'label' => 'YouTube',
                'url' => setting('social_youtube', 'https://youtube.com'),
            ],
        ];

        $result = [];
        foreach ($defaults as $def) {
            if ($def['url'] && $def['url'] !== '#') {
                $meta = $platforms[$def['platform']];
                $result[] = [
                    'platform' => $def['platform'],
                    'label' => $def['label'],
                    'url' => $def['url'],
                    'hover_class' => $meta['hover_class'],
                    'icon' => $meta['icon'],
                ];
            }
        }

        return $result;
    }
}

if (!function_exists('internship_tracks')) {
    /**
     * Get list of internship tracks/positions from site settings with fallback.
     *
     * @return array<string>
     */
    function internship_tracks(string $type = 'university'): array
    {
        $key = $type === 'vocational' ? 'internship_tracks_smk' : 'internship_tracks_univ';
        $settingValue = setting($key);

        if (!empty($settingValue)) {
            $lines = preg_split('/\r\n|\r|\n/', trim($settingValue));
            $tracks = array_values(array_filter(array_map('trim', $lines)));
            if (!empty($tracks)) {
                return $tracks;
            }
        }

        // Fallback default tracks if not configured in admin yet
        if ($type === 'vocational') {
            return [
                'Perakitan & Soldering Hardware IoT',
                'Wiring & Instalasi Panel Stasiun AWLR/AWS',
                'Teknisi Lapangan & Kalibrasi Sensor Telemetri',
                'Junior Web Developer (PHP / Laravel / HTML)',
                'Quality Control & Pengujian Modul Enjiniring',
                'Administrasi Teknik & Dokumentasi Proyek',
            ];
        }

        return [
            'IoT Embedded Firmware Engineer (C/C++, FreeRTOS, MODBUS)',
            'Hydrology & Sensor Field Engineer (Radar, AWLR, BMKG AWS)',
            'Web SCADA & GIS Telemetry Developer (Fullstack / Time-series)',
            'Hardware Electronics & PCB Design (KiCAD / Altium)',
            'Telemetry Data Analyst & Hydrometeorology QA',
        ];
    }
}

if (!function_exists('is_internship_enabled')) {
    /**
     * Check if the internship registration portal is currently open/enabled.
     */
    function is_internship_enabled(): bool
    {
        return (string) setting('internship_enabled', '1') === '1';
    }
}

if (!function_exists('whatsapp_url')) {
    /**
     * Get normalized WhatsApp URL from site settings.
     * Prioritizes 'contact_whatsapp', falls back to 'social_whatsapp' or default number.
     * Normalizes 08xx / +62xx to 62xx international format.
     */
    function whatsapp_url(?string $message = null): string
    {
        $rawNumber = setting('contact_whatsapp');

        if (empty($rawNumber)) {
            $socialWa = setting('social_whatsapp');
            if (!empty($socialWa) && str_starts_with($socialWa, 'http')) {
                return $socialWa . ($message ? (str_contains($socialWa, '?') ? '&text=' : '?text=') . urlencode($message) : '');
            }
            $rawNumber = '628112332182';
        }

        // If it's already a full URL (e.g. https://wa.me/...)
        if (str_starts_with((string) $rawNumber, 'http://') || str_starts_with((string) $rawNumber, 'https://')) {
            return $rawNumber . ($message ? (str_contains($rawNumber, '?') ? '&text=' : '?text=') . urlencode($message) : '');
        }

        // Clean non-digits
        $cleaned = preg_replace('/[^0-9]/', '', (string) $rawNumber);

        // Convert leading 0 to 62 (Indonesian standard)
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        $url = 'https://wa.me/' . ($cleaned ?: '628112332182');
        $defaultMsg = app()->getLocale() === 'en'
            ? 'Hello Higertech Technical Team, I would like to consult about telemetry systems.'
            : 'Halo Tim Teknis Higertech, saya ingin konsultasi mengenai sistem telemetri.';
        $finalMessage = $message ?? setting('contact_whatsapp_message', $defaultMsg);
        if (!empty($finalMessage)) {
            $url .= '?text=' . urlencode($finalMessage);
        }

        return $url;
    }
}

