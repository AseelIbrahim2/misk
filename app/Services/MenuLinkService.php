<?php
namespace App\Services;

use App\Repositories\MenuLinkRepository;
use App\Core\Validator;
use Exception;

class MenuLinkService
{
    private MenuLinkRepository $repo;
    private Validator $validator;

    public function __construct()
    {
        $this->repo = new MenuLinkRepository();
        $this->validator = new Validator();
    }

    public function getByMenu(int $menuId): array
    {
        return $this->repo->getByMenu($menuId);
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(int $menuId, array $data): int
    {
        unset($data['csrf_token']);
        $data['title'] = trim($data['title'] ?? '');
        $data['url'] = trim($data['url'] ?? '');
        $data['parent_id'] = (!empty($data['parent_id'])) ? (int)$data['parent_id'] : null;
        $data['order'] = (int)($data['order'] ?? 0);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['target'] = $data['target'] ?? '_self';
        $data['menu_id'] = $menuId;

        $this->validator->required('title', $data['title']);
        $this->validator->required('url', $data['url']);

        if ($this->validator->fails()) {
            throw new Exception(json_encode($this->validator->errors()));
        }

        return $this->repo->create($data);
    }

    public function update(int $id, array $data): bool
    {
        unset($data['csrf_token']);
        $existing = $this->getById($id);
        if (!$existing) throw new Exception('Link not found');

        $data['title'] = trim($data['title'] ?? $existing['title']);
        $data['url'] = trim($data['url'] ?? $existing['url']);
        $data['parent_id'] = (!empty($data['parent_id'])) ? (int)$data['parent_id']  : null;

        $data['order'] = (int)($data['order'] ?? $existing['order']);
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['target'] = $data['target'] ?? $existing['target'];
        $data['menu_id'] = $existing['menu_id'];

        $this->validator->required('title', $data['title']);
        $this->validator->required('url', $data['url']);

        if ($this->validator->fails()) {
            throw new Exception(json_encode($this->validator->errors()));
        }

        return $this->repo->update($id, $data);
    }

    public function delete(int $id): int
    {
        $link = $this->getById($id);
        if (!$link) throw new Exception('Link not found');

        $this->repo->delete($id);
        return $link['menu_id'];
    }
}
