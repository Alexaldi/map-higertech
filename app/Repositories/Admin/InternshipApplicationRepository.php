<?php

namespace App\Repositories\Admin;

use App\Models\InternshipApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipApplicationRepository
{
    /**
     * Get paginated applications with filters.
     *
     * @param array<string, mixed> $filters
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = InternshipApplication::query();

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = '%' . trim($filters['search']) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('identity_number', 'like', $search)
                    ->orWhere('institution', 'like', $search)
                    ->orWhere('phone', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        return $query->with('members')->latest()->paginate($perPage)->withQueryString();
    }

    public function findById(int $id): ?InternshipApplication
    {
        return InternshipApplication::find($id);
    }

    public function findByIdentityNumber(string $identityNumber): ?InternshipApplication
    {
        return InternshipApplication::where('identity_number', $identityNumber)->latest()->first();
    }

    public function findByPhoneOrEmail(string $keyword): ?InternshipApplication
    {
        return InternshipApplication::where('phone', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->latest()
            ->first();
    }

    public function create(array $data): InternshipApplication
    {
        return InternshipApplication::create($data);
    }

    public function update(InternshipApplication $application, array $data): bool
    {
        return $application->update($data);
    }

    public function updateStatus(InternshipApplication $application, string $status, ?string $notes = null): bool
    {
        $data = ['status' => $status];
        if ($notes !== null) {
            $data['notes'] = $notes;
        }

        return $application->update($data);
    }

    public function delete(InternshipApplication $application): bool
    {
        return (bool) $application->delete();
    }

    /**
     * @return array<string, int>
     */
    public function getCounts(): array
    {
        $all = InternshipApplication::selectRaw("
            count(*) as total,
            sum(case when type = 'university' then 1 else 0 end) as university,
            sum(case when type = 'vocational' then 1 else 0 end) as vocational,
            sum(case when status = 'pending' then 1 else 0 end) as pending,
            sum(case when status = 'reviewing' then 1 else 0 end) as reviewing,
            sum(case when status = 'accepted' then 1 else 0 end) as accepted,
            sum(case when status = 'rejected' then 1 else 0 end) as rejected
        ")->first();

        return [
            'all' => (int) ($all->total ?? 0),
            'university' => (int) ($all->university ?? 0),
            'vocational' => (int) ($all->vocational ?? 0),
            'pending' => (int) ($all->pending ?? 0),
            'reviewing' => (int) ($all->reviewing ?? 0),
            'accepted' => (int) ($all->accepted ?? 0),
            'rejected' => (int) ($all->rejected ?? 0),
        ];
    }
}

