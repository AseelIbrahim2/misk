<?php

namespace App\Models;

use App\Core\Model; 
use PDO;

class Role extends Model
{
    protected string $table = 'roles';

    public function getUserRoles(int $userId): array
    {
        $sql = "
            SELECT r.*
            FROM {$this->table} r
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = :user_id
        ";

        return $this->run($sql, ['user_id' => $userId])
                    ->fetchAll(PDO::FETCH_ASSOC);
    }
}
