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
        $roles = $this->roleRepo->getUserRoles($userId);

        return [
            'roles' => $roles
        ];
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

        // return unique permission names
        return array_keys($permissions);
    }
}
