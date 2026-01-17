<?php
namespace App\Repositories;

use App\Models\Statistic;

class StatisticRepository
{
    private Statistic $stat;

    public function __construct()
    {
        $this->stat = new Statistic();
    }

    public function all(): array
    {
        return $this->stat->getAll();
    }

    public function find(int $id): ?array
    {
        return $this->stat->find($id);
    }

    public function create(array $data): int
    {
        return $this->stat->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->stat->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->stat->delete($id);
    }
        public function findBy(string $column, mixed $value): ?array
    {
        return $this->stat->findBy($column, $value);
    }

    public function exists(string $column, mixed $value): bool
    {
        return $this->stat->exists($column, $value);
    }
}
