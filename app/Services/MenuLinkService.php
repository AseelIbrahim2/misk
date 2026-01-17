<?php
namespace App\Services;

use App\Repositories\MenuLinkRepository;

class MenuLinkService
{
    private MenuLinkRepository $repo;

    public function __construct()
    {
        $this->repo = new MenuLinkRepository();
    }

    public function getByMenu(int $menuId): array
    {
        return $this->repo->getByMenu($menuId);
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): int
    {
        // Validation
        $data['title'] = trim($data['title'] ?? '');
        $data['url'] = trim($data['url'] ?? '');
        if ($data['title'] === '' || $data['url'] === '') {
            throw new \Exception('Title and URL are required');
        }
        $data['order'] = (int)($data['order'] ?? 0);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['target'] = $data['target'] ?? '_self';
        $data['created'] = date('Y-m-d H:i:s');
        $data['updated'] = date('Y-m-d H:i:s');

        return $this->repo->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['title'] = trim($data['title'] ?? '');
        $data['url'] = trim($data['url'] ?? '');
        if ($data['title'] === '' || $data['url'] === '') {
            throw new \Exception('Title and URL are required');
        }
        $data['order'] = (int)($data['order'] ?? 0);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['target'] = $data['target'] ?? '_self';
        $data['updated'] = date('Y-m-d H:i:s');

        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
