<?php
namespace App\Repositories;

use App\Models\Media;

class MediaRepository
{
    private Media $media;

    public function __construct()
    {
        $this->media = new Media();
    }

    public function all(): array
    {
        return $this->media->getWhere('is_deleted', 0);
    }

    public function create(array $data): int
    {
        return $this->media->create($data);
    }

    public function find(int $id): ?array
    {
        return $this->media->find($id);
    }

    public function softDelete(int $id): bool
    {
        return $this->media->update($id, [
            'is_deleted' => 1,
            'updated' => date('Y-m-d H:i:s')
        ]);
    }
}
