<?php

namespace App\Repositories\Admin;

use App\Models\ClientPartner;
use Illuminate\Database\Eloquent\Collection;

class ClientPartnerRepository
{
    public function getAll(): Collection
    {
        return ClientPartner::orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getActive(): Collection
    {
        return ClientPartner::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function findById(int $id): ?ClientPartner
    {
        return ClientPartner::find($id);
    }

    public function create(array $data): ClientPartner
    {
        return ClientPartner::create($data);
    }

    public function update(ClientPartner $client, array $data): bool
    {
        return $client->update($data);
    }

    public function delete(ClientPartner $client): bool
    {
        return (bool) $client->delete();
    }
}

