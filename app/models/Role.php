<?php

class Role extends BaseModel
{
    protected string $table = 'roles';

    public function getUserRoles(int $userId): array
    {
        $sql = "
            SELECT r.*
            FROM roles r
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = :uid
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
