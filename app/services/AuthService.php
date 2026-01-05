<?php

class AuthService
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function register(string $username, string $email, string $password): void
    {
        $username = trim($username);
        $email    = trim(strtolower($email));

        if ($this->repo->findUser($email) || $this->repo->findUser($username)) {
            throw new Exception('Username or Email already exists');
        }

        $userId = $this->repo->createUser([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'status'   => 'active',
            'created'  => date('Y-m-d H:i:s'),
            'updated'  => date('Y-m-d H:i:s'),
        ]);

        // default role = user (id = 1)
        $this->repo->attachDefaultRole($userId, 1);
    }

    public function login(string $value, string $password): void
    {
        $user = $this->repo->findUser(trim($value));

        if (!$user) {
            throw new Exception('User not found');
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid credentials');
        }

        if ($user['status'] !== 'active') {
            throw new Exception('Account inactive');
        }

        // بدء الجلسة إذا لم تكن موجودة
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $roles = $this->repo->getUserRoles($user['id']);
        $permissions = $this->repo->getPermissionsByRoles($roles);

        // تعيين session المستخدم
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'roles' => array_column($roles, 'name'),
            'permissions' => $permissions
        ];

        // تعيين username بشكل مباشر لتسهيل الاستخدام في dashboard
        $_SESSION['username'] = $user['username'];
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

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
