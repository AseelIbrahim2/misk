<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Core\Database;
use PDO;


class UserRepository
{
    private User $user;   // Instance of BaseModel User for CRUD operations
    private PDO $db;      // Direct PDO connection for custom queries

    public function __construct()
    {
        $this->user = new User();                          // Initialize User model
        $this->db = Database::getInstance()->connection(); // Get PDO connection
    }
    
    
    /**
     * Find user by email or username
     */
    public function findUser(string $value): ?array
    {
        return $this->user->findByEmailOrUsername($value); // Delegate to User model method
    }

    /**
     * Create new user
     */
    public function createUser(array $data): int
    {
        return $this->user->create($data); // Insert user and return new user ID
    }

    /**
     * Assign default role to user
     */
    public function attachDefaultRole(int $userId, int $roleId): void
    {
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES (:u, :r)";
        $this->db->prepare($sql)->execute([
            'u' => $userId, // Bind user ID
            'r' => $roleId  // Bind role ID
        ]);
    }

    /**
     * Get all users (id, username, email)
     */
    public function all(): array
    {
        $stmt = $this->db->query("SELECT id, username, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return array of users
    }

    /**
     * Find single user by ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);                       // Bind ID
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Return user or null
    }

    /**
     * Update user data
     */
    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            "UPDATE users 
             SET username = ?, 
                 email = ?, 
                 password = COALESCE(?, password) 
             WHERE id = ?"
        );
        $stmt->execute([
            $data['username'],         // New username
            $data['email'],            // New email
            $data['password'] ?? null, // New password if provided
            $id                        // Target user ID
        ]);
    }

    /**
     * Delete user by ID
     */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]); // Execute deletion
    }
}
