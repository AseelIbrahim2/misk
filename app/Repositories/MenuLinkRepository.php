<?php
namespace App\Repositories;

use App\Models\MenuLink;
use PDOException;

class MenuLinkRepository
{
    private MenuLink $link;

    public function __construct()
    {
        $this->link = new MenuLink();
    }

    public function all(): array
    {
        return $this->link->getAll();
    }

    public function getByMenu(int $menuId): array
    {
        return $this->link->getWhere('menu_id', $menuId);
    }

    public function find(int $id): ?array
    {
        return $this->link->find($id);
    }

    public function create(array $data): int
    {
        try {
            return $this->link->create($data);
        } catch (PDOException $e) {
            throw new PDOException("MenuLinkRepository create error: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            return $this->link->update($id, $data);
        } catch (PDOException $e) {
            throw new PDOException("MenuLinkRepository update error: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        return $this->link->delete($id);
    }
}
