<?php

class UserService
{
    private UserRepository $userRepo;
    private RoleRepository $roleRepo;
    private PermissionRepository $permissionRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->roleRepo = new RoleRepository();
        $this->permissionRepo = new PermissionRepository();
    }

    /**
     * Get user data with roles
     */
    public function getUserWithRoles(int $userId): array
    {
        $user = $this->userRepo->find($userId);
        if (!$user) {
            throw new Exception("User not found");
        }

        // جلب الأدوار الخاصة بالمستخدم
        $roles = $this->roleRepo->getUserRoles($userId);
        $user['roles'] = array_column($roles, 'name'); // نضمن أن كل دور عبارة عن string

        return $user;
    }

    /**
     * Get user permissions based on roles
     */
    public function getUserPermissions(int $userId): array
    {
        $roles = $this->roleRepo->getUserRoles($userId);
        $permissions = [];

        foreach ($roles as $role) {
            $rolePermissions = $this->permissionRepo->getPermissionsByRole($role['id']);
            foreach ($rolePermissions as $permission) {
                $permissions[$permission['name']] = true;
            }
        }

        return array_keys($permissions);
    }

    /**
     * Get all users with roles
     */
    public function getAllUsers(): array
    {
        $users = $this->userRepo->all();

        // أضف كل الأدوار لكل مستخدم
        foreach ($users as &$user) {
            $roles = $this->roleRepo->getUserRoles($user['id']);
            $user['roles'] = array_column($roles, 'name'); // array of role names
        }

        return $users;
    }

    public function getUser(int $id): array
    {
        $user = $this->getUserWithRoles($id); // استخدام الدالة المعدلة
        return $user;
    }

    public function createUser(array $data): void
    {
        if (empty($data['password'])) {
            throw new Exception("Password required");
        }
        $this->userRepo->createUser($data);
    }

    public function updateUser(int $id, array $data): void
    {
        $this->userRepo->update($id, $data);
    }

    public function deleteUser(int $id): void
    {
        $this->userRepo->delete($id);
    }
}
