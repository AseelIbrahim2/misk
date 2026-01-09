<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Exception;


class UserService
{
    private UserRepository $userRepo;       // Handles DB operations for users
    private RoleRepository $roleRepo;       // Handles DB operations for roles
    private PermissionRepository $permissionRepo; // Handles DB operations for permissions

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->roleRepo = new RoleRepository();
        $this->permissionRepo = new PermissionRepository();
    }

    /**
     * Get user data along with assigned roles
     */
    public function getUserWithRoles(int $userId): array
    {
        $user = $this->userRepo->find($userId);  // Get user from DB
        if (!$user) {
            throw new Exception("User not found"); // Stop if user doesn't exist
        }

        // Get all roles of the user
        $roles = $this->roleRepo->getUserRoles($userId);

        // Convert role objects to simple array of role names
        $user['roles'] = array_column($roles, 'name');

        return $user; // Return user with roles
    }

    /**
     * Get all permissions assigned to a user via roles
     */
    public function getUserPermissions(int $userId): array
    {
        $roles = $this->roleRepo->getUserRoles($userId); // Get user's roles
        $permissions = [];

        foreach ($roles as $role) {
            // Get permissions for each role
            $rolePermissions = $this->permissionRepo->getPermissionsByRole($role['id']);
            foreach ($rolePermissions as $permission) {
                $permissions[$permission['name']] = true; // Use key to avoid duplicates
            }
        }

        return array_keys($permissions); // Return list of permission names
    }

    /**
     * Get all users with their roles
     */
    public function getAllUsers(): array
    {
        $users = $this->userRepo->all(); // Fetch all users from DB

        // Add roles to each user
        foreach ($users as &$user) {
            $roles = $this->roleRepo->getUserRoles($user['id']); // Get roles for user
            $user['roles'] = array_column($roles, 'name');       // Convert to array of strings
        }

        return $users; // Return all users with roles
    }

    /**
     * Get single user by ID with roles
     */
    public function getUser(int $id): array
    {
        return $this->getUserWithRoles($id); // Reuse function to include roles
    }

    /**
     * Create a new user
     */
    public function createUser(array $data): void
    {
        if (empty($data['password'])) {
            throw new Exception("Password required"); // Password is mandatory
        }

        $this->userRepo->createUser($data); // Save user in DB
    }

    /**
     * Update existing user data
     */
    public function updateUser(int $id, array $data): void
    {
        $this->userRepo->update($id, $data); // Update user record in DB
    }

    /**
     * Delete a user
     */
    public function deleteUser(int $id): void
    {
        $this->userRepo->delete($id); // Remove user from DB
    }
}
