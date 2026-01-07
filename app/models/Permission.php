<?php

class Permission extends BaseModel
{
    protected string $table = 'permissions';

    // Get permissions for a specific role
    public function getRolePermissions(int $roleId): array
    {
        $sql = "
            SELECT p.*
            FROM permissions p
            INNER JOIN role_permissions rp ON rp.permission_id = p.id
            WHERE rp.role_id = :role_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role_id' => $roleId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

