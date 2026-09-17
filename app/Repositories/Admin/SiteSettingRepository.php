<?php

namespace App\Repositories\Admin;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Collection;

class SiteSettingRepository
{
    public function getAll(): Collection
    {
        return SiteSetting::all();
    }

    /**
     * @return array<string, string|null>
     */
    public function getAllKeyValue(): array
    {
        return SiteSetting::pluck('value', 'key')->toArray();
    }

    public function findByKey(string $key): ?SiteSetting
    {
        return SiteSetting::where('key', $key)->first();
    }

    public function set(string $key, ?string $value, string $group = 'general', string $type = 'text'): SiteSetting
    {
        return SiteSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function updateMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}

