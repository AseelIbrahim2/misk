<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Core\Database;
use PDO;


class RoleRepository
{
    private Role $role; // Instance of Role model

    public function __construct()
    {
        $this->role = new Role(); // Initialize Role model
    }

    /**
     * Get all roles assigned to a specific user
     */
    public function getUserRoles(int $userId): array
    {
        // Delegate to Role model method to fetch user's roles
        return $this->role->getUserRoles($userId);
    }
}
