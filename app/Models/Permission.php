<?php

namespace App\Models;

use App\Core\Model; 
use PDO;

class Permission extends Model
{
    protected string $table = 'permissions';

    public function getRolePermissions(int $roleId): array
    {
        $sql = "
            SELECT p.*
            FROM {$this->table} p
            INNER JOIN role_permissions rp ON rp.permission_id = p.id
            WHERE rp.role_id = :role_id
        ";

        return $this->run($sql, ['role_id' => $roleId])
                    ->fetchAll(PDO::FETCH_ASSOC);
    }
}
