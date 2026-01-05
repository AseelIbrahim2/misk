<?php

class Permission extends BaseModel
{
    protected string $table = 'permissions';

    public function getRolePermissions(int $roleId): array
    {
        $sql = "
            SELECT p.*
            FROM permissions p
            INNER JOIN role_permissions rp ON rp.permission_id = p.id
            WHERE rp.role_id = :rid
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['rid' => $roleId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
