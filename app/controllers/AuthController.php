<?php



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

    /**
     * Login page
     */
    public function login(): void
    {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = $_POST['usernameOrEmail'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $userData = $this->authService->login($usernameOrEmail, $password);

                $_SESSION['user'] = [
                    'id'          => $userData['id'],
                    'username'    => $userData['username'],
                    'roles'       => $userData['roles'],
                    'permissions' => $userData['permissions']
                ];

                // ✅ Role-based redirect
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

        $this->view('auth/login');
    }

    /**
     * Register page
     */
    public function register(): void
    {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->authService->register($username, $email, $password);

                $userData = $this->authService->login($email, $password);

                $_SESSION['user'] = [
                    'id'          => $userData['id'],
                    'username'    => $userData['username'],
                    'roles'       => $userData['roles'],
                    'permissions' => $userData['permissions']
                ];

                // ✅ Role-based redirect (future-proof)
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

        $this->view('auth/register');
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        AuthMiddleware::protect();

        $_SESSION = [];

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

        session_destroy();

        header('Location: /auth/login');
        exit;
    }

    /**
     * User dashboard
     */
    public function dashboard(): void
    {
        AuthMiddleware::protect();

        $this->view('auth/dashboard', [
            'username' => $_SESSION['user']['username']
        ]);
    }
}
