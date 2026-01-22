<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository
{
    private Application $application;

    public function __construct()
    {
        $this->application = new Application();
    }

    public function all(): array
    {
        return $this->application->getAllOrdered();
    }

    public function find(int $id): ?array
    {
        return $this->application->find($id);
    }

    public function update(int $id, array $data): bool
    {
        return $this->application->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->application->delete($id);
    }
    public function create(array $data): int
{
    return $this->application->create($data);
}

}
