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

    public function all(): array
    {
        $stmt = $this->db->query("SELECT id, username, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET username = ?, email = ?, password = COALESCE(?, password) WHERE id = ?"
        );
        $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password'] ?? null,
            $id
        ]);
    }
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

}
