<?php

namespace App\Services\Admin;

use App\Models\ClientPartner;
use App\Repositories\Admin\ClientPartnerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ClientPartnerService
{
    public const CACHE_KEY_ACTIVE = 'client_partners.active';

    private ?Collection $memoryActive = null;

    public function __construct(private readonly ClientPartnerRepository $repository) {}

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getActive(): Collection
    {
        if ($this->memoryActive !== null) {
            return $this->memoryActive;
        }

        try {
            $data = Cache::remember(self::CACHE_KEY_ACTIVE, 3600, function (): array {
                return $this->repository->getActive()->toArray();
            });

            if (is_array($data)) {
                $collection = new Collection();
                foreach ($data as $attributes) {
                    $model = new ClientPartner();
                    $model->setRawAttributes($attributes, true);
                    $collection->push($model);
                }

                return $this->memoryActive = $collection;
            }

            return $this->memoryActive = $this->repository->getActive();
        } catch (\Throwable) {
            return $this->memoryActive = new Collection();
        }
    }

    public function flushCache(): void
    {
        $this->memoryActive = null;
        Cache::forget(self::CACHE_KEY_ACTIVE);
    }

    public function findById(int $id): ?ClientPartner
    {
        return $this->repository->findById($id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data, ?UploadedFile $logoFile = null): ClientPartner
    {
        if ($logoFile) {
            $data['logo'] = $this->uploadLogo($logoFile);
        }

        if (empty($data['abbr'])) {
            $data['abbr'] = $this->generateAbbreviation($data['name'] ?? 'PU');
        }

        if (empty($data['color'])) {
            $data['color'] = 'bg-blue-600 text-white';
        }

        $created = $this->repository->create($data);
        $this->flushCache();

        return $created;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(ClientPartner $client, array $data, ?UploadedFile $logoFile = null): bool
    {
        if ($logoFile) {
            $this->deleteLogoFile($client->logo);
            $data['logo'] = $this->uploadLogo($logoFile);
        }

        $updated = $this->repository->update($client, $data);
        $this->flushCache();

        return $updated;
    }

    public function delete(ClientPartner $client): bool
    {
        $this->deleteLogoFile($client->logo);

        $deleted = $this->repository->delete($client);
        $this->flushCache();

        return $deleted;
    }

    public function uploadLogo(UploadedFile $file): string
    {
        return $file->store('clients', 'public');
    }

    public function deleteLogoFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/') && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function generateAbbreviation(string $name): string
    {
        $words = preg_split('/\s+/', trim($name));
        $abbr = '';
        foreach ($words as $w) {
            if (! empty($w)) {
                $abbr .= mb_substr($w, 0, 1);
            }
        }

        return mb_strtoupper(mb_substr($abbr ?: 'PU', 0, 6));
    }
}
