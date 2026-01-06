<?php

class AuthService
{
    private UserRepository $userRepo;
    private UserService $userService;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->userService = new UserService();
    }

    /* -------------------------
       REGISTER
    ------------------------- */
    public function register(string $username, string $email, string $password): void
    {
        $username = trim($username);
        $email = trim(strtolower($email));

        if (strlen($username) < 3) {
            throw new Exception('Username must be at least 3 characters.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address.');
        }

        if (strlen($password) < 6) {
            throw new Exception('Password must be at least 6 characters.');
        }

        if ($this->userRepo->findUser($email) || $this->userRepo->findUser($username)) {
            throw new Exception('Username or Email already exists.');
        }

        $userId = $this->userRepo->createUser([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'status' => 'active',
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ]);

        // default role = user
        $this->userRepo->attachDefaultRole($userId, 1);
    }

    /* -------------------------
       LOGIN
    ------------------------- */
    public function login(string $value, string $password): void
    {
        $user = $this->userRepo->findUser(trim($value));

        if (!$user) {
            throw new Exception('User not found.');
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid credentials.');
        }

        if ($user['status'] !== 'active') {
            throw new Exception('Account inactive.');
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // ✅ delegation to UserService
        $roles = $this->userService->getUserWithRoles($user['id']);
        $permissions = $this->userService->getUserPermissions($user['id']);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'roles' => array_column($roles['roles'], 'name'),
            'permissions' => $permissions
        ];
    }

    /* -------------------------
       LOGOUT
    ------------------------- */
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
    }

    public function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION['user']);
    }
}
