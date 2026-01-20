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
        
        $links = $this->run($sql, ['menu_id' => $menuId])->fetchAll(\PDO::FETCH_ASSOC);

     
        $linksById = [];
        foreach ($links as $link) {
            $link['children'] = [];
            $linksById[$link['id']] = $link;
        }

    
        foreach ($linksById as $id => $link) {
            if ($link['parent_id'] !== null && isset($linksById[$link['parent_id']])) {
                $linksById[$link['parent_id']]['children'][] = $link;
                unset($linksById[$id]);
            }
        }

        return array_values($linksById);
    }
}
