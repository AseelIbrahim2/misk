<?php
namespace App\Models;

use App\Core\Model;

class MenuLink extends Model
{
    protected string $table = 'menu_links';

    public function getLinksByMenu(int $menuId): array
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE menu_id = :menu_id AND is_active = 1
                ORDER BY `order` ASC";

        $links = $this->run($sql, ['menu_id' => $menuId])
                      ->fetchAll(\PDO::FETCH_ASSOC);

        return $this->buildTree($links);
    }

    private function buildTree(array $elements, $parentId = null): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                } else {
                    $element['children'] = [];
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}
