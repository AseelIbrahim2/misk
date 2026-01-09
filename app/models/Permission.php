<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Permission extends BaseModel
{
    protected string $table = 'permissions'; // Table name in DB

    /**
     * Get all permissions assigned to a specific role
     * @param int $roleId Role ID
     * @return array Array of permissions
     */
    public function getRolePermissions(int $roleId): array
    {
        // Prepare SQL to join permissions with role_permissions table
        $sql = "
            SELECT p.*
            FROM {$this->table} p
            INNER JOIN role_permissions rp ON rp.permission_id = p.id
            WHERE rp.role_id = :role_id
        ";

        $stmt = $this->db->prepare($sql);        // Prepare query
        $stmt->execute(['role_id' => $roleId]);  // Bind parameter and execute

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all matching permissions
    }
}
