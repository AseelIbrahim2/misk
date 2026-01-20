<?php
namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuLink;
use PDO;
use PDOException;

class MenuRepository
{
    private Menu $menu;
    private MenuLink $link;

    public function __construct()
    {
        $this->menu = new Menu();
        $this->link = new MenuLink();
    }

    public function all(): array
    {
        return $this->menu->getAll();
    }

    public function find(int $id): ?array
    {
        return $this->menu->find($id);
    }

    public function create(array $data): int
    {
        try {
            return $this->menu->create($data);
        } catch (PDOException $e) {
            throw new PDOException("MenuRepository create error: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            return $this->menu->update($id, $data);
        } catch (PDOException $e) {
            throw new PDOException("MenuRepository update error: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        return $this->menu->delete($id);
    }

    public function getLinks(int $menuId): array
    {
        return $this->link->getWhere('menu_id', $menuId);
    }

    
    
}
