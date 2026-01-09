<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Exception;


class AuthService
{
    private UserRepository $userRepo;  // Handles DB queries for users
    private UserService $userService;  // Handles business logic (roles & permissions)

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->userService = new UserService();
    }

    /* -------------------------
       REGISTER
       Validate input, create user, attach default role
    ------------------------- */
    public function register(string $username, string $email, string $password): void
    {
        $username = trim($username);               // Remove extra spaces
        $email = trim(strtolower($email));        // Lowercase email for consistency

        // Validate username length
        if (strlen($username) < 3) {
            throw new Exception('Username must be at least 3 characters.');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address.');
        }

        // Validate password length
        if (strlen($password) < 6) {
            throw new Exception('Password must be at least 6 characters.');
        }

        // Check if username or email already exists
        if ($this->userRepo->findUser($email) || $this->userRepo->findUser($username)) {
            throw new Exception('Username or Email already exists.');
        }

        // Create user in database with hashed password
        $userId = $this->userRepo->createUser([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'status' => 'active',
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ]);

        // Attach default role (user role id = 1)
        $this->userRepo->attachDefaultRole($userId, 1);
    }

    /* -------------------------
       LOGIN
       Validate credentials, return user data with roles & permissions
    ------------------------- */
    public function login(string $value, string $password): array
    {
        // Find user by username or email
        $user = $this->userRepo->findUser(trim($value));

        if (!$user) {
            // User not found in DB
            throw new Exception('User not found.');
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid credentials.');
        }

        // Check if account is active
        if ($user['status'] !== 'active') {
            throw new Exception('Account inactive.');
        }

        // Fetch roles and permissions
        $rolesData = $this->userService->getUserWithRoles($user['id']);
        $permissions = $this->userService->getUserPermissions($user['id']);

        // Return user data including roles & permissions
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'roles' => $rolesData['roles'],       // Array of role names
            'permissions' => $permissions        // Array of permission names
        ];
    }

    /* -------------------------
       LOGOUT
       Clear session data and destroy session
    ------------------------- */
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];       // Remove all session variables
        session_destroy();    // End session
    }

    /* -------------------------
       CHECK
       Helper: return true if user is logged in
    ------------------------- */
    public function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION['user']); // true if logged-in
    }
}
