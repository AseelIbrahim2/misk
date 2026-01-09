<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Role extends BaseModel
{
    protected string $table = 'roles'; // Table name in DB

    /**
     * Get all roles assigned to a specific user
     * @param int $userId User ID
     * @return array Array of roles
     */
    public function getUserRoles(int $userId): array
    {
        // Prepare SQL to join roles with user_roles table
        $sql = "
            SELECT r.*
            FROM {$this->table} r
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = :user_id
        ";

        $stmt = $this->db->prepare($sql);      // Prepare query
        $stmt->execute(['user_id' => $userId]); // Bind parameter and execute

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all matching roles
    }
}
