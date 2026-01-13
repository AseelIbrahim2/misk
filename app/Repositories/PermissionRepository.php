<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Core\Database;
use PDO;


class PermissionRepository
{
    private Permission $permission; // Instance of Permission model

    public function __construct()
    {
        $this->permission = new Permission(); // Initialize Permission model
    }

    /**
     * Get all permissions assigned to a role
     */
    public function getPermissionsByRole(int $roleId): array
    {
        // Delegate to Permission model method to fetch role permissions
        return $this->permission->getRolePermissions($roleId);
    }
}
