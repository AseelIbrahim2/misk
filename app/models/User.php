<?php

class User extends BaseModel
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

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['v' => $value]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
