<?php

namespace App\Repositories;

use App\Models\News;
use App\Core\Database;
use PDO;

class NewsRepository
{
    private News $news;
    private PDO $db;

    public function __construct()
    {
        $this->news = new News();
        $this->db = Database::getInstance()->connection();
    }

    public function all(): array
    {
        return $this->news->getAll();
    }

    public function find(int $id): ?array
    {
        return $this->news->find($id);
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

    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM news WHERE user_id = :uid ORDER BY created DESC"
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
