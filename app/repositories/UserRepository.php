<?php

class UserRepository
{
    private User $user;
    private PDO $db;

    public function __construct()
    {
        $this->user = new User();
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
}
