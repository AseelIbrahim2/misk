<?php

namespace App\Repositories;

use App\Models\User;
use App\Core\Database;
use PDO;

class UserRepository
{
    private User $user;
    public PDO $db; 


    public function __construct()
    {
        $this->user = new User();
        $this->db = Database::getInstance()->connection();
    }

    /**
     * Find user by email or username
     */
    public function findUser(string $value): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :value OR username = :value LIMIT 1"
        );
        $stmt->execute(['value' => $value]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Find user by auth token
     */
    public function findUserByToken(string $token): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE auth_token = :token LIMIT 1"
        );
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Create new user
     */
    public function createUser(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, status, created, updated)
             VALUES (:username, :email, :password, :status, :created, :updated)"
        );

        $stmt->execute([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'status'   => $data['status'] ?? 'active',
            'created'  => $data['created'] ?? date('Y-m-d H:i:s'),
            'updated'  => $data['updated'] ?? date('Y-m-d H:i:s'),
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Assign default role to user
     */
    public function attachDefaultRole(int $userId, int $roleId = 1): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)"
        );
        $stmt->execute([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
    }

    /**
     * Get all users
     */
    public function all(): array
    {
        $stmt = $this->db->query("SELECT id, username, email FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Update user data
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        foreach (['username', 'email', 'password', 'status', 'auth_token'] as $key) {
            if (isset($data[$key])) {
                $fields[] = "$key = :$key";
                $params[$key] = $data[$key];
            }
        }

        if (empty($fields)) return false;

        $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated = :updated WHERE id = :id";
        $params['updated'] = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete user by ID
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function allWithRoles(): array
{
    $stmt = $this->db->query("
        SELECT u.id, u.username, u.email,
               GROUP_CONCAT(r.name) as roles
        FROM users u
        LEFT JOIN user_roles ur ON ur.user_id = u.id
        LEFT JOIN roles r ON r.id = ur.role_id
        GROUP BY u.id
        ORDER BY u.id DESC
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as &$user) {
        $user['roles'] = $user['roles'] ? explode(',', $user['roles']) : [];
    }

    return $users;
}
    public function syncRole(int $userId, int $roleId): void
    {
        $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?")
                ->execute([$userId]);

        $this->db->prepare(
            "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)"
        )->execute([$userId, $roleId]);
    }


}
