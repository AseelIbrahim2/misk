<?php
namespace App\Repositories;

use App\Models\News;

class NewsRepository
{
    private News $news;

    public function __construct()
    {
        $this->news = new News();
    }

    public function all(): array
    {
        return $this->news->getAllWithMedia();
    }

    public function find(int $id): ?array
    {
        return $this->news->findWithMedia($id);
    }

    public function create(array $data): int
    {
        return $this->news->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->news->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->news->delete($id);
    }
}
