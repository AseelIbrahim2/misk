

<?php
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Permission.php';


class  UserRepository
{
    private User $user;
    private Role $role;
    private Permission $permission;
    private PDO $db;

    public function __construct()
    {
        $this->user = new User();
        $this->role = new Role();
        $this->permission = new Permission();
        $this->db = Database::getInstance()->connection();
    }

    public function findUser(string $value): ?array
    {
        return $this->user->findByEmailOrUsername($value);
    }

    public function createUser(array $data): int
    {
        return $this->user->create($data);
    }

    public function attachDefaultRole(int $userId, int $roleId): void
    {
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES (:u, :r)";
        $this->db->prepare($sql)->execute([
            'u' => $userId,
            'r' => $roleId
        ]);
    }

    public function getUserRoles(int $userId): array
    {
        return $this->role->getUserRoles($userId);
    }

    public function getPermissionsByRoles(array $roles): array
    {
        $permissions = [];

        foreach ($roles as $role) {
            $perms = $this->permission->getRolePermissions($role['id']);
            foreach ($perms as $perm) {
                $permissions[$perm['name']] = true;
            }
        }

        return array_keys($permissions);
    }
}
