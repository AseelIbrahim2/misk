<?php

class RoleRepository
{
    private Role $role;

    public function __construct()
    {
        $this->role = new Role();
    }

    public function getUserRoles(int $userId): array
    {
        return $this->role->getUserRoles($userId);
    }
}
