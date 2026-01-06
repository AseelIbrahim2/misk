<?php

class PermissionRepository
{
    private Permission $permission;

    public function __construct()
    {
        $this->permission = new Permission();
    }

    public function getPermissionsByRole(int $roleId): array
    {
        return $this->permission->getRolePermissions($roleId);
    }
}
