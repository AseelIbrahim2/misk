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
            $menu['links'] = $this->repo->getLinks($menu['id']);
        }
        return $menus;
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): int
    {
        // Validation
        $data['name'] = trim($data['name'] ?? '');
        $data['title'] = trim($data['title'] ?? '');
        $data['location'] = trim($data['location'] ?? 'header');

        $allowedLocations = ['header', 'sidebar', 'footer'];
        if (!in_array($data['location'], $allowedLocations)) {
            throw new Exception('Invalid menu location.');
        }

        // Filter DB columns
        $allowedFields = ['name', 'title', 'created', 'updated', 'location'];
        $data = array_intersect_key($data, array_flip($allowedFields));


        if ($data['name'] === '' || $data['title'] === '') {
            throw new Exception('Name and Title are required.');
        }
        if (strlen($data['name']) > 100 || strlen($data['title']) > 150) {
            throw new Exception('Name or Title too long.');
        }

        // Timestamps
        $data['created'] = date('Y-m-d H:i:s');
        $data['updated'] = date('Y-m-d H:i:s');

        // Filter only allowed DB columns
        $allowedFields = ['name', 'title', 'created', 'updated'];
        $data = array_intersect_key($data, array_flip($allowedFields));

        return $this->repo->create($data);
    }

    public function update(int $id, array $data): bool
    {
        // Validation
        $data['name'] = trim($data['name'] ?? '');
        $data['title'] = trim($data['title'] ?? '');
        $data['location'] = trim($data['location'] ?? $existing['location'] ?? 'header');
        
        $allowedLocations = ['header', 'sidebar', 'footer'];
        if (!in_array($data['location'], $allowedLocations)) {
            throw new Exception('Invalid menu location.');
        }

        // Filter DB columns
        $allowedFields = ['name', 'title', 'updated', 'location'];
        $data = array_intersect_key($data, array_flip($allowedFields));


        if ($data['name'] === '' || $data['title'] === '') {
            throw new Exception('Name and Title are required.');
        }
        if (strlen($data['name']) > 100 || strlen($data['title']) > 150) {
            throw new Exception('Name or Title too long.');
        }

        // Updated timestamp
        $data['updated'] = date('Y-m-d H:i:s');

        // Filter only allowed DB columns
        $allowedFields = ['name', 'title', 'updated'];
        $data = array_intersect_key($data, array_flip($allowedFields));

        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
