<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Core\Validator;
use Exception;

class UserService
{
    private UserRepository $userRepo;
    private RoleRepository $roleRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->roleRepo = new RoleRepository();
    }

    public function createUser(array $data): void
    {
        $validator = new Validator();

        // sanitize
        $data['username'] = $validator->sanitize($data['username'] ?? '');
        $data['email']    = $validator->sanitize(strtolower($data['email'] ?? ''));
        $data['password'] = $validator->sanitize($data['password'] ?? '');
        $data['role_id']  = (int)($data['role_id'] ?? 0);

        // validation
        $validator->required('username', $data['username']);
        $validator->min('username', $data['username'], 3);
        $validator->required('email', $data['email']);
        $validator->email('email', $data['email']);
        $validator->required('password', $data['password']);
        $validator->password('password', $data['password'], 6);
        $validator->required('role_id', $data['role_id']);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        if ($this->userRepo->findUser($data['email']) || $this->userRepo->findUser($data['username'])) {
            throw new Exception(json_encode([
                'general' => ['Username or Email already exists']
            ]));
        }

        $userId = $this->userRepo->createUser([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'status'   => 'active'
        ]);

        // attach role
        $this->userRepo->syncRole($userId, $data['role_id']);
    }

    public function updateUser(int $id, array $data): void
    {
        $validator = new Validator();

        if (isset($data['username'])) {
            $data['username'] = $validator->sanitize($data['username']);
            $validator->min('username', $data['username'], 3);
        }

        if (isset($data['email'])) {
            $data['email'] = $validator->sanitize(strtolower($data['email']));
            $validator->email('email', $data['email']);
        }

        if (!empty($data['password'])) {
            $data['password'] = $validator->sanitize($data['password']);
            $validator->password('password', $data['password'], 6);
        } else {
            unset($data['password']);
        }

        if (isset($data['role_id'])) {
            $data['role_id'] = (int)$data['role_id'];
        }

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $this->userRepo->update($id, $data);

        if (isset($data['role_id'])) {
            $this->userRepo->syncRole($id, $data['role_id']);
        }
    }

    public function getAllUsers(): array
    {
        return $this->userRepo->allWithRoles();
    }

    public function getUser(int $id): ?array
    {
        return $this->userRepo->find($id);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepo->delete($id);
    }

    public function getAllRoles(): array
    {
        return $this->roleRepo->all();
    }

    public function getUserRoleId(int $userId): ?int
    {
        return $this->roleRepo->getUserRoleId($userId);
    }
}
