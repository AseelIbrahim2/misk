<?php
namespace App\Repositories;

use App\Models\MenuLink;

class MenuLinkRepository
{
    private MenuLink $model;

    public function __construct()
    {
        $this->model = new MenuLink();
    }

    public function getByMenu(int $menuId): array
    {
        return $this->model->getWhere('menu_id', $menuId, 'ORDER BY `order` ASC');
    }

    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    public function create(array $data): int
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }
}
