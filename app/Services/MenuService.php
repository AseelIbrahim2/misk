<?php
namespace App\Services;

use App\Repositories\MenuRepository;
use Exception;

class MenuService
{
    private MenuRepository $repo;

    public function __construct()
    {
        $this->repo = new MenuRepository();
    }

    public function list(): array
    {
        return $this->repo->all();
    }

    public function getMenuWithLinks(): array
    {
        $menus = $this->repo->all();
        foreach ($menus as &$menu) {
            $menu['links'] = $this->repo->getMenuWithLinks($menu['id']); 
        }
        return $menus;
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): int
    {
        $data['name'] = trim($data['name'] ?? '');
        $data['title'] = trim($data['title'] ?? '');
        $data['location'] = trim($data['location'] ?? 'header');

        $allowedLocations = ['header', 'sidebar', 'footer'];
        if (!in_array($data['location'], $allowedLocations)) {
            throw new Exception('Invalid menu location.');
        }

        $data['created'] = date('Y-m-d H:i:s');
        $data['updated'] = date('Y-m-d H:i:s');

        return $this->repo->create([
            'name' => $data['name'],
            'title' => $data['title'],
            'location' => $data['location'],
            'created' => $data['created'],
            'updated' => $data['updated']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $existing = $this->repo->find($id);
        if (!$existing) throw new Exception('Menu not found');

        $data['name'] = trim($data['name'] ?? $existing['name']);
        $data['title'] = trim($data['title'] ?? $existing['title']);
        $data['location'] = trim($data['location'] ?? $existing['location']);
        $data['updated'] = date('Y-m-d H:i:s');

        return $this->repo->update($id, [
            'name' => $data['name'],
            'title' => $data['title'],
            'location' => $data['location'],
            'updated' => $data['updated']
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
