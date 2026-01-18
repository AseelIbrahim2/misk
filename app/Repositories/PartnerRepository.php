<?php

namespace App\Repositories;

use App\Models\Partner;

class PartnerRepository
{
    private Partner $partner;

    public function __construct()
    {
        $this->partner = new Partner();
    }

    public function all(): array
    {
        return $this->partner->getAllWithMedia();
    }

    public function find(int $id): ?array
    {
        return $this->partner->findWithMedia($id);
    }

    public function create(array $data): int
    {
        return $this->partner->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->partner->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->partner->delete($id);
    }
}
