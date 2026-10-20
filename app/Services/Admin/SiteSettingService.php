<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SiteSettingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    public const CACHE_KEY = 'site_settings.all';

    private ?array $memorySettings = null;

    public function __construct(private readonly SiteSettingRepository $repository) {}

    /**
     * @return array<string, string|null>
     */
    public function all(): array
    {
        if ($this->memorySettings !== null) {
            return $this->memorySettings;
        }

        try {
            return $this->memorySettings = Cache::rememberForever(
                self::CACHE_KEY,
                fn (): array => $this->repository->getAllKeyValue()
            );
        } catch (\Throwable $exception) {
            // Fall back to defaults for this request only; caching the failure would
            // hide every saved setting (and blank the admin form) until the cache is cleared.
            report($exception);

            return $this->memorySettings = [];
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateSettings(array $data): void
    {
        $this->repository->updateMany($data);
        $this->flushCache();
    }

    public function getAllModels(): Collection
    {
        return $this->repository->getAll();
    }

    public function flushCache(): void
    {
        $this->memorySettings = null;
        Cache::forget(self::CACHE_KEY);
    }
}
