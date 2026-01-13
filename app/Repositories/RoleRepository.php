<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class RoleRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->connection();
    }

    public function all(): array
    {
        return $this->db->query("SELECT * FROM roles ORDER BY name")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRoleId(int $userId): ?int
    {
        $stmt = $this->db->prepare(
            "SELECT role_id FROM user_roles WHERE user_id = :id LIMIT 1"
        );
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['role_id'] : null;
    }
}
