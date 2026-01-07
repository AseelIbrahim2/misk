<?php

class Role extends BaseModel
{
    protected string $table = 'roles';

    // Get roles for a specific user
    public function getUserRoles(int $userId): array
    {
        $sql = "
            SELECT r.*
            FROM roles r
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = :user_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

