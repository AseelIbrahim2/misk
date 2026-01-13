<?php

namespace App\Models;
use App\Core\Model; 
use PDO;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmailOrUsername(string $value): ?array
    {
        $sql = "
            SELECT * 
            FROM {$this->table} 
            WHERE email = :v OR username = :v 
            LIMIT 1
        ";

        return $this->run($sql, ['v' => $value])->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
