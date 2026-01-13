<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Validator;
use Exception;

class AuthService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /* -------------------------
       REGISTER
    ------------------------- */
    public function register(string $username, string $email, string $password): array
    {
        $validator = new Validator();

        // Sanitization
        $username = $validator->sanitize($username);
        $email = $validator->sanitize(strtolower($email));
        $password = $validator->sanitize($password);

        // Validation rules
        $validator->required('username', $username);
        $validator->min('username', $username, 3);
        $validator->required('email', $email);
        $validator->email('email', $email);
        $validator->required('password', $password);
        $validator->password('password', $password, 6);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        // Check if user exists
        if ($this->userRepo->findUser($email) || $this->userRepo->findUser($username)) {
            throw new Exception('Username or Email already exists.');
        }

        // Create user
        $userId = $this->userRepo->createUser([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'status'   => 'active'
        ]);

        // Attach default role
        $this->userRepo->attachDefaultRole($userId, 1);

        // Generate Auth Token
        $authToken = bin2hex(random_bytes(32));
        $this->userRepo->update($userId, ['auth_token' => $authToken]);

        // Fetch Roles and Permissions
        $userRoles = $this->getRoles($userId);
        $userPermissions = $this->getPermissions($userId);

        // Store in session
      // Store in session
        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
            'auth_token' => $authToken,
            'roles' => $userRoles ?: [],     
            'permissions' => $userPermissions ?: [] 
        ];


        return $_SESSION['user'];
    }

    /* -------------------------
       LOGIN
    ------------------------- */
    public function login(string $value, string $password): array
    {
        $validator = new Validator();
        $value = $validator->sanitize($value);
        $password = $validator->sanitize($password);

        $validator->required('value', $value);
        $validator->required('password', $password);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $user = $this->userRepo->findUser($value);

        if (!$user) throw new Exception('User not found.');
        if (!password_verify($password, $user['password'])) throw new Exception('Invalid credentials.');
        if ($user['status'] !== 'active') throw new Exception('Account inactive.');

        // Generate new Auth Token
        $authToken = bin2hex(random_bytes(32));
        $this->userRepo->update($user['id'], ['auth_token' => $authToken]);

        // Fetch Roles and Permissions
        $userRoles = $this->getRoles($user['id']);
        $userPermissions = $this->getPermissions($user['id']);

        // Store in session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'auth_token' => $authToken,
            'roles' => $userRoles ?: [],
            'permissions' => $userPermissions ?: []
        ];


        return $_SESSION['user'];
    }

    /* -------------------------
       LOGOUT
    ------------------------- */
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION = [];
        session_destroy();
    }

    /* -------------------------
       CHECK LOGIN
    ------------------------- */
    public function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return isset($_SESSION['user']['auth_token']);
    }

    /* -------------------------
       PRIVATE HELPERS
    ------------------------- */
    private function getRoles(int $userId): array
    {
        $stmt = $this->userRepo->db->prepare(
            "SELECT r.name FROM roles r
             JOIN user_roles ur ON ur.role_id = r.id
             WHERE ur.user_id = :uid"
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function getPermissions(int $userId): array
    {
        $stmt = $this->userRepo->db->prepare(
            "SELECT p.name FROM permissions p
             JOIN role_permissions rp ON rp.permission_id = p.id
             JOIN user_roles ur ON ur.role_id = rp.role_id
             WHERE ur.user_id = :uid"
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
