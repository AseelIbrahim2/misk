<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use Exception;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }


    // Display login page and handle login POST
public function login(): void
{
    AuthMiddleware::guest(); // Only guests can access

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        CsrfMiddleware::protect(); 
        $usernameOrEmail = $_POST['usernameOrEmail'] ?? '';
        $password = $_POST['password'] ?? '';

        try {
            $userData = $this->authService->login($usernameOrEmail, $password);

            // Role-based redirect
            if (in_array('admin', $_SESSION['user']['roles'])) {
                header('Location: /admin/dashboard');
                exit;
            }

            header('Location: /auth/dashboard');
            exit;

        } catch (Exception $e) {
            $this->view('auth/login', ['error' => $e->getMessage()]);
            return;
        }
    }

    $this->view('auth/login'); // Show login form
}


    // Display registration page and handle POST
    public function register(): void
    {
        AuthMiddleware::guest(); // Only guests can access

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->authService->register($username, $email, $password);

                $userData = $this->authService->login($email, $password);

                // Store user data in session
                $_SESSION['user'] = [
                    'id'          => $userData['id'],
                    'username'    => $userData['username'],
                    'roles'       => $userData['roles'],
                    'permissions' => $userData['permissions']
                ];

                // Role-based redirect
                if (in_array('admin', $_SESSION['user']['roles'])) {
                    header('Location: /admin/dashboard');
                    exit;
                }

                header('Location: /auth/dashboard');
                exit;

            } catch (Exception $e) {
                $this->view('auth/register', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view('auth/register'); // Show registration form
    }

    // Logout user and destroy session
    public function logout(): void
    {
        AuthMiddleware::protect(); // Only logged-in users can access

        $_SESSION = []; // Clear session data

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy(); // Destroy session

        header('Location: /auth/login'); // Redirect to login
        exit;
    }

    // Show user dashboard
    public function dashboard(): void
    {
        AuthMiddleware::protect(); // Only logged-in users

        $this->view('auth/dashboard', [
            'username' => $_SESSION['user']['username']
        ]);
    }
}
